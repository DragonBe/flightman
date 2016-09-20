<?php

namespace In2it\Test\Trainit;

use In2it\Trainit\FlightManager;
use In2it\Trainit\Entity\Flight;

class FlightManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Ensure we can only add a Flight entity that meets minimum data
     * requirements (e.g. dates, times, departing airport, arrival airport).
     *
     * @covers FlightManager::__construct
     * @covers FlightManager::addFlight
     * @expectedException \InvalidArgumentException
     * @group FlightManager
     */
    public function testCanNotAddEmptyFlightToManager()
    {
        $flight = $this->getMockBuilder('\In2it\Trainit\Entity\Flight')
            ->setMethods(['isValid'])
            ->getMock();
        $flight->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $flightMan = new FlightManager();
        $flightMan->addFlight($flight);
    }

    /**
     * Test the flight manager can add a Flight entity to it's
     * collection.
     *
     * @covers FlightManager::__construct
     * @covers FlightManager::addFlight
     * @group FlightManager
     */
    public function testCanAddFlightDetails()
    {
        $flight = $this->getMockBuilder('\In2it\Trainit\Entity\Flight')
            ->setMethods(['isValid'])
            ->getMock();
        $flight->expects($this->once())
            ->method('isValid')
            ->willReturn(true);
        $flightMan = new FlightManager();
        $this->assertCount(0, $flightMan);
        $flightMan->addFlight($flight);
        $this->assertCount(1, $flightMan);
    }
}