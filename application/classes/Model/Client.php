<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Client extends ORM
    {
        protected $_table_name  = 'client';
        protected $_primary_key = 'ID';

//        protected $_has_many 	= ['payments' => ['model' => 'Payment', 'foreign_key' => 'clientID']];
        protected $_has_many 	= ['payments' => ['model' => 'Payment', 'through' => 'invoice', 'foreign_key' => 'clientID', 'far_key' => 'paymentID']];
    }