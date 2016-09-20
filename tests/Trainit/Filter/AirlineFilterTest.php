<?php
/**
 * Created by PhpStorm.
 * User: dragonbe
 * Date: 20/09/16
 * Time: 05:43
 */

namespace In2it\Test\Trainit\Filter;

use In2it\Trainit\FlightManager;
use In2it\Trainit\Entity\Flight;
use In2it\Trainit\Filter\AirlineFilter;

class AirlineFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Fixture creation for a flight manager
     * @return FlightManager
     */
    protected function getFlightManager()
    {
        $flight = $this->getMockBuilder('\In2it\Trainit\Entity\Flight')
            ->setMethods(['isValid', 'getAirlineCode'])
            ->getMock();
        $flight->expects($this->exactly(3))
            ->method('isValid')
            ->willReturn(true);

        $flightOne = clone $flight;
        $flightOne->expects($this->once())
            ->method('getAirlineCode')
            ->willReturn('UA');

        $flightTwo = clone $flight;
        $flightTwo->expects($this->once())
            ->method('getAirlineCode')
            ->willReturn('LX');

        $flightThree = clone $flight;
        $flightThree->expects($this->once())
            ->method('getAirlineCode')
            ->willReturn('UA');


        $flightMan = new FlightManager();
        $flightMan->addFlight($flightOne)
            ->addFlight($flightTwo)
            ->addFlight($flightThree);

        return $flightMan;
    }
    public function testFilterHasCountOfZeroWhenNoMatchingFlightsAreFound()
    {
        $flightMan = $this->getFlightManager();
        $this->assertCount(3, $flightMan);
        $airlineFilter = new AirlineFilter($flightMan, 'LH');
        $this->assertCount(0, $airlineFilter);
    }
    /**
     * Test for searching flights by departure date
     *
     * @covers AirlineFilter::__construct
     * @covers AirlineFilter::accept
     * @group Filter
     */
    public function testCanSearchForFlightsByAirlineCode()
    {
        $flightMan = $this->getFlightManager();
        $this->assertCount(3, $flightMan);
        $airlineFilter = new AirlineFilter($flightMan, 'UA');
        $this->assertCount(2, $airlineFilter);
    }
}