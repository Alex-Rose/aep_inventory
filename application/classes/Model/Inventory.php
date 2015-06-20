<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Inventory extends ORM
    {
        protected $_table_name  = 'inventory';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['product' => ['model' => 'Product', 'foreign_key' => 'productID']];
    }