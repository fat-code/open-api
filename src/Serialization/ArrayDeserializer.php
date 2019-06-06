<?php declare(strict_types=1);

namespace FatCode\OpenApi\Serialization;

use FatCode\OpenApi\Schema\SchemaObject\Schema;
use FatCode\OpenApi\Schema\SchemaObject\SchemaObject;
use FatCode\OpenApi\Schema\SchemaPrimitive\SchemaPrimitive;
use ReflectionClass;

final class ArrayDeserializer
{
    public function __invoke(array $serializedSchemaObject, string $schemaObjectClass) : SchemaObject
    {
        foreach ($serializedSchemaObject as $parameter) {

            if (is_array($parameter)) {
                $this($pa);
            }
        }

//            $parameterType = $parameter->getClass()
//                ? $parameter->getClass()->getName()
//                : $parameter->getType();

        $constructor = (new ReflectionClass($schemaObject))->getConstructor();

        foreach ($constructor->getParameters() as $parameter) {
            $parameterName = $parameter->getName();
            $parameterValue = $this->callGetterForParameter($parameterName, $schemaObject);
//            $parameterType = $parameter->getClass()
//                ? $parameter->getClass()->getName()
//                : $parameter->getType();

            if ($parameterValue instanceof SchemaObject) {
                $parameterValue = $this($parameterValue);
            } elseif ($parameterValue instanceof SchemaPrimitive) {
                $parameterValue = $parameterValue->getValue();
            } else {
                throw SerializerException::forUnexpectedParameterValueInstance(get_class($parameterValue));
            }

            $serializedSchema[$parameterName] = $parameterValue;
        }

        return $serializedSchema;
    }

    private function callGetterForParameter(string $parameterName, Schema $schema)
    {
        $parameterName = ucfirst($parameterName);
        $getterName = "get$parameterName";

        return call_user_func([$schema, $getterName]);
    }
}