<?php defined('SYSPATH') or die('No direct script access.');

    class Model_InvoiceItem extends ORM
    {
        protected $_table_name  = 'invoice_item';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['invoice' => ['model' => 'Invoice', 'foreign_key' => 'invoiceID'],
                                   'product' => ['model' => 'Product', 'foreign_key' => 'productID']];
    }