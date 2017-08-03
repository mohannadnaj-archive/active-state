<?php
use Mohannadnaj\Active;

if (! function_exists('set_active')) {


    /**
     * Set the active item (value) at the given key associated with the given settings.
     *
     * @param  string|array $key
     * @param  null|mixed  $value
     * @param  null|array  $settings
     * @return void
     */
    function set_active($key, $value = null, $settings = null)
    {
        return Active::set($key, $value, $settings);

    }//end set_active()


}//end if

if (! function_exists('get_active')) {


    /**
     * Get the active item.
     *
     * @param  null|string $key
     * @param  null|string  $default
     * @return mixed|null
     */
    function get_active($key = null, $default = null)
    {
        return Active::get($key, $default);

    }//end get_active()


}//end if

if (! function_exists('is_active')) {


    /**
     * Check if the given value is the active item for at the given key.
     *
     * @param  string  $key
     * @param  null|string $value
     * @return boolean|null|string
     */
    function is_active($key, $value = null)
    {
        return Active::is($key, $value);

    }//end is_active()


}//end if
