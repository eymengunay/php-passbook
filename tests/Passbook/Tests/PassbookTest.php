<?php

namespace Passbook\Tests;

use Passbook\PassFactory;
use Passbook\Pass\Field;
use Passbook\Pass\Barcode;
use Passbook\Pass\Location;
use Passbook\Pass\Structure;
use Passbook\Type\BoardingPass;
use Passbook\Type\Coupon;
use Passbook\Type\EventTicket;
use Passbook\Type\Generic;
use Passbook\Type\StoreCard;
use Doctrine\Common\Annotations\AnnotationRegistry;

class PassbookTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PassInterface
     */
    protected $boardingPass;

    /**
     * @var PassInterface
     */
    protected $coupon;

    /**
     * @var PassInterface
     */
    protected $eventTicket;

    /**
     * @var PassInterface
     */
    protected $generic;

    /**
     * @var PassInterface
     */
    protected $storeCard;

    /**
     * Event Ticket
     */
    public function testEventTicket()
    {
        $this->eventTicket->setBackgroundColor('rgb(60, 65, 76)');
        $this->assertSame('rgb(60, 65, 76)', $this->eventTicket->getBackgroundColor());
        $this->eventTicket->setLogoText('Apple Inc.');
        $this->assertSame('Apple Inc.', $this->eventTicket->getLogoText());

        // Add location
        $location = new Location(59.33792, 18.06873);
        $this->eventTicket->addLocation($location);

        // Create pass structure
        $structure = new Structure();

        // Add primary field
        $primary = new Field('event', 'The Beat Goes On');
        $primary->setLabel('Event');
        $structure->addPrimaryField($primary);

        // Add secondary field
        $secondary = new Field('location', 'Moscone West');
        $secondary->setLabel('Location');
        $structure->addSecondaryField($secondary);

        // Add auxiliary field
        $auxiliary = new Field('datetime', '2013-04-15 @10:25');
        $auxiliary->setLabel('Date & Time');
        $structure->addAuxiliaryField($auxiliary);

        // Set pass structure
        $this->eventTicket->setStructure($structure);

        $barcode = new Barcode('PKBarcodeFormatQR', 'barcodeMessage');
        $this->eventTicket->setBarcode($barcode);

        $json = PassFactory::serialize($this->eventTicket);
        $array = json_decode($json, true);

        $this->assertArrayHasKey('locations', $array);
        $this->assertArrayHasKey('barcode', $array);
        $this->assertArrayHasKey('logoText', $array);
        $this->assertArrayHasKey('backgroundColor', $array);
        $this->assertArrayHasKey('eventTicket', $array);
    }

    /**
     * Generic
     */
    public function testGeneric()
    {
        $this->generic->setBackgroundColor('rgb(60, 65, 76)');
        $this->assertSame('rgb(60, 65, 76)', $this->generic->getBackgroundColor());
        $this->generic->setLogoText('Apple Inc.');
        $this->assertSame('Apple Inc.', $this->generic->getLogoText());

        // Create pass structure
        $structure = new Structure();

        // Add primary field
        $primary = new Field('event', 'The Beat Goes On');
        $primary->setLabel('Event');
        $structure->addPrimaryField($primary);

        // Add back field
        $back = new Field('back', 'Hello World!');
        $back->setLabel('Location');
        $structure->addSecondaryField($back);

        // Add auxiliary field
        $auxiliary = new Field('datetime', '2013-04-15 @10:25');
        $auxiliary->setLabel('Date & Time');
        $structure->addAuxiliaryField($auxiliary);

        // Set pass structure
        $this->generic->setStructure($structure);

        $barcode = new Barcode('PKBarcodeFormatQR', 'barcodeMessage');
        $this->generic->setBarcode($barcode);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $loader = require_once __DIR__ . "/../../../vendor/autoload.php";
        AnnotationRegistry::registerAutoloadNamespace('JMS\Serializer\Annotation', __DIR__ . "/../../../vendor/jms/serializer/src");

        $this->boardingPass = new BoardingPass(uniqid(), 'Lorem ipsum', 'PKTransitTypeBoat');
        $this->coupon       = new Coupon(uniqid(), 'Lorem ipsum');
        $this->eventTicket  = new EventTicket(uniqid(), 'Lorem ipsum');
        $this->generic      = new Generic(uniqid(), 'Lorem ipsum');
        $this->storeCard    = new StoreCard(uniqid(), 'Lorem ipsum');
    }
}
