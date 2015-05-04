<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Product extends ORM
    {
        protected $_table_name  = 'product';
        protected $_primary_key = 'ID';

        protected $_has_one 	= ['inventory' => ['model' => 'Inventory', 'foreign_key' => 'productID']];
    }