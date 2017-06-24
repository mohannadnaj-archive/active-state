<?php

class ActiveStateTest extends PHPUnit_Framework_TestCase
{
    public function test_functions_exist()
    {
        $this->assertTrue(function_exists('set_active'));
        $this->assertTrue(function_exists('is_active'));
        $this->assertTrue(function_exists('_set_active_check_state'));
        $this->assertTrue(function_exists('_set_active_add'));
    }

    public function test_basic_use()
    {
        set_active(['navbar'=>'index']);

        $this->assertEquals(is_active('navbar', 'index'), 'active');
        $this->assertNull(is_active('navbar', 'about'));
    }

    public function test_return_custom_css_class()
    {
        set_active(['navbar'=>'index', 'class'=>'some-active-css-class']);

        $this->assertEquals(is_active('navbar', 'index'), 'some-active-css-class');
        $this->assertNull(is_active('navbar', 'about'));
    }

    public function test_return_boolean()
    {
        set_active(['navbar'=>'index', 'return'=>'boolean']);

        $this->assertTrue(is_active('navbar', 'index'));
        $this->assertFalse(is_active('navbar', 'about'));
    }

    public function test_global_mode()
    {
        set_active(['global_val', 'return'=>'class']);

        $this->assertEquals(is_active('global_val'), 'active');
        $this->assertEquals(is_active('wrong_global_val'), null);
    }

    public function test_multiple_keys()
    {
        set_active(['navbar'=>'admin', 'return'=>'boolean']);
        set_active(['sidebar'=>'dashboard']);
        set_active(['sidebar-submenu'=>'overview', 'class'=>'submenu-is-active']);

        $this->assertTrue(is_active('navbar', 'admin'));
        $this->assertFalse(is_active('navbar', 'contact'));

        $this->assertEquals(is_active('sidebar', 'dashboard'), 'active');
        $this->assertNull(is_active('sidebar', 'about'));

        $this->assertEquals(is_active('sidebar-submenu', 'overview'), 'submenu-is-active');
        $this->assertNull(is_active('sidebar-submenu', 'charts'));
    }

    public function test_override_key_and_return_type()
    {
        set_active(['navbar'=>'index', 'return'=>'class']);
        set_active(['navbar'=>'about', 'return'=>'boolean']);

        $this->assertFalse(is_active('navbar', 'index'));
        $this->assertTrue(is_active('navbar', 'about'));
    }

    public function test_setting_class_while_return_boolean()
    {
        set_active(['navbar'=>'index', 'return'=>'boolean', 'class'=>'some-active-css-class']);

        $this->assertTrue(is_active('navbar', 'index'));
        $this->assertFalse(is_active('navbar', 'about'));
    }

    public function test_key_not_exist()
    {
        $this->assertNull(is_active('key_is_not_set', 'mmm'));
    }

    public function test_get_active()
    {
        set_active(['navbar'=>'index']);

        $this->assertEquals(set_active('navbar'), 'index');
    }

    public function test_get_active_key_not_exist()
    {
        $this->assertNull(is_active('get_active_key_not_exist'));
    }
}
