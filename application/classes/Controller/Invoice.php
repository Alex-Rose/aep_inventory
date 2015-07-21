<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Invoice extends Controller_Base
    {
        public function before()
        {
            parent::before();

            $this->ensureLoggedIn();
        }

        public function action_index()
        {
            $this->title = 'Liste des factures';
            $this->orders = ORM::factory('Order')->with('invoice')->where('orderID', 'IS NOT', null)->find_all();
            $this->content = View::factory('invoice');
        }

        public function action_unpaid()
        {
            $this->title = 'Liste des factures impayées';
            $this->orders = ORM::factory('Order')->with('invoice')->where('paymentID', 'IS NOT', null)->find_all();
            $this->content = View::factory('invoice');
        }

        public function action_pay()
        {
            $id = $this->request->param('id');

            $this->title = 'Payer une facture';
            $this->invoice = ORM::factory('Invoice', $id);
            $this->content = View::factory('invoice_payment');
        }

    }
