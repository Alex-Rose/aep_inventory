<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Price extends ORM
    {
        protected $_table_name  = 'price';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['product' => ['model' => 'Product', 'foreign_key' => 'productID']];

        public function __get($parameter)
        {
            if ($parameter == 'price')
            {
                return floatval(parent::__get($parameter));
            }
            else
            {
                return parent::__get($parameter);
            }
        }
    }