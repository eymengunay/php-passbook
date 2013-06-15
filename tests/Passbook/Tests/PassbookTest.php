<?php

namespace Passbook\Tests;

use Passbook\Pass\Field;
use Passbook\PassFactory;
use Passbook\Pass\Barcode;
use Passbook\Pass\Structure;
use Passbook\Type\BoardingPass;
use Passbook\Type\Coupon;
use Passbook\Type\EventTicket;
use Passbook\Type\Generic;
use Passbook\Type\StoreCard;

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
    }
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->boardingPass = new BoardingPass(uniqid(), 'Lorem ipsum', 'PKTransitTypeBoat');
        $this->coupon       = new Coupon(uniqid(), 'Lorem ipsum');
        $this->eventTicket  = new EventTicket(uniqid(), 'Lorem ipsum');
        $this->generic      = new Generic(uniqid(), 'Lorem ipsum');
        $this->storeCard    = new StoreCard(uniqid(), 'Lorem ipsum');
    }
}