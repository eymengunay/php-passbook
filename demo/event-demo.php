<?php

/**
 * ------------------------------------------------------
 *  PHP PASSBOOK EVENT DEMO
 * ------------------------------------------------------
 *
 * In this demo, library will create a passbook pass file
 * and put it in the given output folder. To start using
 * the generated pass on your iOS6 device you will have
 * to attach the file in an email or visit the url that
 * points to the generated file.
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require passbook library
require_once '../passbook.php';

// Init class
$passbook = new Passbook();

// Set pass output path
$passbook->output_path = './passes/';

// Set temporary folder
$passbook->temp_path = sys_get_temp_dir();

// Set P12 certificate
$passbook->p12_certificate  = ''; # Required!
$passbook->p12_cert_pass    = ''; # Required!

// Set WWDR certificate
$passbook->wwdr_certificate = ''; # Required!

// Create pass data
$pass_data = array(
    // Identifiers
    'teamIdentifier'        => '', # Required!
    'passTypeIdentifier'    => '', # Required!
    'organizationName'      => 'Apple Inc.',
    'serialNumber'          => '123456789',
    'description'           => 'The Beat Goes On',
    // Styling
    'backgroundColor'       => 'rgb(60,65,76)',
    'foregroundColor'       => 'rgb(255,255,255)',
    'labelColor'            => 'rgb(255,255,255)',
    // Texts
    'logoText'              => '',
    // Passbook version
    'formatVersion'         => 1,
    // Locations
    'locations'             => array(
        array(
            'latitude'      => 37.6189722,
            'longitude'     => -122.3748889,
        ),
        array(
            'latitude'      => 37.33182,
            'longitude'     => -122.03118,
        )
    ),
    // Event
    'relevantDate'          => "2011-12-08T13:00-08:00",
    'eventTicket'           => array(
        'primaryFields'         => array(
            array(
                'key'   => 'event',
                'label' => 'EVENT',
                'value' => 'The Beat Goes On'
            )
        ),
        'secondaryFields'       => array(
            array(
                'key'   => 'location',
                'label' => 'LOCATION',
                'value' => 'Moscone West'
            ),
        ),
        'backFields'            => array(
            array(
                'key'   => 'copy1',
                'label' => 'Lorem Ipsum',
                'value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
            )
        )
    ),
    'barcode'               => array(
        'format'            => 'PKBarcodeFormatPDF417',
        'message'           => '123456789',
        'messageEncoding'   => 'iso-8859-1'
    )
);

// Set JSON
$passbook->set_json($pass_data);

// Set background
$passbook->set_image('background', './img/event/background.png');
$passbook->set_image('background', './img/event/background@2x.png', true);

// Set icon
$passbook->set_image('icon', './img/event/icon.png');
$passbook->set_image('icon', './img/event/icon@2x.png', true);

// Set logo
$passbook->set_image('logo', './img/event/logo.png');
$passbook->set_image('logo', './img/event/logo@2x.png', true);

// Set thumbnail
$passbook->set_image('thumbnail', './img/event/thumbnail.png');
$passbook->set_image('thumbnail', './img/event/thumbnail@2x.png', true);

// Create a pass
$pass = $passbook->create('some_file_name', false);

/* End of file event-demo.php */
/* Location: ./demo/event-demo.php */