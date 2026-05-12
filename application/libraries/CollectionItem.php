<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class CollectionItem
 *
 * Wraps an individual item (array or object) within a Collection,
 * providing consistent property access, array access, and null safety for nested properties.
 */
class CollectionItem implements ArrayAccess
{
    /**
     * The original item (array or object).
     *
     * @var mixed
     */
    protected $originalItem;

    /**
     * Create a new CollectionItem instance.
     *
     * @param mixed $item
     */
    public function __construct($item)
    {
        $this->originalItem = $item;
    }

    /**
     * Get a property from the item.
     * Handles both object and array access, and provides null safety.
     *
     * @param string $key
     * @return CollectionItem|mixed|null
     */
    public function __get($key)
    {
        $value = null;

        if (is_array($this->originalItem)) {
            $value = $this->originalItem[$key] ?? null;
        } elseif (is_object($this->originalItem)) {
            $value = $this->originalItem->$key ?? null;
        }

        // Jika nilainya adalah array atau objek, bungkus lagi dalam CollectionItem
        if (is_array($value) || is_object($value)) {
            return new static($value);
        }

        return $value;
    }

    /**
     * Set a property on the item.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        if (is_array($this->originalItem)) {
            $this->originalItem[$key] = $value;
        } elseif (is_object($this->originalItem)) {
            $this->originalItem->$key = $value;
        }
    }

    /**
     * Check if a property exists.
     *
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        if (is_array($this->originalItem)) {
            return isset($this->originalItem[$key]);
        } elseif (is_object($this->originalItem)) {
            return isset($this->originalItem->$key);
        }
        return false;
    }

    /**
     * Unset a property.
     *
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        if (is_array($this->originalItem)) {
            unset($this->originalItem[$key]);
        } elseif (is_object($this->originalItem)) {
            unset($this->originalItem->$key);
        }
    }

    /**
     * Get the original, unwrapped item.
     *
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->originalItem;
    }

    /**
     * Convert the wrapped item to a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        if (is_array($this->originalItem)) {
            return $this->originalItem;
        } elseif (is_object($this->originalItem)) {
            // Recursively convert objects to arrays
            $array = [];
            foreach ($this->originalItem as $key => $value) {
                if (is_object($value) && $value instanceof CollectionItem) {
                    $array[$key] = $value->toArray();
                } elseif (is_object($value)) {
                    $array[$key] = json_decode(json_encode($value), true); // Simple deep conversion
                } elseif (is_array($value)) {
                    $array[$key] = json_decode(json_encode($value), true); // Simple deep conversion
                } else {
                    $array[$key] = $value;
                }
            }
            return $array;
        }
        return (array) $this->originalItem;
    }

    /*
    |--------------------------------------------------------------------------
    | ArrayAccess Implementation (for accessing the wrapped item like an array)
    |--------------------------------------------------------------------------
    */

    public function offsetExists($offset): bool
    {
        if (is_array($this->originalItem)) {
            return isset($this->originalItem[$offset]);
        } elseif (is_object($this->originalItem)) {
            return isset($this->originalItem->$offset);
        }
        return false;
    }

    public function offsetGet($offset): mixed
    {
        if (is_array($this->originalItem)) {
            $value = $this->originalItem[$offset] ?? null;
        } elseif (is_object($this->originalItem)) {
            $value = $this->originalItem->$offset ?? null;
        } else {
            $value = null;
        }

        // Jika nilai adalah array atau objek, bungkus lagi dalam CollectionItem
        if (is_array($value) || is_object($value)) {
            return new static($value);
        }

        return $value;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_array($this->originalItem)) {
            if (is_null($offset)) {
                $this->originalItem[] = $value;
            } else {
                $this->originalItem[$offset] = $value;
            }
        } elseif (is_object($this->originalItem)) {
            $this->originalItem->$offset = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        if (is_array($this->originalItem)) {
            unset($this->originalItem[$offset]);
        } elseif (is_object($this->originalItem)) {
            unset($this->originalItem->$offset);
        }
    }
}
