<?php

namespace Dustin\Dto\Exception;

use Dustin\Dto\DtoInterface;

class NotUnsettableException extends DtoException
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
            \sprintf("Field '%s' is not unsettable", $field)
        );
    }

    public function getField(): string
    {
        return $this->field;
    }
}
