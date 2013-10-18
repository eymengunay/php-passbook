<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook;

use ZipArchive;
use SplFileObject;
use Passbook\PassInterface;
use Passbook\Certificate\P12;
use Passbook\Certificate\WWDR;
use Passbook\Exception\FileException;
use JMS\Serializer\SerializerBuilder;

/**
 * PassFactory - Creates .pkpass files
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class PassFactory
{
    /**
     * Output path for generated pass files
     * @var string
     */
    protected $outputPath = '';

    /**
     * Override if pass exists
     * @var bool
     */
    protected $override = false;

    /**
     * Pass type identifier
     * @var string
     */
    protected $passTypeIdentifier;

    /**
     * Team identifier
     * @var string
     */
    protected $teamIdentifier;

    /**
     * Organization name
     * @var string
     */
    protected $organizationName;

    /**
     * P12 file
     * @var Passbook\Certificate\P12
     */
    protected $p12;

    /**
     * WWDR file
     * @var Passbook\Certificate\WWDR
     */
    protected $wwdr;

    /**
     * Pass file extension
     * @var string
     */
    const PASS_EXTENSION = '.pkpass';

    public function __construct($passTypeIdentifier, $teamIdentifier, $organizationName, $p12File, $p12Pass, $wwdrFile)
    {
        // Required pass information
        $this->passTypeIdentifier = $passTypeIdentifier;
        $this->teamIdentifier     = $teamIdentifier;
        $this->organizationName   = $organizationName;
        // Create certificate objects
        $this->p12  = new P12($p12File, $p12Pass);
        $this->wwdr = new WWDR($wwdrFile);
    }

    /**
     * Set outputPath
     * @param string
     */
    public function setOutputPath($outputPath)
    {
        $this->outputPath = $outputPath;
        return $this;
    }

    /**
     * Get outputPath
     * @return string
     */
    public function getOutputPath()
    {
        return $this->outputPath;
    }

    /**
     * Set override
     * @param string
     */
    public function setOverride($override)
    {
        $this->override = $override;
        return $this;
    }

    /**
     * Get override
     * @return string
     */
    public function getOverride()
    {
        return $this->override;
    }

    /**
     * Serialize pass
     *
     * @param  Passbook\PassInterface $pass
     * @param  string $format
     * @return string
     */
    public static function serialize(PassInterface $pass, $format = 'json')
    {
        return SerializerBuilder::create()->build()->serialize($pass, $format);
    }

    /**
     * Creates a pkpass file
     *
     * @param  Passbook\PassInterface $pass
     * @throws FileException If an IO error occurred
     * @return SplFileObject
     */
    public function package(PassInterface $pass)
    {
        $pass->setPassTypeIdentifier($this->passTypeIdentifier);
        $pass->setTeamIdentifier($this->teamIdentifier);
        $pass->setOrganizationName($this->organizationName);

        // Serialize pass
        $json = self::serialize($pass, 'json');

        $outputPath = rtrim($this->getOutputPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $passDir = $outputPath . $pass->getSerialNumber() . DIRECTORY_SEPARATOR;
        $passDirExists = file_exists($passDir);
        if ($passDirExists && !$this->getOverride()) {
            throw new FileException("Temporary pass directory already exists");
        } elseif (!$passDirExists && !mkdir($passDir, 0777, true)) {
            throw new FileException("Couldn't create temporary pass directory");
        }

        // Pass.json
        $passJSONFile = $passDir . 'pass.json';
        file_put_contents($passJSONFile, $json);

        // Images
        foreach ($pass->getImages() as $image) {
            $fileName = $passDir . $image->getContext();
            if ($image->getIsRetina()) $fileName .= '@2x';
            $fileName .= '.' . $image->getExtension();
            copy($image->getRealPath(), $fileName);
        }

        // Manifest.json
        $manifestJSONFile = $passDir . 'manifest.json';
        $manifest = array();
        foreach (scandir($passDir) as $file)
        {
            if ($file == '.' or $file == '..') continue;
            $manifest[$file] = sha1_file($passDir . $file);
        }
        file_put_contents($manifestJSONFile, json_encode($manifest));

        // Signature
        $signatureFile = $passDir . 'signature';
        $p12 = file_get_contents($this->p12->getRealPath());
        $certs = array();
        if (openssl_pkcs12_read($p12, $certs, $this->p12->getPassword()) == true) {
            $certdata = openssl_x509_read($certs['cert']);
            $privkey = openssl_pkey_get_private($certs['pkey'], $this->p12->getPassword());
            openssl_pkcs7_sign($manifestJSONFile, $signatureFile, $certdata, $privkey, array(), PKCS7_BINARY | PKCS7_DETACHED, $this->wwdr->getRealPath());
            // Get signature content
            $signature = @file_get_contents($signatureFile);
            // Check signature content
            if (!$signature) {
                throw new FileException("Couldn't read signature file.");
            }
            // Delimeters
            $begin = 'filename="smime.p7s"' . PHP_EOL . PHP_EOL;
            $end = PHP_EOL . PHP_EOL . '------';
            // Convert signature
            $signature = substr($signature, strpos($signature, $begin) + strlen($begin));
            $signature = substr($signature, 0, strpos($signature, $end));
            $signature = base64_decode($signature);
            // Put new signature
            if (!file_put_contents($signatureFile, $signature)) {
                throw new FileException("Couldn't write signature file.");
            }
        } else {
            throw new FileException("Error reading certificate file");
        }

        // Zip pass
        $zipFile = $outputPath . $pass->getSerialNumber() . self::PASS_EXTENSION;
        $zip = new ZipArchive();
        if (!$zip->open($zipFile, $this->getOverride() ? ZIPARCHIVE::OVERWRITE : ZipArchive::CREATE)) {
            throw new FileException("Couldn't open zip file.");
        }
        if ($handle = opendir($passDir)) {
            $zip->addFile($passDir);
            while (false !== ($entry = readdir($handle))) {
                if ($entry == '.' or $entry == '..') continue;
                $zip->addFile($passDir . $entry, $entry);
            }
            closedir($handle);
        } else {
            throw new FileException("Error reading pass directory");
        }
        $zip->close();

        // Remove temporary pass directory
        $this->rrmdir($passDir);
        return new SplFileObject($zipFile);
    }

    /**
     * Recursive folder remove
     *
     * @param string $dir
     */
    private function rrmdir($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            is_dir("$dir/$file") ? $this->rrmdir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}