<?php declare(strict_types=1);
namespace App\Tests\Unit\Infrastructure\AirportRoute;

use App\Domain\Context\AirportRoute\FindBestRoute\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestRoute\Collection\PossibleRoutesCollection;
use App\Domain\Shared\Entity\Airport;
use App\Infrastructure\AirportRoute\BestRouteFinder;
use PHPUnit\Framework\TestCase;

class BestRouteFinderTest extends TestCase
{
    private BestRouteFinder $bestRouteFinder;

    protected function setUp(): void
    {
        $this->bestRouteFinder = new BestRouteFinder();
    }

    public function testFindShortestPathWhenThereIsRouteReturnsAirportCollectionWithShortestPath(): void
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

        $airportCollection = $this->bestRouteFinder->findShortestPath(
            $possibleRoutes,
            $originAirport,
            $destinationAirport
        );

        $this->assertEquals($expectedAirportCollection, $airportCollection);
    }
}