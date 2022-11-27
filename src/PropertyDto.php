<?php

namespace Dustin\Dto;

use Dustin\Dto\Exception\NotUnsettableException;
use Dustin\Dto\Exception\PropertyNotExistsException;
use Dustin\Dto\Exception\StaticPropertyException;

abstract class PropertyDto extends AbstractDto
{
    public function __construct(array $data = [])
    {
        $this->setList($data);
    }

    /**
     * @throws StaticPropertyException
     * @throws PropertyNotExistsException
     */
    public function set(string $field, $value): void
    {
        $reflectionObject = new \ReflectionObject($this);

        $setterMethodName = 'set'.\ucfirst($field);

        if ($reflectionObject->hasMethod($setterMethodName)) {
            $this->$setterMethodName($value);

            return;
        }

        if (!$reflectionObject->hasProperty($field)) {
            throw new PropertyNotExistsException($this, $field);
        }

        /** @var \ReflectionProperty $reflectionProperty */
        $reflectionProperty = $reflectionObject->getProperty($field);

        if ($reflectionProperty->isStatic()) {
            throw new StaticPropertyException($this, $field);
        }

        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this, $value);
    }

    /**
     * @throws PropertyNotExistsException
     * @throws StaticPropertyException
     * @throws NotUnsettableException
     */
    public function unset(string $field): void
    {
        $reflectionObject = new \ReflectionObject($this);

        if (!$reflectionObject->hasProperty($field)) {
            throw new PropertyNotExistsException($this, $field);
        }

        /** @var \ReflectionProperty $property */
        $property = $reflectionObject->getProperty($field);
        $property->setAccessible(true);

        if ($property->isStatic()) {
            throw new StaticPropertyException($this, $field);
        }

        if (!$property->isInitialized($this)) {
            return;
        }

        if ($property->hasType() && !$property->getType()->allowsNull()) {
            throw new NotUnsettableException($this, $field);
        }

        $property->setValue($this, null);
    }

    /**
     * @throws StaticPropertyException
     * @throws PropertyNotExistsException
     */
    public function get(string $field)
    {
        $reflectionObject = new \ReflectionObject($this);
        $getterMethodName = 'get'.\ucfirst($field);

        if ($reflectionObject->hasMethod($getterMethodName)) {
            return $this->$getterMethodName();
        }

        if (!$reflectionObject->hasProperty($field)) {
            throw new PropertyNotExistsException($this, $field);
        }

        /** @var \ReflectionProperty $reflectionProperty */
        $reflectionProperty = $reflectionObject->getProperty($field);

        if ($reflectionProperty->isStatic()) {
            throw new StaticPropertyException($this, $field);
        }

        $reflectionProperty->setAccessible(true);

        if ($reflectionProperty->hasType() && !$reflectionProperty->isInitialized($this)) {
            return null;
        }

        return $reflectionProperty->getValue($this);
    }

    public function add(string $field, $value): void
    {
        $reflectionObject = new \ReflectionObject($this);
        $adderMethodName = 'add'.\ucfirst($field);

        if ($reflectionObject->hasMethod($adderMethodName)) {
            $this->$adderMethodName($value);

            return;
        }

        parent::add($field, $value);
    }

    public function has(string $field): bool
    {
        $reflectionObject = new \ReflectionObject($this);

        if (!$reflectionObject->hasProperty($field)) {
            return false;
        }

        return !$reflectionObject->getProperty($field)->isStatic();
    }

    public function getFields(): array
    {
        $fields = [];
        $reflectionObject = new \ReflectionObject($this);

        /** @var \ReflectionProperty $reflectionProperty */
        foreach ($reflectionObject->getProperties() as $reflectionProperty) {
            if ($reflectionProperty->isStatic()) {
                continue;
            }

            $propertyName = $reflectionProperty->getName();

            $fields[] = $propertyName;
        }

        return $fields;
    }

    public function isEmpty(): bool
    {
        return \empty(\array_filter($this->toArray(), function ($value) {
            return \is_array($value) ? !\empty($value) : $value !== null;
        }));
    }
}
