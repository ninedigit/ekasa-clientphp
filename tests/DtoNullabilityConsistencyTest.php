<?php

namespace NineDigit\eKasa\Client\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

/**
 * SymfonyJsonSerializer skladá extraktor typov ako
 * [new PhpDocExtractor(), new ReflectionExtractor()], takže anotácia @var má
 * prednosť pred natívnym typom vlastnosti. Ak si tieto dva zdroje protirečia,
 * deserializácia sa riadi docblockom a natívny typ potom spôsobí chybu.
 *
 * Tento test stráži, aby boli obidva zdroje zhodné vo všetkých triedach klienta.
 */
final class DtoNullabilityConsistencyTest extends TestCase
{
    public function testVarAnnotationNullabilityMatchesNativePropertyType()
    {
        $mismatches = array();

        foreach ($this->getClassNames() as $className) {
            $class = new ReflectionClass($className);

            foreach ($class->getProperties() as $property) {
                if ($property->getDeclaringClass()->getName() !== $className) {
                    continue; // zdedené vlastnosti overíme na predkovi
                }

                $docNullable = $this->getVarAnnotationNullability($property);

                if ($docNullable === null) {
                    continue; // bez @var anotácie sa použije natívny typ
                }

                $type = $property->getType();

                if (!$type instanceof ReflectionNamedType) {
                    continue;
                }

                if ($docNullable !== $type->allowsNull()) {
                    $mismatches[] = sprintf(
                        '%s::$%s -- @var is %s, native type "%s" is %s',
                        $className,
                        $property->getName(),
                        $docNullable ? 'nullable' : 'not nullable',
                        ($type->allowsNull() ? '?' : '') . $type->getName(),
                        $type->allowsNull() ? 'nullable' : 'not nullable'
                    );
                }
            }
        }

        $this->assertSame(
            array(),
            $mismatches,
            "Anotácia @var nesúhlasí s natívnym typom vlastnosti:\n  " . implode("\n  ", $mismatches)
        );
    }

    /**
     * @return bool|null true/false ak je @var prítomná, inak null
     */
    private function getVarAnnotationNullability(ReflectionProperty $property): ?bool
    {
        $docComment = $property->getDocComment();

        if ($docComment === false || !preg_match('/@var\s+(\S+)/', $docComment, $matches)) {
            return null;
        }

        $varType = $matches[1];

        if (strpos($varType, '?') === 0) {
            return true;
        }

        foreach (explode('|', $varType) as $part) {
            if (strtolower(trim($part)) === 'null') {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string[]
     */
    private function getClassNames(): array
    {
        $sourceDirectory = dirname(__DIR__) . '/src';
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($sourceDirectory));
        $classNames = array();

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $contents = file_get_contents($file->getPathname());

            if (!preg_match('/^namespace\s+([^;]+);/m', $contents, $namespaceMatch)) {
                continue;
            }

            if (!preg_match('/^(?:final\s+|abstract\s+)?class\s+(\w+)/m', $contents, $classMatch)) {
                continue;
            }

            $className = trim($namespaceMatch[1]) . '\\' . $classMatch[1];

            if (class_exists($className)) {
                $classNames[] = $className;
            }
        }

        $this->assertNotEmpty($classNames, 'No classes discovered under src/.');

        return $classNames;
    }
}
