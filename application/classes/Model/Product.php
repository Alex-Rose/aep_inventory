<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Product extends ORM
    {
        protected $_table_name  = 'product';
        protected $_primary_key = 'ID';

        protected $_has_one 	= ['inventory' => ['model' => 'Inventory', 'foreign_key' => 'productID']];

        protected $_has_many 	= ['prices' => ['model' => 'Price', 'foreign_key' => 'productID']];

        public function __get($parameter)
        {
            if ($parameter == 'price')
            {
                return $this->prices->order_by('created', 'DESC')->limit(1)->find();
            }
            else if ($parameter == 'priceWithTaxes')
            {
                $gstRate = floatval(Model_Parameter::getValue('GST_RATE'));
                $qstRate = floatval(Model_Parameter::getValue('QST_RATE'));

                $price = $this->price;

                $total = $price->price;

                if ($price->taxes == 'GST' || $price->taxes == 'BOTH')
                {
                    $total += $price->price * $gstRate;
                }

                if ($price->taxes == 'QST' || $price->taxes == 'BOTH')
                {
                    $total += $price->price * $qstRate;
                }

                return $total;
            }
            else if ($parameter == 'priceWithTaxesAndRefund')
            {
                return $this->priceWithTaxes + $this->price->refund;
            }
            else
            {
                return parent::__get($parameter);
            }
        }
    }