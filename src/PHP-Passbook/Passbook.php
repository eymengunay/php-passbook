<?php

/**
 * PHP PASSBOOK PASS LIBRARY
 *
 * Copyright (c) 2012 Eymen Gunay
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished to do so, subject to the
 * following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
 * FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * @author      Eymen Gunay <eymen@egunay.com>
 * @link        https://github.com/eymengunay/php-passbook
 * @package     Passbook
 * @category    Library
 * @version     0.1
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Eymengunay\PHPPassbook;

class Passbook {

    /**
     * Manifest file name
     * @var array
     */
    private $_manifest_file_name    = 'manifest.json';

    /**
     * Pass file name
     * @var array
     */
    private $_pass_file_name        = 'pass.json';

    /**
     * Signature file name
     * @var array
     */
    private $_signature_file_name   = 'signature';

    /**
     * Pass file extension
     * @var array
     */
    private $_pass_extension        = '.pkpass';

    /**
     * Standard top-level keys
     * @var array
     */
    private $_keys                  = array();

    /**
     * Pass image files arrays
     * @var array
     */
    private $_images                = array();

    /**
     * Output folder for generated files
     * @var string
     */
    public $output_path             = './';

    /**
     * Temporary storage folder
     * @var string
     */
    public $temp_path               = './';

    /**
     * P12 Certificate file
     * @var string
     */
    public $p12_certificate         = 'certificate.p12';

    /**
     * P12 Certificate password
     * @var string
     */
    public $p12_cert_pass           = '';

    /**
     * WWDR Intermediate certificate
     * @var string
     */
    public $wwdr_certificate        = '';

    /**
     * Sets JSON keys
     *
     * See documentation - keys section
     *
     * @access  public
     * @param   string  Key
     * @param   string  Value
     * @return  object
     */
    public function set_json($key, $val = false)
    {
        // Push into keys
        if (!$val) $this->_keys = $key;
        else $this->_keys[$key] = $val;
        // Method chainability
        return $this;
    }

    /**
     * Adds images into pass
     *
     * Only png files are accepted. Valid image types are:
     * thumbnail
     * icon
     * background
     * logo
     * footer
     * strip
     *
     * See documentation - images section
     *
     * @access  public
     * @param   string  Image type
     * @param   string  Image full path
     * @param   bool    Image quality, true for retina
     * @return  object
     */
    public function set_image($image_type, $image_path, $retina = false)
    {
        // Set image
        $this->_images[] = array(
            'path'      => $image_path,
            'type'      => $image_type,
            'retina'    => $retina
        );
        // Method chainability
        return $this;
    }

    /**
     * Create a pass
     *
     * @access  public
     * @param   string  Pass type
     * @param   string  Pass serial number
     * @param   string  Pass file name without extension
     * @param   bool    Show pass after create
     * @return  bool
     */
    public function create($pkpass_file_name, $show = false)
    {
        // Create pass.json file contents
        $pass_contents = json_encode($this->_keys);
        // Set temporary pass folder name
        $pass_folder_name = uniqid() . '.raw';
        // Set temporary pass folder path
        $pass_folder_path = $this->temp_path . $pass_folder_name . DIRECTORY_SEPARATOR;
        // Create temporary pass folder
        if (!mkdir($pass_folder_path, 0777)) throw new Exception("Couldn't create temporary pass folder.");
        // Create pass.json file
        if (!file_put_contents($pass_folder_path . $this->_pass_file_name, $pass_contents)) throw new Exception("Couldn't create pass.json file.");
        // Check for images
        if (!empty($this->_images)) {
            // Loop images
            foreach ($this->_images as $image) {
                // Set new filename
                $image_name = $image['type'];
                // Check for retina
                if ($image['retina']) $image_name .= '@2x';
                // Add extension
                $image_name .= '.png';
                // Add images
                if (!copy($image['path'], $pass_folder_path . $image_name)) throw new Exception("Couldn't copy image.");
            }
        }
        // Generate manifest file
        $this->_generate_manifest($pass_folder_path);
        // Generate signature file
        $this->_generate_signature($pass_folder_path);
        // Set zip file
        $zip_file = $this->output_path . $pkpass_file_name . $this->_pass_extension;
        // Init zip
        $zip = new ZipArchive();
        // Open zip file (by default it overwrites if file exists)
        if (!$zip->open($zip_file, ZIPARCHIVE::OVERWRITE)) throw new Exception("Couldn't open zip file.");
        // Open pass folder
        if ($handle = opendir($pass_folder_path)) {
            // Add dir
            $zip->addFile($pass_folder_path);
            // Loop over the dir
            while (false !== ($entry = readdir($handle))) {
                // Skip . and ..
                if ($entry == '.' or $entry == '..') continue;
                // Add files into zip
                $zip->addFile($pass_folder_path . $entry, $entry);
            }
            closedir($handle);
        } else {
            // Throw exception @todo
            die('Error creating temporary pass directory!');
        }
        // Close zip
        $zip->close();
        // Remove temp folder
        $this->_remove_dir($pass_folder_path);
        // Check show
        if ($show) $this->show($zip_file);
        return $pkpass_file_name . $this->_pass_extension;
    }

    /**
     * Initializes all variables to an empty state.
     *
     * This function is intended for use if you run
     * the pass creating function in a loop,
     * permitting the data to be reset between cycles.
     *
     * @access  public
     * @param   string
     * @return  void
     */
    public function show($pass)
    {
        // Set pragma
        header('Pragma: no-cache');
        // Set content type
        header('Content-type: application/vnd.apple.pkpass');
        // Set content length
        header('Content-length: '.filesize($pass));
        // Set disposition
        header('Content-Disposition: attachment; filename="pass.pkpass"');
        echo file_get_contents($pass);
    }

    /**
     * Generates manifest.json
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function _generate_manifest($pass_folder_path)
    {
        // Init manifest array
        $manifest = array();
        // Add folder content to manifest
        foreach (scandir($pass_folder_path) as $file) {
            // Skip "." and ".."
            if ($file == '.' or $file == '..') continue;
            // Push into manifest
            $manifest[$file] = sha1_file($pass_folder_path . $file);
        }
        // Put manifest file in pass folder path
        if (!file_put_contents($pass_folder_path . $this->_manifest_file_name, json_encode($manifest))) throw new Exception("Failed to write manifest.json.");
        return true;
    }

    /**
     * Generates signature file
     *
     * @access  private
     * @param   string
     * @return  bool
     */
    private function _generate_signature($pass_folder_path)
    {
        // Check for the certificate file
        if ($this->p12_certificate == '' or !file_exists($this->p12_certificate)) throw new Exception("P12 certificate file missing.");
        // Read content of the certificate file
        $p12_content = file_get_contents($this->p12_certificate);
        // Init certs array
        $certs = array();
        // Read p12 certificate
        if (openssl_pkcs12_read($p12_content, $certs, $this->p12_cert_pass) == true) {
            $certdata = openssl_x509_read($certs['cert']);
            $privkey = openssl_pkey_get_private($certs['pkey'], $this->p12_cert_pass );
            openssl_pkcs7_sign($pass_folder_path . $this->_manifest_file_name, $pass_folder_path . $this->_signature_file_name, $certdata, $privkey, array(), PKCS7_BINARY | PKCS7_DETACHED, $this->wwdr_certificate);
            //openssl_pkcs7_sign($pass_folder_path . $this->_manifest_file_name, $pass_folder_path . $this->_signature_file_name, $certdata, $privkey, array(), PKCS7_BINARY | PKCS7_DETACHED);
            // Get signature content
            $signature_content = @file_get_contents($pass_folder_path . $this->_signature_file_name);
            // Check signature content
            if (!$signature_content) throw new Exception("Couldn't read signature file.");
            // Delimeters
            $begin = 'filename="smime.p7s"' . PHP_EOL . PHP_EOL;
            $end = PHP_EOL . PHP_EOL . '------';
            // Convert signature
            $signature_content = substr($signature_content, strpos($signature_content, $begin)+strlen($begin));
            $signature_content = substr($signature_content, 0, strpos($signature_content, $end));
            $signature_content = base64_decode($signature_content);
            // Put new signature
            if (!file_put_contents($pass_folder_path . $this->_signature_file_name, $signature_content)) throw new Exception("Couldn't write signature file.");
            return true;
        }
    }

    /**
     * Removes a folder recursively
     *
     * @access  private
     * @param   string Dir path
     * @return  void
     */
    private function _remove_dir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") $this->_remove_dir($dir."/".$object);
                    else unlink($dir."/".$object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/* End of file passbook.php */
/* Location: ./passbook.php */