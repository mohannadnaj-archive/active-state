<?php
const ACTIVESTATE_GLOBAL_KEY = '_ACTIVESTATE_GLOBAL_KEY';

if (! function_exists('set_active')) {


    function set_active(...$params)
    {
        static $loaded = [];
        // default values
        static $defaults = [
                            'class'  => 'active',
                            'return' => 'class',
                           ];

        // get the active element
        if (count($params) == 1 && is_string($params[0])) {
            if (! array_key_exists($params[0], $loaded)) {
                return _set_active_is_boolean($defaults['return']) ? false : null;
            } else {
                return $loaded[$params[0]]['active'];
            }

            // setting the active element, should be one array parameter, e.g: set_active(['tabs'=>'about'])
        } else if (count($params) == 1 && is_array($params[0])) {
            return _set_active_add($params, $loaded, $defaults);
            // if we are checking the active state, e.g: set_active('tabs','about')
        } else if (count($params) == 2) {
            return _set_active_check_state($params, $loaded, $defaults);
        }

    }//end set_active()


}//end if

if (! function_exists('is_active')) {


    function is_active(...$params)
    {
        if (count($params) == 1) {
            return set_active(ACTIVESTATE_GLOBAL_KEY, $params[0]);
        } else {
            return set_active($params[0], $params[1]);
        }

    }//end is_active()


}

if (! function_exists('_set_active_check_state')) {


    function _set_active_check_state(& $params, & $loaded, & $defaults)
    {
        // if we are checking the active state for an index isn't set yet, return false or ''
        if (! array_key_exists($params[0], $loaded)) {
            return _set_active_is_boolean($defaults['return']) ? false : null;
        }

        // checking if the first param active element match the second param
        if ($loaded[$params[0]]['active'] == $params[1]) {
            // return true if it's return type set to boolean
            if (_set_active_is_boolean($loaded[$params[0]]['return'])) {
                return true;
            } //end if
            else if ($loaded[$params[0]]['return'] == 'class') {
                return $loaded[$params[0]]['class'];
            }
        } else {
            // the first param active element does not match the second param
            return _set_active_is_boolean($loaded[$params[0]]['return']) ? false : null;
        }

    }//end _set_active_check_state()


}//end if

if (! function_exists('_set_active_add')) {


    function _set_active_add(& $params, & $loaded, & $defaults)
    {
        $settings         = $params[0];
        $indexKey         = null;
        $preparedSettings = [];
        foreach ($settings as $key => $value) {
            // if the settings isn't the defaults, e.g: set_active(['tabs'=>'about','return'=>'boolean']) or set_active(['tabs'=>'about','class'=>'is-active'])
            if ($key === 'class' || $key === 'return') {
                $preparedSettings[$key] = $value;
            } else if (empty($indexKey)) {
                if (empty($key) && count($settings) <= 3) {
                    $key = ACTIVESTATE_GLOBAL_KEY;
                }

                $preparedSettings['active'] = $value;
                $indexKey = $key;
            }
        }

        // set the default return type if it's not set
        if (empty($preparedSettings['return'])) {
            $preparedSettings['return'] = $defaults['return'];
        }

        // set the default class to return if it's not set
        if (empty($preparedSettings['class'])) {
            $preparedSettings['class'] = $defaults['class'];
        }

        if (! empty($indexKey)) {
            $loaded[$indexKey] = $preparedSettings;
        }

        return null;

    }//end _set_active_add()


}//end if

if (! function_exists('_set_active_is_boolean')) {


    function _set_active_is_boolean($value)
    {
        $booleanValues = [
                          'bool',
                          'boolean',
                         ];
        return in_array($value, $booleanValues);

    }//end _set_active_is_boolean()


}
