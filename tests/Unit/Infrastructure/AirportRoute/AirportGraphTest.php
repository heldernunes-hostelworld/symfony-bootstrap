<?php declare(strict_types=1);
namespace App\Tests\Unit\Infrastructure\AirportRoute;

use App\Domain\Context\AirportRoute\FindBestPath\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestPath\Collection\PossibleRoutesCollection;
use App\Domain\Shared\Entity\Airport;
use App\Infrastructure\AirportRoute\AirportGraph;
use PHPUnit\Framework\TestCase;

class AirportGraphTest extends TestCase
{
    public function testBreadthFirstSearchWhenOriginHasNoAdjacentAirportsReturnEmptyCollection(): void
    {
        $originAirport = (new Airport())->setId(1)->setName('Origin');
        $intermediateAirport = (new Airport())->setId(3)->setName('Intermediate');
        $destinationAirport = (new Airport())->setId(5)->setName('Destination');

        $possibleRoutes = PossibleRoutesCollection::create()
            ->addPossibleRoutes(
                $intermediateAirport,
                AirportCollection::createEmpty()
                    ->addAirport($destinationAirport)
            )
            ->addPossibleRoutes(
                $destinationAirport,
                AirportCollection::createEmpty()
                    ->addAirport($originAirport)
            );

        $airportGraph = new AirportGraph($possibleRoutes);
        $airportCollection = $airportGraph->breadthFirstSearch($originAirport, $destinationAirport);

        $this->assertEquals(AirportCollection::createEmpty(), $airportCollection);
    }

    public function testBreadthFirstSearchWhenDestinationHasNoAdjacentAirportsReturnsShortestPath(): void
    {
        $originAirport = (new Airport())->setId(1)->setName('Origin');
        $intermediateAirport = (new Airport())->setId(3)->setName('Intermediate');
        $destinationAirport = (new Airport())->setId(5)->setName('Destination');

        $expectedAirportCollection = AirportCollection::createFromArray([
            $originAirport,
            $destinationAirport
        ]);

        $possibleRoutes = PossibleRoutesCollection::create()
            ->addPossibleRoutes(
                $originAirport,
                AirportCollection::createEmpty()
                    ->addAirport($intermediateAirport)
                    ->addAirport($destinationAirport)
            )
            ->addPossibleRoutes(
                $intermediateAirport,
                AirportCollection::createEmpty()
                    ->addAirport($destinationAirport)
            );

        $airportGraph = new AirportGraph($possibleRoutes);
        $airportCollection = $airportGraph->breadthFirstSearch($originAirport, $destinationAirport);

        $this->assertEquals($expectedAirportCollection, $airportCollection);
    }

    public function testBreadthFirstSearchWhenThereIsNoRouteReturnsEmptyCollection(): void
    {
        $originAirport = (new Airport())->setId(1)->setName('Origin');
        $airport2 = (new Airport())->setId(2)->setName('Airport 2');
        $airport3 = (new Airport())->setId(3)->setName('Airport 3');
        $destinationAirport = (new Airport())->setId(5)->setName('Destination');

        $possibleRoutes = PossibleRoutesCollection::create()
            ->addPossibleRoutes(
                $originAirport,
                AirportCollection::createEmpty()
                    ->addAirport($airport2)
            )
            ->addPossibleRoutes(
                $airport3,
                AirportCollection::createEmpty()
                    ->addAirport($destinationAirport)
            )
            ->addPossibleRoutes(
                $destinationAirport,
                AirportCollection::createEmpty()
                    ->addAirport($originAirport)
            );

        $airportGraph = new AirportGraph($possibleRoutes);
        $airportCollection = $airportGraph->breadthFirstSearch($originAirport, $destinationAirport);

        $this->assertEquals(AirportCollection::createEmpty(), $airportCollection);
    }

    public function testBreadthFirstSearchWhenThereIsRouteReturnsShortestPath(): void
    {
        $originAirport = (new Airport())->setId(1)->setName('Origin');
        $intermediateAirport = (new Airport())->setId(3)->setName('Intermediate');
        $destinationAirport = (new Airport())->setId(5)->setName('Destination');

        $expectedAirportCollection = AirportCollection::createFromArray([
            $originAirport,
            $destinationAirport
        ]);

        $possibleRoutes = PossibleRoutesCollection::create()
            ->addPossibleRoutes(
                $originAirport,
                AirportCollection::createEmpty()
                    ->addAirport($intermediateAirport)
                    ->addAirport($destinationAirport)
            )
            ->addPossibleRoutes(
                $intermediateAirport,
                AirportCollection::createEmpty()
                    ->addAirport($destinationAirport)
            )
            ->addPossibleRoutes(
                $destinationAirport,
                AirportCollection::createEmpty()
                    ->addAirport($originAirport)
            );

        $airportGraph = new AirportGraph($possibleRoutes);
        $airportCollection = $airportGraph->breadthFirstSearch($originAirport, $destinationAirport);

        $this->assertEquals($expectedAirportCollection, $airportCollection);
    }
}