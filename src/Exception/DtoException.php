<?php

namespace Dustin\Dto\Exception;

use Dustin\Dto\DtoInterface;

class DtoException extends \Exception
{
    /**
     * @var DtoInterface
     */
    private $dto;

    public function __construct(DtoInterface $dto, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $this->dto = $dto;

        parent::__construct($message, $code, $previous);
    }

    public function getDto(): DtoInterface
    {
        return $this->dto;
    }
}
