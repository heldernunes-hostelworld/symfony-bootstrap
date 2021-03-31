<?php declare(strict_types=1);
namespace App\Tests\Unit\Domain\Context\AirportRoute\FindBestRoute\Validator;

use App\Domain\Context\AirportRoute\FindBestRoute\Exception\DestinationAirportNotFoundException;
use App\Domain\Context\AirportRoute\FindBestRoute\Exception\OriginAirportNotFoundException;
use App\Domain\Context\AirportRoute\FindBestRoute\Validator\Semantic as SemanticValidator;
use App\Domain\Shared\Entity\Airport;
use PHPUnit\Framework\TestCase;

class SemanticTest extends TestCase
{
    /** @var SemanticValidator */
    private $semanticValidator;

    protected function setUp(): void
    {
        $this->semanticValidator = new SemanticValidator();
    }

    /**
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     */
    public function testFindBestRouteWhenOriginNotFoundThrowsException(): void
    {
        $expectedException = new OriginAirportNotFoundException();

        $this->expectException(OriginAirportNotFoundException::class);
        $this->expectExceptionMessage($expectedException->getMessage());

        $this->semanticValidator->validate(null, null);
    }

    /**
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     */
    public function testFindBestRouteWhenDestinationNotFoundThrowsException(): void
    {
        $originAirport = (new Airport())->setId(1)->setName('Origin');

        $expectedException = new DestinationAirportNotFoundException();

        $this->expectException(DestinationAirportNotFoundException::class);
        $this->expectExceptionMessage($expectedException->getMessage());

        $this->semanticValidator->validate($originAirport, null);
    }

    /**
     * @throws DestinationAirportNotFoundException
     * @throws OriginAirportNotFoundException
     */
    public function testFindBestRouteWhenAllIsValidReturnTrue(): void
    {
        $originAirport = (new Airport())->setId(1)->setName('Origin');
        $destinationAirport = (new Airport())->setId(5)->setName('Destination');

        $this->assertTrue($this->semanticValidator->validate($originAirport, $destinationAirport));
    }
}