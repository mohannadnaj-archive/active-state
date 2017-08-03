# active-state
PHP Helper Package for marking active state in application's runtime.

Common use cases for this package includes: Marking the active menu-item, Marking the active item in your Navbar, Sidebar, or Tabs.

[![Total Downloads][downloads-image]][package-link]

----------
## Installation:

### Composer:
The preferred installation method, using [composer](https://getcomposer.org/download/) the package is available at [Packagist](https://packagist.org/packages/mohannadnaj/active-state) so it can be required:

    composer require mohannadnaj/active-state


----------
## Usage:

### Basic:
        set_active('navbar', 'index');
        set_active('sidebar', 'info');
    
        is_active('navbar','index'); // return "active"
        is_active('navbar','about'); // return null
        
        is_active('sidebar','info'); // return "active"
        is_active('sidebar','warning'); // return null
        
        get_active('navbar'); // return 'index';
        get_active('sidebar'); // return 'info';
        
### Return Custom string other than the default 'active' string:
        set_active('navbar2', 'index',['true'=>'some-active-css-class']);
    
        is_active('navbar2','index');    // return 'some-active-css-class'
        is_active('navbar2','about');    // return null
    
### Return Custom string on success/failure:
        set_active('navbar3', 'register',['true'=>'is-active-css-class', 'false'=> 'not-active']);
    
        is_active('navbar3', 'register'); // return 'is-active-css-class'
        is_active('navbar3', 'login'); // return 'not-active'
### Without Key:
        set_active('developer-mode');
    
        is_active('developer-mode');  // return 'active'
        is_active('not-developer-mode');  // return null
        
        get_active();  // return 'developer-mode'
    
### Return Boolean:
        set_active('bottom-bar', 'index',['return'=>'boolean']); // 'boolean' or 'bool'
    
        is_active('bottom-bar','index');    // return true;
        is_active('bottom-bar','about');    // return false;
    

### Get The Active Item:
        set_active('tabs', 'tab2');
    
        get_active('tabs'); // return 'tab2';


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

The package will load the methods `set_active`, `get_active` and `is_active`, `set_active` will set a given settings to a static variable inside the `Mohannadnaj\Active` class, this settings answer the questions: what is the active item? what should it return if the check is passed? or should it return boolean? and what is the key you want to attach all this settings to?

The above example can be translated to:       

    set_active('navbar', 'about');
    
    <li class="<?= is_active('navbar', 'home'); ?>"><a href="#home">Home</a></li>
    <li class="<?= is_active('navbar', 'about'); ?>"><a href="#about">About</a></li>
    <li class="<?= is_active('navbar', 'contact'); ?>"><a href="#contact">Contact</a></li>

the `set_active` method will consider the first argument `set_active('navbar' , ...)` as a setter for the `active` element we want to catch later, that is `'about'`.

----------

## Requirements:
- PHP >=5.3

----------

## Development:

- Check out the [tests/ActiveStateTest.php](tests/ActiveStateTest.php) Test Case to see different examples of using the helper methods.

- Consider keeping it compatible with older PHP versions (>=5.3), personally, I used [PHPCompatibility](https://github.com/wimg/PHPCompatibility) to do the checks for me.

- TODO: Better documentation. Better consistant syntax (`accept and return types`) for using the methods.
 
Thanks for considering contributing to this project.


----------

[package-link]: https://packagist.org/packages/mohannadnaj/active-state
[downloads-image]: https://poser.pugx.org/mohannadnaj/active-state/downloads
