<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class FlatteningObjectNormalizer implements ContextAwareNormalizerInterface
{
    public const FLAT_PROPERTIES = 'flat_properties';

    /**
     * @var ObjectNormalizer
     */
    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $this->objectNormalizer->supportsNormalization($data, $format)
            && !empty($context[self::FLAT_PROPERTIES]);
    }

    public function normalize($object, $format = null, array $context = []): array
    {
        $data = $this->objectNormalizer->normalize($object, $format, $context);
        $result = [];
        array_walk_recursive($data, function ($value, $property) use (&$result) {
            $result[$property] = $value;
        });
        return $result;
    }
}
