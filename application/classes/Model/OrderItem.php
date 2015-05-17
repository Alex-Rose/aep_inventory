<?php defined('SYSPATH') or die('No direct script access.');

    class Model_OrderItem extends ORM
    {
        protected $_table_name  = 'order_item';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['order' => ['model' => 'Order', 'foreign_key' => 'orderID'],
                                   'product' => ['model' => 'Product', 'foreign_key' => 'productID']];
    }