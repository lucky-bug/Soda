<?php

namespace Soda\Core;

use ReflectionProperty;
use Soda\Core\Exception\ArgumentException;
use Soda\Core\Exception\PropertyException;
use Soda\Core\Exception\ReadOnlyException;
use Soda\Core\Exception\WriteOnlyException;
use Soda\Helpers\ArrayHelpers;
use Soda\Helpers\StringHelpers;

class Base
{
    public function __construct($options = [])
    {
        foreach ($options as $key => $value) {
            $key = ucfirst($key);
            $method = "set{$key}";

            $this->$method($value);
        }
    }

    public function __call($name, $arguments)
    {
        $getMatches = StringHelpers::match($name, '^get([a-zA-Z0-9]+)$');

        if (count($getMatches) > 0) {
            $property = lcfirst($getMatches[0]);

            if (property_exists($this, $property)) {
                if (!$this->canReadProperty($property)) {
                    throw new WriteOnlyException("{$property} is write-only!");
                }

                return $this->$property ?? null;
            } else {
                throw new PropertyException('Invalid property!');
            }
        }

        $setMatches = StringHelpers::match($name, '^set([a-zA-Z0-9]+)$');

        if (count($setMatches) > 0) {
            $property = lcfirst($setMatches[0]);

            if (property_exists($this, $property)) {
                if (!$this->canWriteProperty($property)) {
                    throw new ReadOnlyException("{$property} is read-only!");
                }

                $this->$property = $arguments[0];

                return $this;
            } else {
                throw new PropertyException('Invalid property!');
            }
        }

        throw new ArgumentException("{$name} method not implemented!");
    }

    public function __get($name)
    {
        $function = 'get' . ucfirst($name);
        return $this->$function();
    }

    public function __set($name, $value)
    {
        $function = 'set' . ucfirst($name);
        return $this->$function($value);
    }

    protected function canReadProperty($property)
    {
        $reflection = new ReflectionProperty($this, $property);
        $parsed = $this->parseComment($reflection->getDocComment());

        return $parsed['@getter'] ?? false;
    }

    protected function canWriteProperty($property)
    {
        $reflection = new ReflectionProperty($this, $property);
        $parsed = $this->parseComment($reflection->getDocComment());

        return $parsed['@setter'] ?? false;
    }

    protected function parseComment($comment)
    {
        $meta = array();
        $pattern = "(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_]*)";
        $matches = StringHelpers::match($comment, $pattern);

        if ($matches != null) {
            foreach ($matches as $match) {
                $parts = ArrayHelpers::clean(
                    ArrayHelpers::trim(
                        StringHelpers::split($match, "[\s]", 2)
                    )
                );

                $meta[$parts[0]] = true;
                
                if (count($parts) > 1) {
                    $meta[$parts[0]] = ArrayHelpers::clean(
                        ArrayHelpers::trim(
                            StringHelpers::split($parts[1], ",")
                        )
                    );
                }
            }
        }

        return $meta;
    }
}
