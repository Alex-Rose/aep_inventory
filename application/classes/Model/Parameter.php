<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Parameter extends ORM
    {
        protected $_table_name = 'parameter';
        protected $_primary_key = 'ID';


        public static function getParameter($key)
        {
            return ORM::factory('parameter')->where('key', '=', $key)->find();
        }

        // Returns the value for given key or null if not found
        public static function getValue($key)
        {
            $param = ORM::factory('parameter')->where('key', '=', $key)->find();

            return $param->loaded() ? $param->value : null;
        }
    }