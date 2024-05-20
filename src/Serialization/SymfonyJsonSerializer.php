<?php

namespace NineDigit\eKasa\Client\Serialization;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnsupportedFormatException;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class SymfonyJsonSerializer implements SerializerInterface
{
    private Serializer $serializer;

    function __construct()
    {
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $discriminator = new ClassDiscriminatorFromClassMetadata($classMetadataFactory);
        $normalizers = [
            // TODO: Add ProblemNormalizer (https://symfony.com/doc/current/components/serializer.html#built-in-normalizers)
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            new ObjectNormalizer($classMetadataFactory, null, null, $extractor, $discriminator)
        ];
        $this->serializer = new Serializer($normalizers, [
            'json' => new JsonEncoder()
        ]);
    }

    function serialize($data): string
    {
        return $this->serializer->serialize($data, 'json', [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true
        ]);
    }

    function deserialize($data, $type)
    {
        // return $this->serializer->deserialize($data, $type, 'json');

        $format = 'json';

        if (!$this->serializer->supportsDecoding($format)) {
            throw new UnsupportedFormatException(sprintf('Deserialization for the format "%s" is not supported.', $format));
        }

        $data = $this->serializer->decode($data, $format);

        if ($this->_is_array($data)) {
            $result = array();

            foreach ($data as $item) {
                $entry = $this->serializer->denormalize($item, $type, $format);
                array_push($result, $entry);
            }

            return $result;
        } else {
            return $this->serializer->denormalize($data, $type, $format);
        }
    }

    private function _is_array($arr): bool {
        $keys = array_keys($arr);
        foreach ($keys as $key) {
            if (!is_numeric($key)) {
                return false;
            }
        }
        return true;
    }
}