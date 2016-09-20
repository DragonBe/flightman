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
use In2it\Trainit\Filter\DateFilter;

class DateFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Fixture creation for a flight manager
     * @return FlightManager
     */
    protected function getFlightManager()
    {
        $flight = $this->getMockBuilder('\In2it\Trainit\Entity\Flight')
            ->setMethods(['isValid', 'getDepartureDate', 'getArrivalDate'])
            ->getMock();
        $flight->expects($this->exactly(3))
            ->method('isValid')
            ->willReturn(true);

        $flightOne = clone $flight;
        $flightOne->expects($this->once())
            ->method('getDepartureDate')
            ->willReturn(new \DateTime('2016-09-20 10:00:00'));
        $flightOne->expects($this->once())
            ->method('getArrivalDate')
            ->willReturn(new \DateTime('2016-09-20 12:15:00'));

        $flightTwo = clone $flight;
        $flightTwo->expects($this->once())
            ->method('getDepartureDate')
            ->willReturn(new \DateTime('2016-09-30 07:15:00'));
        $flightTwo->expects($this->once())
            ->method('getArrivalDate')
            ->willReturn(new \DateTime('2016-09-30 14:22:00'));

        $flightThree = clone $flight;
        $flightThree->expects($this->once())
            ->method('getDepartureDate')
            ->willReturn(new \DateTime('2016-09-20 23:10:00'));
        $flightThree->expects($this->once())
            ->method('getArrivalDate')
            ->willReturn(new \DateTime('2016-09-20 23:59:00'));


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
        $dateFilter = new DateFilter($flightMan, new \DateTime('1970-01-01 00:00:00'));
        $this->assertCount(0, $dateFilter);
    }
    /**
     * Test for searching flights by date
     *
     * @covers DateFilter::__construct
     * @covers DateFilter::accept
     * @group Filter
     */
    public function testCanSearchForFlightsByDepartureDate()
    {
        $flightMan = $this->getFlightManager();
        $this->assertCount(3, $flightMan);
        $dateFilter = new DateFilter($flightMan, new \DateTime('2016-09-20 00:00:00'));
        $this->assertCount(2, $dateFilter);
    }
}