<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Invoice extends ORM
    {
        protected $_table_name  = 'invoice';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['client' => ['model' => 'Client', 'foreign_key' => 'clientID'],
                                   'order' => ['model' => 'Order', 'foreign_key' => 'orderID'],
                                   'payment' => ['model' => 'Payment', 'foreign_key' => 'paymentID'],
                                   'user' => ['model' => 'User', 'foreign_key' => 'userID']];

        protected $_has_many 	= ['items' => ['model' => 'InvoiceItem', 'foreign_key' => 'invoiceID']];

        public function delete()
        {
            $items = $this->items->find_all();

            foreach ($items as $item)
            {
                $item->delete();
            }

            parent::delete();
        }

        // Charged to the client
        public function totalDeposit()
        {
            $total = 0.0;
            foreach ($this->items->find_all() as $item)
            {
                if ($item->refund > 0)
                {
                    $total += $item->refund;
                }
            }

            return $total;
        }

        // Refunded when returned
        public function totalRefund()
        {
            $total = 0.0;
            foreach ($this->items->find_all() as $item)
            {
                if ($item->refund < 0)
                {
                    $total += $item->refund;
                }
            }

            return $total;
        }
    }