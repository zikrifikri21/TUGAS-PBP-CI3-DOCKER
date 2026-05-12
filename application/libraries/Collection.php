<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Pastikan CollectionItem di-load atau ditempatkan di file yang sama
require_once APPPATH . 'libraries/CollectionItem.php'; // Atau sesuaikan path Anda

/**
 * Class Collection
 *
 * Provides a fluent API for working with arrays of data,
 * allowing access to items as both objects and arrays.
 */
class Collection implements ArrayAccess
{
    /**
     * The items held by the collection.
     *
     * @var CollectionItem[]
     */
    protected $items = [];

    /**
     * Create a new Collection instance.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($items = [])
    {
        foreach ($this->getArrayableItems($items) as $key => $item) {
            $this->items[$key] = ($item instanceof CollectionItem) ? $item : new CollectionItem($item);
        }
    }

    /**
     * Create a new collection instance if the given value is not an instance of Collection.
     *
     * @param  mixed  $items
     * @return static
     */
    public static function make($items = [])
    {
        return new static($items);
    }

    /**
     * Get the value of the collection as a plain array (of original items or CollectionItems).
     * Use toArray() to get deep-converted arrays.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Get the collection's items as a plain array, converting CollectionItem wrappers to arrays recursively.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($item) {
            return $item->toArray();
        }, $this->items);
    }


    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $mappedItems = array_map($callback, $this->items, array_keys($this->items));

        // Bungkus ulang hasil map jika tidak CollectionItem
        $finalMappedItems = [];
        foreach ($mappedItems as $key => $item) {
            $finalMappedItems[$key] = ($item instanceof CollectionItem) ? $item : new CollectionItem($item);
        }

        return new static($finalMappedItems);
    }

    /**
     * Filter the collection using the given callback.
     *
     * @param  callable|null  $callback
     * @return static
     */
    public function filter(callable $callback = null)
    {
        if ($callback) {
            return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
        }

        return new static(array_filter($this->items));
    }

    /**
     * Apply the callback if the given "value" is (or resolves to) truthy.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @param  callable|null  $default
     * @return static
     */
    public function when($value, callable $callback, callable $default = null)
    {
        if ($value) {
            // Jalankan callback pertama jika $value bernilai TRUE
            // Gunakan ?: $this untuk menjaga chaining jika callback lupa me-return collection
            return $callback($this, $value) ?: $this;
        } elseif ($default) {
            // Jalankan callback default (else) jika $value bernilai FALSE
            return $default($this, $value) ?: $this;
        }

        return $this;
    }

    /**
     * Get the first item in the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return CollectionItem|mixed|null
     */
    public function first(callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($this->items) ? $default : reset($this->items);
        }

        foreach ($this->items as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Get the last item in the collection.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return CollectionItem|mixed|null
     */
    public function last(callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($this->items) ? $default : end($this->items);
        }

        return $this->filter($callback)->last(null, $default);
    }

    /**
     * Determine if the collection is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Determine if the collection is not empty.
     *
     * @return bool
     */
    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    /**
     * Pluck the given key's values from all items in the collection.
     *
     * @param  string  $valueKey
     * @param  string|null  $indexKey
     * @return static
     */
    public function pluck($valueKey, $indexKey = null)
    {
        $result = [];
        foreach ($this->items as $item) {
            $item_val = $item->$valueKey; // CollectionItem handles null safety
            if ($indexKey !== null) {
                $item_key = $item->$indexKey; // CollectionItem handles null safety
                if ($item_key !== null) {
                    $result[$item_key] = $item_val;
                }
            } else {
                $result[] = $item_val;
            }
        }
        return new static($result);
    }

    /**
     * Merge the collection with the given items.
     *
     * @param  mixed  $items
     * @return static
     */
    public function merge($items)
    {
        return new static(array_merge($this->items, $this->getArrayableItems($items)));
    }


    /**
     * Get the collection of items as a one-dimensional array.
     *
     * @return array
     */
    protected function getArrayableItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        // Jika ini adalah objek tunggal, bungkus dalam array
        if (is_object($items)) {
            return [$items];
        }

        return (array) $items;
    }

    /*
    |--------------------------------------------------------------------------
    | ArrayAccess Implementation
    |--------------------------------------------------------------------------
    */

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = ($value instanceof CollectionItem) ? $value : new CollectionItem($value);
        } else {
            $this->items[$offset] = ($value instanceof CollectionItem) ? $value : new CollectionItem($value);
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    /*
    |--------------------------------------------------------------------------
    | IteratorAggregate Implementation (for foreach loops)
    |--------------------------------------------------------------------------
    */

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
