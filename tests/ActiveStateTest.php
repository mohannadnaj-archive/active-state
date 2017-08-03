<?php

class ActiveStateTest extends PHPUnit_Framework_TestCase
{

    public function test_basic_use()
    {
        // array
        set_active(['navbar1'=>'index']);
        $this->assertEquals(is_active('navbar1', 'index'), "active");
        $this->assertNull(is_active('navbar1', 'about'));
        
        // key, value
        set_active('navbar2','index2');
        $this->assertEquals(is_active('navbar2', 'index2'), "active");
        $this->assertNull(is_active('navbar2', 'about'));
    }

    public function test_set_active_syntax()
    {
        // array
        set_active(['list-group'=>'index']);
        $this->assertEquals(is_active('list-group', 'index'), "active");
        $this->assertEquals(get_active('list-group'), "index");

        // value (global key)        
        set_active('winter_is_trumping');
        $this->assertEquals(is_active('winter_is_trumping'), "active");
        $this->assertEquals(get_active(), "winter_is_trumping");

        // key, value
        set_active('list-group2','index2');
        $this->assertEquals(is_active('list-group2', 'index2'), "active");
        $this->assertEquals(get_active('list-group2'), "index2");

        // key, value, settings
        set_active('list-group3','favourite-item', ['true'=>'wine','false'=>'not-active']);
        $this->assertEquals(is_active('list-group3', 'favourite-item'), "wine");
        $this->assertEquals(is_active('list-group3', 'not-favourite-item'), "not-active");
        $this->assertEquals(get_active('list-group3'), "favourite-item");

    }

    public function test_return_custom_css_class()
    {
        // array
        set_active(['navbar3'=>'index','true'=>'some-active-css-class']);

        $this->assertEquals(is_active('navbar3', 'index'), "some-active-css-class");
        $this->assertNull(is_active('navbar3', 'about'));

        // key, value, settings
        set_active('navbar4', 'index',['true'=>'some-active-css-class']);

        $this->assertEquals(is_active('navbar4', 'index'), "some-active-css-class");
        $this->assertNull(is_active('navbar4', 'about'));
    }

    public function test_return_boolean()
    {
        // array
        set_active(['navbar5'=>'index','return'=>'boolean']);

        $this->assertTrue(is_active('navbar5', 'index'));
        $this->assertFalse(is_active('navbar5', 'about'));

        // key, value, settings
        set_active('navbar6', 'index',['return'=>'boolean']);
        $this->assertTrue(is_active('navbar6', 'index'));
        $this->assertFalse(is_active('navbar6', 'about'));
    }

    public function test_global_mode()
    {
        // array
        set_active(['global_val2']);

        $this->assertEquals(is_active('global_val2'), 'active');
        $this->assertNull(is_active('wrong_global_val'));

        // key, value, settings
        set_active('global_val2',['return'=>'true']);

        $this->assertEquals(is_active('global_val2'), 'active');
        $this->assertNull(is_active('wrong_global_val'));
    }

    public function test_multiple_keys()
    {
        set_active(['top-fixed-bar'=>'admin','return'=>'boolean']);
        set_active(['sidebar'=>'dashboard']);
        set_active(['sidebar-submenu'=>'overview','true'=>'submenu-is-active']);

        $this->assertTrue(is_active('top-fixed-bar', 'admin'));
        $this->assertFalse(is_active('top-fixed-bar', 'contact'));

        $this->assertEquals(is_active('sidebar', 'dashboard'), 'active');
        $this->assertNull(is_active('sidebar', 'about'));

        $this->assertEquals(is_active('sidebar-submenu', 'overview'), 'submenu-is-active');
        $this->assertNull(is_active('sidebar-submenu', 'charts'));
    }

    public function test_override_key_and_return_type()
    {
        set_active(['navbar7'=>'index']);
        set_active(['navbar7'=>'about','return'=>'boolean']);

        $this->assertFalse(is_active('navbar7', 'index'));
        $this->assertTrue(is_active('navbar7', 'about'));
    }

    public function test_setting_class_while_return_boolean()
    {
        set_active(['navbar8'=>'index','return'=>'boolean','true'=>'some-active-css-class']);

        $this->assertTrue(is_active('navbar8', 'index'));
        $this->assertFalse(is_active('navbar8', 'about'));
    }

    public function test_key_not_exist()
    {
        $this->assertNull(is_active('key_is_not_exist', 'ufo'));
    }

    public function test_get_active()
    {
        set_active(['navbar9'=>'index']);
        $this->assertEquals(get_active('navbar9'), "index");

        set_active(['navbar10'=>'index']);
        $this->assertEquals(get_active('navbar11','default-value'), "default-value");
    }

    public function test_get_active_key_not_exist()
    {
        $this->assertNull(get_active('get_active_key_not_exist'));
    }
}
