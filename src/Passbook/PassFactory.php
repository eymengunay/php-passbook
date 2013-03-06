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

use Passbook\Certificate\P12;
use Passbook\Certificate\WWDR;
use Passbook\Exception\FileException;
use Passbook\Subscriber\PassEventSubscriber;

/**
 * PassFactory - Creates .pkpass files
 *
 * @author Eymen Gunay <eymen@egunay.com>
 */
class PassFactory
{
    /**
     * change
     * @var string
     */
    protected $passTypeIdentifier;

    /**
     * change
     * @var string
     */
    protected $teamIdentifier;

    /**
     * change
     * @var string
     */
    protected $organizationName;

    public function __construct($passTypeIdentifier, $teamIdentifier, $organizationName)
    {
        // Require
        $this->passTypeIdentifier = $passTypeIdentifier;
        $this->teamIdentifier     = $teamIdentifier;
        $this->organizationName   = $organizationName;
    }

    /**
     * Create .pkpass
     *
     * @param  Pass $pass
     * @return SplFileInfo real path to generated file
     */
    public function create(Pass $pass)
    {
        $builder = \JMS\Serializer\SerializerBuilder::create();
        $builder->configureListeners(function(\JMS\Serializer\EventDispatcher\EventDispatcher $dispatcher) {
            // Add subscriber
            $dispatcher->addSubscriber(new PassEventSubscriber());
        });
        $serializer = $builder->build();
        $json = $serializer->serialize($pass, 'json');

        print_r($json);
        return '';



        $outputDir  = sys_get_temp_dir();
        $reflection = new \ReflectionClass($pass);
        $passArray  = array();
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $method = 'get' . ucfirst($property->getName());
            $value  = $pass->$method();

            if (!is_null($value) && (is_array($value) && !empty($value) || is_string($value) && $value != '')) {
                $passArray[$property->getName()] = $value;
            } elseif (is_object($value)) {
                var_dump($value);
                echo '@TODO!';
            }
        }

        // Add fields
        $type = $pass->getType();
        $structure = $pass->getStructure();
        //foreach ($structure as )

        echo json_encode($passArray);
        echo PHP_EOL.PHP_EOL.PHP_EOL;
        $passArray[$type] = $structure;

        echo json_encode($passArray);
    }
}