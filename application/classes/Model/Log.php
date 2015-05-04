<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Log extends ORM
    {
        protected $_table_name = 'log';
        protected $_primary_key = 'ID';

        protected static $levels = ['DEBUG' => 0, 'TRACE' => 1, 'INFO' => 2, 'WARNING' => 3, 'ERROR' => 4];

        public static function Log($msg, $level)
        {
//            $threshold = Model_Parameter::getValue('LOG_LEVEL');
            $threshold = 0;
            $threshold = $threshold != null ? $threshold : 0;
            if (self::$levels[$level] >= $threshold)
            {
                $log = ORM::factory('log');
                $log->msg = $msg;
                $log->level = $level;
                $log->save();

                if ($level == 'ERROR')
                {
                }
            }
        }
    }
