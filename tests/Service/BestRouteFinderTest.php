<?php

namespace App\Tests\Service;

use App\Entity\Airport;
use App\Exception\RuntimeException;
use App\Service\BestRouteFinder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class BestRouteFinderTest extends TestCase
{
    /**
     * @dataProvider routesProvider
     */
    public function testBestRouteFinding(array $routes, array $expectedIds): void
    {
        $finder = $this->getFinder($routes);

        $bestRoute = $finder->find(1, 3);

        $this->assertCount(count($expectedIds), $bestRoute);
        foreach ($expectedIds as $index => $id) {
            $this->assertSame($id, $bestRoute[$index]->getId());
        }
    }

    public function routesProvider(): array
    {
        return [
            'the shortest path from two available' => [
                [1 => [2, 3], 2 => [3], 3 => []],
                [1, 3]
            ],
            'the only path' => [
                [1 => [2], 2 => [3], 3 => []],
                [1, 2, 3]
            ],
            'the only path (the reverse path 3 => 1 is ignored)' => [
                [1 => [2], 2 => [3], 3 => [1]],
                [1, 2, 3]
            ],
        ];
    }

    public function testThrowingExceptionDueToMissingAirport(): void
    {
        $this->expectException(RuntimeException::class);
        $finder = $this->getFinder([1 => []]);
        $finder->find(1, 2);
    }

    public function testThrowingExceptionDueToNoRoute(): void
    {
        $this->expectException(RuntimeException::class);
        $finder = $this->getFinder([1 => [2], 2 => []]);
        $finder->find(2, 1);
    }

    private function getFinder(array $destinationsByAirport): BestRouteFinder
    {
        $airports = [];
        foreach (array_keys($destinationsByAirport) as $airportId) {
            $airports[$airportId] = $this->createAirportMock($airportId);
        }

        foreach ($destinationsByAirport as $originId => $destinationIds) {
            foreach ($destinationIds as $destinationId) {
                $airports[$originId]->addRoute($airports[$destinationId]);
            }
        }

        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn(array_values($airports));

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);

        return new BestRouteFinder($entityManager);
    }

    private function createAirportMock(int $id): Airport
    {
        $airport = $this->getMockBuilder(Airport::class)
            ->onlyMethods(['getId'])
            ->getMock();
        $airport->method('getId')->willReturn($id);
        return $airport;
    }
}
