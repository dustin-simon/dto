<?php

namespace Dustin\Dto\Exception;

use Dustin\Dto\DtoInterface;

class NotAnArrayException extends DtoException
{
    /**
     * @var string
     */
    private $field;

    public function __construct(DtoInterface $dto, string $field)
    {
        $this->field = $field;

        parent::__construct(
            $dto,
            \sprintf("Field '%s' must be array to add values to it.", $field)
        );
    }

    public function getField(): string
    {
        return $this->field;
    }
}
