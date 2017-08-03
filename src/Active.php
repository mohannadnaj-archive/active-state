<?php

namespace Mohannadnaj;

class Active
{
    /**
     * Static array that holds all loaded keys and values.
     *
     * @var array
     */
    private static $loaded = array();

    /**
     * Static default settings.
     *
     * @var array
     */
    private static $defaults = array(
                                'false'  => null,
                                'true'   => 'active',
                                'return' => '',
                               );


    /**
     * Static default boolean values.
     *
     * @var array
     */
    private static $booleanValues = array(
                                     'bool',
                                     'boolean',
                                    );

    /**
     * Default global key to be used if no key is given.
     *
     * @var string
     */
    private static $globalKey = '_ACTIVESTATE_GLOBAL_KEY';


    /**
     * Set the active item (value) at the given key associated with the given settings.
     *
     * @param  string|array $key
     * @param  null|mixed  $value
     * @param  null|array  $settings
     * @return void
     */
    public static function set($key, $value = null, $settings = null)
    {
        if (is_array($key)) {
            $settings = $key;
            if (count($settings) == 1 && array_keys($settings) === array(0)) {
                $settings = array(static::$globalKey => $settings[0]);
            }

            return static::setActiveFromArray($settings);
        }

        if (is_null($value)) {
            $value = $key;

            $key = static::$globalKey;
        }

        return static::setActive($key, $value, $settings);

    }//end set()


    /**
     * Get the active item.
     *
     * @param  null|string $key
     * @param  null|string  $default
     * @return mixed|null
     */
    public static function get($key = null, $default = null)
    {
        if (is_null($key)) {
            $key = static::$globalKey;
        }

        $active_item = static::getActive($key);

        if ($active_item) {
            return $active_item;
        }

        return $default;

    }//end get()


    /**
     * Check if the given value is the active item for at the given key.
     *
     * @param  string  $key
     * @param  null|string $value
     * @return boolean|null|string
     */
    public static function is($key, $value = null)
    {
        if (is_null($value)) {
            $value = $key;
            $key   = static::$globalKey;
        }

        return static::isActive($key, $value);

    }//end is()


    /**
     * Save the given value and settings as the active item for the given key.
     *
     * @param  string $key
     * @param  mixed  $value
     * @param  array  $settings
     * @return void
     */
    private static function setActive($key, $value, $settings)
    {
        static::pushActive($key, $value, static::prepareSettings($settings));

    }//end setActive()


    /**
     * Set the active item using a given array.
     *
     * @param  array  array
     * @return void
     */
    private static function setActiveFromArray($array)
    {
        list($key, $value) = static::extractKeyAndValue($array);

        if(empty($key)) {
            $key = static::$globalKey;
        }

        static::setActive($key, $value, $array);

    }//end setActiveFromArray()


    /**
     * Check if the given value is the active item at the given key.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return string|boolean|null
     */
    private static function isActive($key, $value)
    {
        $set = array_key_exists($key, static::$loaded) ? static::$loaded[$key] : null;

        if(is_null($set)) {
            return null;
        }

        $isActive = $set['active_item'] === $value;

        if (in_array($set['return'], static::$booleanValues)) {
            return $isActive;
        }

        if ($isActive) {
            return $set['true'];
        } else {
            return $set['false'];
        }

    }//end isActive()


    /**
     * Get the active item for the given key.
     *
     * @param  $key
     * @return mixed
     */
    private static function getActive($key)
    {
        $set = array_key_exists($key, static::$loaded) ? static::$loaded[$key] : null;

        if(is_null($set)) {
            return null;
        }

        return $set['active_item'];

    }//end getActive()


    /**
     * Push the given value and settings to the static loaded array at the given key.
     *
     * @param  string $key
     * @param  mixed  $value
     * @param  array  $settings
     * @return void
     */
    private static function pushActive($key, $value, $settings)
    {
        static::$loaded[$key] = array_merge($settings, array('active_item' => $value));

    }//end pushActive()


    /**
     * Prepare the given settings by using the defaults for the missing settings details.
     *
     * @param  array $settings
     * @return array
     */
    private static function prepareSettings($settings)
    {
        $result = static::$defaults;

        if (is_null($settings)) {
            return $result;
        }

        foreach ($result as $key => $value) {
            if (array_key_exists($key, $settings)) {
                $result[$key] = $settings[$key];
            }
        }

        return $result;

    }//end prepareSettings()


    /**
     * Extract the key and value from the given array.
     *
     * Extract the key and value from the given array
     * by getting first pair that's it's key not in
     * the default settings keys.
     *
     * @param  array $array
     * @return array|null
     */
    private static function extractKeyAndValue($array)
    {
        $defaultsKeys = array_keys(static::$defaults);
        $result       = null;

        foreach ($array as $key => $value) {
            if (in_array($key, $defaultsKeys, true)) {
                continue;
            }

            $result[] = $key;
            $result[] = $value;
            break;
        }

        return $result;

    }//end extractKeyAndValue()


}//end class
