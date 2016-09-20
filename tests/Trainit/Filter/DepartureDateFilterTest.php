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
use In2it\Trainit\Filter\DepartureDateFilter;

class DepartureDateFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Fixture creation for a flight manager
     * @return FlightManager
     */
    protected function getFlightManager()
    {
        $flight = $this->getMockBuilder('\In2it\Trainit\Entity\Flight')
            ->setMethods(['isValid', 'getDepartureDate'])
            ->getMock();
        $flight->expects($this->exactly(3))
            ->method('isValid')
            ->willReturn(true);

        $flightOne = clone $flight;
        $flightOne->expects($this->once())
            ->method('getDepartureDate')
            ->willReturn(new \DateTime('2016-09-20 10:00:00'));

        $flightTwo = clone $flight;
        $flightTwo->expects($this->once())
            ->method('getDepartureDate')
            ->willReturn(new \DateTime('2016-09-30 07:15:00'));

        $flightThree = clone $flight;
        $flightThree->expects($this->once())
            ->method('getDepartureDate')
            ->willReturn(new \DateTime('2016-09-20 23:10:00'));


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
        $departureDateFilter = new DepartureDateFilter($flightMan, new \DateTime('1970-01-01 00:00:00'));
        $this->assertCount(0, $departureDateFilter);
    }
    /**
     * Test for searching flights by departure date
     *
     * @covers DepartureDateFilter::__construct
     * @covers DepartureDateFilter::accept
     * @group Filter
     */
    public function testCanSearchForFlightsByDepartureDate()
    {
        $flightMan = $this->getFlightManager();
        $this->assertCount(3, $flightMan);
        $departureDateFilter = new DepartureDateFilter($flightMan, new \DateTime('2016-09-20 00:00:00'));
        $this->assertCount(2, $departureDateFilter);
    }
}