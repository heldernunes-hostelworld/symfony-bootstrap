<?php declare(strict_types=1);
namespace App\Tests\Unit\Domain\Context\AirportRoute\FindBestPath;

use App\Domain\Context\AirportRoute\FindBestPath\AirportRepository;
use App\Domain\Context\AirportRoute\FindBestPath\Collection\AirportCollection;
use App\Domain\Context\AirportRoute\FindBestPath\Collection\PossibleRoutesCollection;
use App\Domain\Context\AirportRoute\FindBestPath\Exception\DestinationAirportNotFoundException;
use App\Domain\Context\AirportRoute\FindBestPath\Exception\OriginAirportNotFoundException;
use App\Domain\Context\AirportRoute\FindBestPath\RequestModel;
use App\Domain\Context\AirportRoute\FindBestPath\ResponseModel;
use App\Domain\Context\AirportRoute\FindBestPath\RouteRepository;
use App\Domain\Context\AirportRoute\FindBestPath\Service;
use App\Domain\Context\AirportRoute\FindBestPath\ShortestPathFinder;
use App\Domain\Context\AirportRoute\FindBestPath\Validator\Semantic as SemanticValidator;
use App\Domain\Shared\Entity\Airport;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    /** @var MockObject|SemanticValidator  */
    private $semanticValidatorMock;

    /** @var MockObject|AirportRepository  */
    private $airportRepositoryMock;

    /** @var MockObject|RouteRepository  */
    private $routeRepositoryMock;

    /** @var MockObject|ShortestPathFinder  */
    private $shortestPathFinderMock;

    /** @var Service  */
    private $service;

    protected function setUp(): void
    {
        $this->semanticValidatorMock = $this->getSemanticValidatorMock();
        $this->airportRepositoryMock = $this->getAirportRepositoryMock();
        $this->routeRepositoryMock = $this->getRouteRepositoryMock();
        $this->shortestPathFinderMock = $this->getShortestPathFinderMock();

        $this->service = new Service(
            $this->semanticValidatorMock,
            $this->airportRepositoryMock,
            $this->routeRepositoryMock,
            $this->shortestPathFinderMock
        );
    }

    /**
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     */
    public function testFindBestRouteWhenAllIsValidReturnAirportCollection(): void
    {
        $requestModel = new RequestModel(1, 5);

        $originAirport = (new Airport())->setId(1)->setName('Origin');
        $intermediateAirport = (new Airport())->setId(3)->setName('Intermediate');
        $destinationAirport = (new Airport())->setId(5)->setName('Destination');

        $expectedAirportCollection = AirportCollection::createFromArray([
            $originAirport,
            $intermediateAirport,
            $destinationAirport
        ]);

        $this->semanticValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $this->airportRepositoryMock
            ->expects($this->exactly(2))
            ->method('getById')
            ->withConsecutive([$requestModel->getOriginAirportId()], [$requestModel->getDestinationAirportId()])
            ->willReturnOnConsecutiveCalls($originAirport, $destinationAirport);

        $this->routeRepositoryMock
            ->expects($this->once())
            ->method('fetchAirportsPossibleRoutes')
            ->willReturn(
                PossibleRoutesCollection::create()
                    ->addPossibleRoutes(
                        $originAirport,
                        AirportCollection::createEmpty()
                            ->addAirport($intermediateAirport)
                    )
                    ->addPossibleRoutes(
                        $intermediateAirport,
                        AirportCollection::createEmpty()
                            ->addAirport($destinationAirport)
                    )
            );

        $this->shortestPathFinderMock
            ->expects($this->once())
            ->method('findShortestPath')
            ->willReturn($expectedAirportCollection);

        $expectedResponse = new ResponseModel($expectedAirportCollection);

        $this->assertEquals($expectedResponse, $this->service->findBestRoute($requestModel));
    }

    /**
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     */
    public function testFindBestRouteWhenOriginNotFoundThrowsException(): void
    {
        $requestModel = new RequestModel(1, 5);

        $this->airportRepositoryMock
            ->expects($this->exactly(2))
            ->method('getById')
            ->willReturn(null);

        $expectedException = new OriginAirportNotFoundException();

        $this->semanticValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->willThrowException($expectedException);

        $this->routeRepositoryMock
            ->expects($this->never())
            ->method('fetchAirportsPossibleRoutes');

        $this->shortestPathFinderMock
            ->expects($this->never())
            ->method('findShortestPath');

        $this->expectException(OriginAirportNotFoundException::class);
        $this->expectExceptionMessage($expectedException->getMessage());

        $this->service->findBestRoute($requestModel);
    }

    /**
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     */
    public function testFindBestRouteWhenDestinationNotFoundThrowsException(): void
    {
        $requestModel = new RequestModel(1, 5);

        $originAirport = (new Airport())->setId(1)->setName('Origin');

        $this->airportRepositoryMock
            ->expects($this->exactly(2))
            ->method('getById')
            ->withConsecutive([$requestModel->getOriginAirportId()], [$requestModel->getDestinationAirportId()])
            ->willReturnOnConsecutiveCalls($originAirport, null);

        $expectedException = new DestinationAirportNotFoundException();

        $this->semanticValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->willThrowException($expectedException);

        $this->routeRepositoryMock
            ->expects($this->never())
            ->method('fetchAirportsPossibleRoutes');

        $this->shortestPathFinderMock
            ->expects($this->never())
            ->method('findShortestPath');

        $this->expectException(DestinationAirportNotFoundException::class);
        $this->expectExceptionMessage($expectedException->getMessage());

        $this->service->findBestRoute($requestModel);
    }

    /**
     * @return MockObject|SemanticValidator
     */
    private function getSemanticValidatorMock()
    {
        return $this->getMockBuilder(SemanticValidator::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['validate'])
            ->getMock();
    }

    /**
     * @return MockObject|AirportRepository
     */
    private function getAirportRepositoryMock()
    {
        return $this->getMockBuilder(AirportRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getById'])
            ->getMock();
    }

    /**
     * @return MockObject|RouteRepository
     */
    private function getRouteRepositoryMock()
    {
        return $this->getMockBuilder(RouteRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['fetchAirportsPossibleRoutes'])
            ->getMock();
    }

    /**
     * @return MockObject|ShortestPathFinder
     */
    private function getShortestPathFinderMock()
    {
        return $this->getMockBuilder(ShortestPathFinder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findShortestPath'])
            ->getMock();
    }
}