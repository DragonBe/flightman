<?php

namespace In2it\Trainit\Test;

use In2it\Trainit\FlightManager;
use In2it\Trainit\Entity\Flight;

class FlightManagerTest extends \PHPUnit_Framework_TestCase
{
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
        $flight = $this->getMockBuilder('\In2it\Trainit\Entity\Flight')->getMock();
        $flightMan = new FlightManager();
        $this->assertCount(0, $flightMan);
        $flightMan->addFlight($flight);
        $this->assertCount(1, $flightMan);
    }
}