<?php

    class Helper_Number
    {
        protected static $instance = null;

        protected function __construct()
        {
            setlocale(LC_MONETARY, 'fr_CA');
        }

        protected static function getInstance()
        {
            if (self::$instance === null)
            {
                self::$instance = new Helper_Number();
            }

            return self::$instance;
        }

        protected function formatInternal($number)
        {
            return money_format('%!-i', $number);
        }

        public static function format($number)
        {
            $instance = self::getInstance();
            return $instance->formatInternal($number);
        }
    }