<?php

namespace Dustin\Dto\Exception;

use Dustin\Dto\DtoInterface;

class NotAllowedFieldException extends DtoException
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
            \sprintf("Field '%s' is not allowed in %s!", $field, \get_class($dto))
        );
    }

    public function getField(): string
    {
        return $this->field;
    }
}
