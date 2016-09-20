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
use \Faker\Factory;

class HydratorAbstractTest extends \PHPUnit_Framework_TestCase
{
    public function flightDataProvider()
    {
        $faker = \Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [[
                'departure_date' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
                'departure_airport_code' => strtoupper($faker->lexify('???')),
                'arrival_date' => $faker->dateTimeThisYear($max = 'now')->format('Y-m-d H:i:s'),
                'arrival_airport_code' => strtoupper($faker->lexify('???')),
                'airline_code' => strtoupper($faker->lexify('??')),
                'flight_number' => $faker->numberBetween($min = 1, $max = 9999),
            ]];
        }
        return $data;
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
        $this->markTestIncomplete('Need to fix airport code handling');
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