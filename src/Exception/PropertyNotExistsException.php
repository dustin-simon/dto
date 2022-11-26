<?php

namespace Dustin\Dto\Exception;

use Dustin\Dto\DtoInterface;

class PropertyNotExistsException extends DtoException
{
    private $property;

    public function __construct(DtoInterface $dto, string $property)
    {
        $this->property = $property;

        parent::__construct(
            $dto,
            \sprintf("Property '%s' does not exist in %s", $property, \get_class($dto))
        );
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}
