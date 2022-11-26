<?php

namespace Dustin\Dto\Exception;

use Dustin\Dto\DtoInterface;

class StaticPropertyException extends DtoException
{
    public function __construct(DtoInterface $dto, string $property)
    {
        parent::__construct(
            $dto,
            \sprintf("Property '%s' is static and cannot be handled by dtos.", $property)
        );
    }
}
