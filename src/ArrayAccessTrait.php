<?php

namespace Dustin\Dto;

trait ArrayAccessTrait
{
    public function offsetExists($offset): bool
    {
        return $this->has(\strval($offset));
    }

    public function offsetGet($offset)
    {
        return $this->get(\strval($offset));
    }

    /**
     * @throws \RuntimeException
     */
    public function offsetSet($offset, $value): void
    {
        if (\is_null($offset)) {
            throw new \RuntimeException('You can not set a value to a DTO without offset.');
        }

        $this->set(\strval($offset), $value);
    }

    public function offsetUnset($offset): void
    {
        $this->unset(\strval($offset));
    }
}
