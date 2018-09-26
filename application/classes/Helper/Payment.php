<?php

    class Helper_Payment
    {
        public static $friendlyMethodNames = [ 
            'cash' => 'Argent comptant', 
            'impute' => 'Imputer', 
            'transfer' => 'Transfer de fonds',
            'unpaid' => 'À payer'];

        public static function methodName($method)
        {
            if (array_key_exists($method, self::$friendlyMethodNames))
            {
                return self::$friendlyMethodNames[$method];
            }

            return '';
        }
    }
