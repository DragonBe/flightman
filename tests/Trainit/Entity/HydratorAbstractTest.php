<?php
/**
 * Created by PhpStorm.
 * User: dragonbe
 * Date: 20/09/16
 * Time: 08:34
 */

namespace In2it\Test\Trainit\Entity;


use In2it\Trainit\Entity\FlightHydrator;
use In2it\Trainit\Entity\Flight;
use In2it\Trainit\Entity\HydratorAbstract;

class HydratorAbstractTest extends \PHPUnit_Framework_TestCase
{
    public function flightDataProvider()
    {
        return [
            [
                [
                    'departure_date' => '2016-09-20 10:00:00',
                    'departure_airport_code' => 'BRU',
                    'arrival_date' => '2016-09-20 14:00:00',
                    'arrival_airport_code' => 'ALC',
                    'airline_code' => 'SN',
                    'flight_number' => '1024',
                ],
            ],
        ];
    }

    /**
     * @dataProvider flightDataProvider
     * @group Entity
     * @covers HydratorAbstract::hydrate
     * @covers HydratorAbstract::getSetters
     * @covers HydratorAbstract::camelToSnake
     * @return Flight
     */
    public function testHydrate($data)
    {
        $flight = new Flight();
        $flightHydrator = new FlightHydrator();
        $flightHydrator->hydrate($flight, $data);

        $this->assertSame($data['departure_airport_code'], $flight->getDepartureAirportCode());
    }

    /**
     * @dataProvider flightDataProvider
     * @group Entity
     * @covers HydratorAbstract::extract
     * @covers HydratorAbstract::getGetters
     * @covers HydratorAbstract::snakeToCamel
     * @param array $data
     */
    public function testExtract($data)
    {
        $flight = new Flight();
        $flight->setDepartureDate(new \DateTime($data['departure_date']))
            ->setDepartureAirportCode($data['departure_airport_code'])
            ->setArrivalDate(new \DateTime($data['arrival_date']))
            ->setArrivalAirportCode($data['arrival_airport_code'])
            ->setAirlineCode($data['airline_code'])
            ->setFlightNumber($data['flight_number']);

        $flightHydrator = new FlightHydrator();
        $result = $flightHydrator->extract($flight);
        $this->assertSame($data, $result);
    }

}