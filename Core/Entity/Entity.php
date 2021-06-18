<?php

namespace Core\Entity;

/**
 * Entity use heritage for each entity
 */
abstract class Entity
{
    /**
     * __get magic method 
     *
     * @param  string $key
     * @return string getter 
     */
    public function __get($key)
    {
        try {
            $method = 'get' . ucfirst($key);
            $this->$key = $this->$method();
            return $this->$key;
        } catch (\Exception $e) {
            var_dump($e);
        }
    }
}
