<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Payment extends ORM
    {
        protected $_table_name  = 'payment';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['invoice' => ['model' => 'Invoice', 'foreign_key' => 'invoiceID'],
                                    'user' => ['model' => 'User', 'foreign_key' => 'userID']];

    }