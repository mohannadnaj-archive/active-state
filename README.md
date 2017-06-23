# active-state
PHP Helper Package for marking active state in application's runtime.

Common use cases for this package includes: Marking the active menu-item, Marking the active item in your Navbar, Sidebar, or Tabs.

[![Total Downloads][downloads-image]][package-link]

----------
## Installation:

### Composer:
The prefrred installation method, using [composer](https://getcomposer.org/download/) the package is available at [Packagist](https://packagist.org/packages/mohannad/active-state) so it can be required:

    composer require mohannad/active-state

and that's it!

### Manual Installation:
- Download the [Zip Archive](https://github.com/MohannadNaj/active-state/archive/master.zip)
- Unzip [src/helper.php](src/helper.php) into your project.
- Include `helper.php` :

        <?php
        require('path/to/helper.php');
        // ...
        ?>


----------
## Usage:

### Basic:
        set_active(['navbar'=>'index']);
        set_active(['panel'=>'info']);
    
        is_active('navbar','index'); // return "active"
        is_active('navbar','about'); // return null
        
        is_active('panel','info'); // return "active"
        is_active('panel','warning'); // return null
        
### Return Custom CSS Class other than the default 'active' class:
        set_active(['sidebar'=>'index','class'=>'some-active-css-class']);
    
        is_active('sidebar','index');    // return 'some-active-css-class'
        is_active('sidebar','about');    // return null
    
### Without Key:
        set_active(['global_val']);
    
        is_active('global_val');  // return 'active'
        is_active('wrong_global_val');  // return null
    
### Return Boolean:
        set_active(['bottom-bar'=>'index','return'=>'boolean']);
    
        is_active('bottom-bar','index');    // return true;
        is_active('bottom-bar','about');    // return false;
    

### Get The Active Item:
        set_active(['taps'=>'tab2']);
    
        set_active('taps'); // return 'tab2';


----------
## What's inside

### Problem:
Marking an active item is a common essential part in any UI, providing a visual indication of the state of an item. This is commonly used in PHP like:

    $current_page = 'contact'; 
    
    <li class="<?= $current_page == 'home' ? 'active' : '' ?>"><a href="#home">Home</a></li>
    <li class="<?= $current_page == 'about' ? 'active' : '' ?>"><a href="#about">About</a></li>
    <li class="<?= $current_page == 'contact' ? 'active' : '' ?>"><a href="#contact">Contact</a></li>

Repeating this code in different parts of your application where you need to mark the active state, will make the code harder to read, harder to maintain.

Some solutions out there have the downsides: 1- Framework-Specific Package. 2- Completely based on the URL Route. 3- Only one item can be marked as active.

### Solution:

The package will load the methods `set_active` and `is_active`, `set_active` is the main method that's has a `static` variable which will load and preserve the settings (what is the active item? what class should it return if the check is passed? or should it return boolean?). The above example can be translated to:       

    set_active(['navbar'=>'about']); // the argument is an array

    <li class="<?= is_active('navbar', 'home'); ?>"><a href="#home">Home</a></li>
    <li class="<?= is_active('navbar', 'about'); ?>"><a href="#about">About</a></li>
    <li class="<?= is_active('navbar', 'contact'); ?>"><a href="#contact">Contact</a></li>

the `set_active` method will consider the array argument `set_active(['some_key' => 'some_value'])` as a setter for the `active` element (`'some_value'`) with the index (`'some_key'`) to check it later.

the `set_active` method will consider the two arguments `set_active('some_key', 'some_value')` as: check if what I set before for the key `some_key` is `some_value`, and give me the `active` class if that's check passed.

since using the same `set_active`for both setting and checking the active item may cause confusion,  `is_active('key','value')` is an alias for `set_active('key','value')`.

----------

## Requirements:
- PHP >=5.6.4

----------

## Development:

- Check out the [tests/ActiveStateTest.php](tests/ActiveStateTest.php) Test Case to see different examples of using the helper methods.

- The code in [src/helper.php](src/helper.php) is written quickly and dirty. I admit it. I'm all for rewriting it. but I couldn't wait untill I finish before releasing.

- Exploring the code in [src/helper.php](src/helper.php), at first glance you may see some issues to be fixed:
    - Why it's not OOP?
    - why there is no static class to hold the values?
    - why `...$params` used for retrieving function arguments so it's not compatible with older PHP versions?
    - ..etc.

Thanks for considering contributing to this project.


----------

[package-link]: https://packagist.org/packages/mohannad/active-state
[downloads-image]: https://poser.pugx.org/mohannad/active-state/downloads
