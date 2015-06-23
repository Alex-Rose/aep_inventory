<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Order extends ORM
    {
        protected $_table_name  = 'order';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['client' => ['model' => 'Client', 'foreign_key' => 'clientID']];

        protected $_has_many 	= ['items' => ['model' => 'OrderItem', 'foreign_key' => 'orderID']];
    }