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

use Exception;
use FilesystemIterator;
use InvalidArgumentException;
use Passbook\Certificate\P12;
use Passbook\Certificate\WWDR;
use Passbook\Exception\FileException;
use Passbook\Exception\PassInvalidException;
use Passbook\Pass\Image;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileObject;
use ZipArchive;

/**
 * PassFactory - Creates .pkpass files
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class PassFactory
{
    /**
     * Output path for generated pass files
     *
     * @var string
     */
    protected $outputPath = '';

    /**
     * Overwrite if pass exists
     *
     * @var bool
     */
    protected $overwrite = false;

    /**
     * Pass type identifier
     *
     * @var string
     */
    protected $passTypeIdentifier;

    /**
     * Team identifier
     *
     * @var string
     */
    protected $teamIdentifier;

    /**
     * Organization name
     *
     * @var string
     */
    protected $organizationName;

    /**
     * P12 file
     *
     * @var \Passbook\Certificate\P12Interface
     */
    protected $p12;

    /**
     * WWDR file
     *
     * @var \Passbook\Certificate\WWDRInterface
     */
    protected $wwdr;

    /**
     * @var bool - skip signing the pass; should only be used for testing
     */
    protected $skipSignature;

    /**
     * @var PassValidatorInterface
     */
    private $passValidator;

    /**
     * Pass file extension
     *
     * @var string
     */
    public const PASS_EXTENSION = '.pkpass';

    public function __construct($passTypeIdentifier, $teamIdentifier, $organizationName, $p12File, $p12Pass, $wwdrFile)
    {
        // Required pass information
        $this->passTypeIdentifier = $passTypeIdentifier;
        $this->teamIdentifier = $teamIdentifier;
        $this->organizationName = $organizationName;

        // Create certificate objects
        $this->p12 = new P12($p12File, $p12Pass);
        $this->wwdr = new WWDR($wwdrFile);

        // By default use the PassValidator
        $this->passValidator = new PassValidator();
    }

    /**
     * Set outputPath
     *
     * @param string $outputPath
     *
     * @return $this
     */
    public function setOutputPath($outputPath)
    {
        $this->outputPath = $outputPath;

        return $this;
    }

    /**
     * Get outputPath
     *
     * @return string
     */
    public function getOutputPath()
    {
        return $this->outputPath;
    }

    /**
     * The output path with a directory separator on the end.
     *
     * @return string
     */
    public function getNormalizedOutputPath()
    {
        return rtrim($this->outputPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Set overwrite
     *
     * @param boolean $overwrite
     *
     * @return $this
     */
    public function setOverwrite($overwrite)
    {
        $this->overwrite = $overwrite;

        return $this;
    }

    /**
     * Get overwrite
     *
     * @return boolean
     */
    public function isOverwrite()
    {
        return $this->overwrite;
    }

    /**
     * Set skip signature
     *
     * When set, the pass will not be signed when packaged. This should only
     * be used for testing.
     *
     * @param boolean $skipSignature
     *
     * @return $this
     */
    public function setSkipSignature($skipSignature)
    {
        $this->skipSignature = $skipSignature;

        return $this;
    }

    /**
     * Get skip signature
     *
     * @return boolean
     */
    public function getSkipSignature()
    {
        return $this->skipSignature;
    }

    /**
     * Set an implementation of PassValidatorInterface to validate the pass
     * before packaging. When set to null, no validation is performed when
     * packaging the pass.
     *
     * @param PassValidatorInterface|null $passValidator
     *
     * @return $this
     */
    public function setPassValidator(PassValidatorInterface $passValidator = null)
    {
        $this->passValidator = $passValidator;

        return $this;
    }

    /**
     * @return PassValidatorInterface
     */
    public function getPassValidator()
    {
        return $this->passValidator;
    }

    /**
     * Serialize pass
     *
     * @param  PassInterface $pass
     *
     * @return string
     */
    public static function serialize(PassInterface $pass)
    {
        return self::jsonEncode($pass->toArray());
    }

    /**
     * Creates a pkpass file
     *
     * @param  PassInterface $pass - the pass to be packaged into a .pkpass file
     * @param string $passName - filename to be used for the pass; if blank the serial number will be used
     *
     * @return SplFileObject If an IO error occurred
     * @throws InvalidArgumentException|PassInvalidException|Exception
     */
    public function package(PassInterface $pass, $passName = '')
    {
        if ($pass->getSerialNumber() == '') {
            throw new InvalidArgumentException('Pass must have a serial number to be packaged');
        }

        $this->populateRequiredInformation($pass);

        if ($this->passValidator) {
            if (!$this->passValidator->validate($pass)) {
                throw new PassInvalidException('Failed to validate passbook', $this->passValidator->getErrors());
            };
        }

        $passDir = $this->preparePassDirectory($pass);

        // Serialize pass
        file_put_contents($passDir . 'pass.json', self::serialize($pass));

        // Images
        $this->prepareImages($pass, $passDir);

        // Localizations
        $this->prepareLocalizations($pass, $passDir);

        // Manifest.json - recursive, also add files in sub directories
        $manifestJSONFile = $this->prepareManifest($passDir);

        // Signature
        $this->sign($passDir, $manifestJSONFile);

        // Zip pass
        $zipFile = $this->getNormalizedOutputPath() . $this->getPassName($passName, $pass) . self::PASS_EXTENSION;
        $this->zip($passDir, $zipFile);

        // Remove temporary pass directory
        $this->rrmdir($passDir);

        return new SplFileObject($zipFile);
    }

    /**
     * @param $passDir
     * @param $manifestJSONFile
     */
    private function sign($passDir, $manifestJSONFile): void
    {
        if ($this->getSkipSignature()) {
            return;
        }

        $signatureFile = $passDir . 'signature';
        $p12 = file_get_contents($this->p12->getRealPath());
        $certs = [];
        if (openssl_pkcs12_read($p12, $certs, $this->p12->getPassword()) === true) {
            $certdata = openssl_x509_read($certs['cert']);
            $privkey = openssl_pkey_get_private($certs['pkey'], $this->p12->getPassword());
            openssl_pkcs7_sign(
                $manifestJSONFile,
                $signatureFile,
                $certdata,
                $privkey,
                [],
                PKCS7_BINARY | PKCS7_DETACHED,
                $this->wwdr->getRealPath()
            );
            // Get signature content
            $signature = file_get_contents($signatureFile);
            // Check signature content
            if (!$signature) {
                throw new FileException("Couldn't read signature file.");
            }
            // Delimiters
            $begin = 'filename="smime.p7s"';
            $end = '------';
            // Convert signature
            $signature = substr($signature, strpos($signature, $begin) + strlen($begin));
            $signature = substr($signature, 0, strpos($signature, $end));
            $signature = base64_decode($signature);
            // Put new signature
            if (!file_put_contents($signatureFile, $signature)) {
                throw new FileException("Couldn't write signature file.");
            }
        } else {
            throw new FileException('Error reading certificate file');
        }
    }

    /**
     * Creates a zip of a directory including all sub directories (recursive)
     *
     * @param $source - path to the source directory
     * @param $destination - output directory
     *
     * @return bool
     * @throws Exception
     */
    private function zip($source, $destination)
    {
        if (!extension_loaded('zip')) {
            throw new Exception('ZIP extension not available');
        }

        $source = realpath($source);
        if (!is_dir($source)) {
            throw new FileException('Source must be a directory.');
        }

        $zip = new ZipArchive();
        $shouldOverwrite = $this->isOverwrite() ? ZipArchive::OVERWRITE : 0;
        if (!$zip->open($destination, ZipArchive::CREATE | $shouldOverwrite)) {
            throw new FileException("Couldn't open zip file.");
        }

        /* @var $iterator RecursiveIteratorIterator|RecursiveDirectoryIterator */
        $dirIterator = new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);
        while ($iterator->valid()) {
            if ($iterator->isDir()) {
                $zip->addEmptyDir($iterator->getSubPathName());
            } elseif ($iterator->isFile()) {
                $zip->addFromString($iterator->getSubPathName(), file_get_contents($iterator->key()));
            }
            $iterator->next();
        }

        return $zip->close();
    }

    /**
     * Recursive folder remove
     *
     * @param string $dir
     *
     * @return bool
     */
    private function rrmdir($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            is_dir("$dir/$file") ? $this->rrmdir("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }

    /**
     * @param PassInterface $pass
     */
    private function populateRequiredInformation(PassInterface $pass): void
    {
        if (!$pass->getPassTypeIdentifier()) {
            $pass->setPassTypeIdentifier($this->passTypeIdentifier);
        }

        if (!$pass->getTeamIdentifier()) {
            $pass->setTeamIdentifier($this->teamIdentifier);
        }

        if (!$pass->getOrganizationName()) {
            $pass->setOrganizationName($this->organizationName);
        }
    }

    /**
     * @param $array
     *
     * @return string
     */
    private static function jsonEncode($array)
    {
        // Check if JSON_UNESCAPED_SLASHES is defined to support PHP 5.3.
        $options = defined('JSON_UNESCAPED_SLASHES') ? JSON_UNESCAPED_SLASHES : 0;
        return json_encode($array, $options);
    }

    /**
     * @param $passName
     * @param PassInterface $pass
     *
     * @return string
     */
    public function getPassName($passName, PassInterface $pass)
    {
        $passNameSanitised = preg_replace('/[^a-zA-Z0-9]+/', '', $passName);
        return strlen($passNameSanitised) != 0 ? $passNameSanitised : $pass->getSerialNumber();
    }

    /**
     * @param $passDir
     *
     * @return string
     */
    private function prepareManifest($passDir)
    {
        $manifestJSONFile = $passDir . 'manifest.json';
        $manifest = [];
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($passDir),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($files as $file) {
            // Ignore "." and ".." folders
            if (in_array(substr($file, strrpos($file, '/') + 1), ['.', '..'])) {
                continue;
            }
            //
            $filePath = realpath($file);
            if (is_file($filePath) === true) {
                $relativePathName = str_replace($passDir, '', $file->getPathname());
                $manifest[$relativePathName] = sha1_file($filePath);
            }
        }
        file_put_contents($manifestJSONFile, $this->jsonEncode($manifest));

        return $manifestJSONFile;
    }

    /**
     * @param PassInterface $pass
     *
     * @return string
     */
    private function preparePassDirectory(PassInterface $pass)
    {
        $passDir = $this->getNormalizedOutputPath() . $pass->getSerialNumber() . DIRECTORY_SEPARATOR;
        $passDirExists = file_exists($passDir);
        if ($passDirExists && !$this->isOverwrite()) {
            throw new FileException('Temporary pass directory already exists');
        } elseif (!$passDirExists && !mkdir($passDir, 0777, true)) {
            throw new FileException("Couldn't create temporary pass directory");
        }

        return $passDir;
    }

    /**
     * @param PassInterface $pass
     * @param string        $passDir
     */
    private function prepareImages(PassInterface $pass, $passDir): void
    {
        /** @var Image $image */
        foreach ($pass->getImages() as $image) {
            $fileName = $passDir . $image->getContext();
            if ($image->getDensity() === 2) {
                $fileName .= '@2x';
            } elseif ($image->getDensity() === 3) {
                $fileName .= '@3x';
            }

            $fileName .= '.' . $image->getExtension();
            copy($image->getPathname(), $fileName);
        }
    }

    /**
     * @param PassInterface $pass
     * @param string        $passDir
     */
    private function prepareLocalizations(PassInterface $pass, $passDir): void
    {
        foreach ($pass->getLocalizations() as $localization) {
            // Create dir (LANGUAGE.lproj)
            $localizationDir = $passDir . $localization->getLanguage() . '.lproj' . DIRECTORY_SEPARATOR;
            $localizationDirExists = file_exists($localizationDir);
            if ($localizationDirExists && !$this->isOverwrite()) {
                throw new FileException("Temporary pass localization directory already exists ({$localization->getLanguage()})");
            } elseif (!$localizationDirExists && !mkdir($localizationDir, 0777, true)) {
                throw new FileException("Couldn't create temporary pass localization directory ({$localization->getLanguage()})");
            }

            // pass.strings File (Format: "token" = "value")
            $localizationStringsFile = $localizationDir . 'pass.strings';
            file_put_contents($localizationStringsFile, $localization->getStringsFileOutput());

            // Localization images
            foreach ($localization->getImages() as $image) {
                $fileName = $localizationDir . $image->getContext();
                if ($image->getDensity() === 2) {
                    $fileName .= '@2x';
                } elseif ($image->getDensity() === 3) {
                    $fileName .= '@3x';
                }
                $fileName .= '.' . $image->getExtension();
                copy($image->getPathname(), $fileName);
            }
        }
    }
}
