<?php

namespace Dustin\Dto;

/**
 * DTO class which can only hold scalar values, arrays or other NestedDtos.
 */
class NestedDto extends Dto
{
    public function set(string $field, $value): void
    {
        $this->validate($value);

        parent::set($field, $value);
    }

    private function validate($value)
    {
        if (
            $value === null ||
            \is_scalar($value)
        ) {
            return;
        }

        if (\is_object($value) &&
            $value instanceof self
        ) {
            return;
        }

        if (is_array($value)) {
            foreach ($value as $valueItem) {
                $this->validate($valueItem);
            }

            return;
        }

        $type = is_object($value) ? get_class($value) : gettype($value);

        throw new \InvalidArgumentException(\sprintf('A NestedDto can only contain scalar values, null, arrays or other NestedDtos. %s given.', $type));
    }
}
