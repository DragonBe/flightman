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
use In2it\Trainit\Filter\ArrivalDateFilter;

class ArrivalDateFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Fixture creation for a flight manager
     * @return FlightManager
     */
    protected function getFlightManager()
    {
        $flight = $this->getMockBuilder('\In2it\Trainit\Entity\Flight')
            ->setMethods(['isValid', 'getArrivalDate'])
            ->getMock();
        $flight->expects($this->exactly(3))
            ->method('isValid')
            ->willReturn(true);

        $flightOne = clone $flight;
        $flightOne->expects($this->once())
            ->method('getArrivalDate')
            ->willReturn(new \DateTime('2016-09-20 10:00:00'));

        $flightTwo = clone $flight;
        $flightTwo->expects($this->once())
            ->method('getArrivalDate')
            ->willReturn(new \DateTime('2016-09-30 07:15:00'));

        $flightThree = clone $flight;
        $flightThree->expects($this->once())
            ->method('getArrivalDate')
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
        $arrivalDateFilter = new ArrivalDateFilter($flightMan, new \DateTime('1970-01-01 00:00:00'));
        $this->assertCount(0, $arrivalDateFilter);
    }
    /**
     * Test for searching flights by departure date
     *
     * @covers ArrivalDateFilter::__construct
     * @covers ArrivalDateFilter::accept
     * @group Filter
     */
    public function testCanSearchForFlightsByArrivalDate()
    {
        $flightMan = $this->getFlightManager();
        $this->assertCount(3, $flightMan);
        $arrivalDateFilter = new ArrivalDateFilter($flightMan, new \DateTime('2016-09-20 00:00:00'));
        $this->assertCount(2, $arrivalDateFilter);
    }
}