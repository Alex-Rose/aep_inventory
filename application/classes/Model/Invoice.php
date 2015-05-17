<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Invoice extends ORM
    {
        protected $_table_name  = 'invoice';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['client' => ['model' => 'Client', 'foreign_key' => 'clientID'],
                                   'order' => ['model' => 'Order', 'foreign_key' => 'orderID']];

        protected $_has_many 	= ['items' => ['model' => 'InvoiceItem', 'foreign_key' => 'invoiceID']];
    }