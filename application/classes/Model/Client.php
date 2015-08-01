<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Client extends ORM
    {
        protected $_table_name  = 'client';
        protected $_primary_key = 'ID';

//        protected $_has_many 	= ['payments' => ['model' => 'Payment', 'foreign_key' => 'clientID']];
        protected $_has_many 	= ['payments' => ['model' => 'Payment', 'through' => 'invoice', 'foreign_key' => 'clientID', 'far_key' => 'paymentID'],
                                    'orders' => ['model' => 'Order', 'foreign_key' => 'clientID'],
                                    'invoices' => ['model' => 'Invoice', 'foreign_key' => 'clientID']];

        public function __get($parameter)
        {
            if ($parameter == 'balance')
            {
                return $this->balance();
            }
            else
            {
                return parent::__get($parameter);
            }
        }

        public function balance()
        {
            $balance = 0.0;

            foreach ($this->invoices->find_all() as $invoice)
            {
                $balance += $invoice->total;
            }

            foreach ($this->payments->find_all() as $payment)
            {
                $balance -= $payment->amount;
            }

            return $balance;
        }
    }
