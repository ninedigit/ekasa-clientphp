<?php

namespace NineDigit\eKasa\Client\Serialization;

use Doctrine\Common\Annotations\AnnotationReader;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
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
        // Symfony >= 6.4 reads mapping metadata from PHP 8 attributes via AttributeLoader
        // (AnnotationLoader was removed in Symfony 7.0). On Symfony 5.4 (PHP 7.4) fall back to
        // the Doctrine annotation reader, which parses the docblock annotations instead.
        if (class_exists(AttributeLoader::class)) {
            $metadataLoader = new AttributeLoader();
        } else {
            $metadataLoader = new AnnotationLoader(new AnnotationReader());
        }
        $classMetadataFactory = new ClassMetadataFactory($metadataLoader);
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
        return $this->serializer->deserialize($data, $type, 'json');
    }
}