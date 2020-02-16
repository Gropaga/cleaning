<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Application\Shared;

use BadMethodCallException;
use Doctrine\Common\Inflector\Inflector;

trait AsArrayTrait
{
    public function offsetExists($offset): bool
    {
        $prop = Inflector::camelize($offset);

        return isset($this->$prop);
    }

    public function offsetGet($offset)
    {
        $prop = Inflector::camelize($offset);

        return $this->$prop;
    }

    /**
     * @throws BadMethodCallException
     */
    public function offsetSet($offset, $value): void
    {
        throw new BadMethodCallException(sprintf('Method "%s" not implemented.', __METHOD__));
    }

    /**
     * @throws BadMethodCallException
     */
    public function offsetUnset($offset): void
    {
        throw new BadMethodCallException(sprintf('Method "%s" not implemented.', __METHOD__));
    }
}
