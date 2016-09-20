<?php
/**
 * Created by PhpStorm.
 * User: dragonbe
 * Date: 20/09/16
 * Time: 06:45
 */

namespace In2it\Test\Trainit\Entity;


use In2it\Trainit\Entity\Flight;

class FlightTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testing that a Flight entity is empty at construction
     *
     * @covers Flight::__construct
     * @group Entity
     */
    public function testFlightIsEmptyAtConstruct()
    {
        $flight = new Flight();
        $this->assertInstanceOf('\In2it\Trainit\Entity\Flight', $flight);
        $this->assertSame(Flight::DEFAULT_DATE, $flight->getDepartureDate()->format('Y-m-d H:i:s'));
        $this->assertSame(Flight::DEFAULT_AIRPORT_CODE, $flight->getDepartureAirportCode());
        $this->assertSame(Flight::DEFAULT_DATE, $flight->getArrivalDate()->format('Y-m-d H:i:s'));
        $this->assertSame(Flight::DEFAULT_AIRPORT_CODE, $flight->getArrivalAirportCode());
        $this->assertSame(Flight::DEFAULT_AIRLINE, $flight->getAirlineCode());
        $this->assertSame(Flight::DEFAULT_FLIGHTNR, $flight->getFlightNumber());
    }
}