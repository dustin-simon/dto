<?php

namespace Dustin\Dto;

class Container extends PropertyDto implements \Countable
{
    private array $elements = [];

    public function __construct(array $elements = [])
    {
        $this->setElements($elements);
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function setElements(array $elements): void
    {
        $this->elements = $elements;
    }

    public function addElement($element): void
    {
        $this->elements[] = $element;
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function getIterator(): \Traversable
    {
        yield from $this->elements;
    }
}
