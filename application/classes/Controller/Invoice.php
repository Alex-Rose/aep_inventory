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
            $this->orders = ORM::factory('Order')->with('invoice')->where('orderID', 'IS NOT', null)->order_by('invoice.created', 'DESC')->find_all();
            $this->content = View::factory('invoice');
        }

        public function action_unpaid()
        {
            $this->title = 'Liste des factures impayées';
            $this->orders = ORM::factory('Order')->with('invoice')->where('paymentID', 'IS', null)->order_by('invoice.created', 'DESC')->find_all();
            $this->content = View::factory('invoice');
        }

        public function action_pay()
        {
            $id = $this->request->param('id');

            $this->title = 'Payer une facture';
            $this->invoice = ORM::factory('Invoice', $id);

            if ($this->invoice->payment->loaded())
            {
                $this->amount = $this->invoice->payment->amount;
                $this->method = $this->invoice->payment->method;
            }
            else
            {
                $this->amount = $this->invoice->total;
                $this->method = 'cash';
            }

            $this->content = View::factory('invoice_payment');
        }

        public function action_view()
        {
            $id = $this->request->param('id');

            $this->title = 'Détails de la facture';
            $this->invoice = ORM::factory('Invoice', $id);
            $this->content = View::factory('invoice_detail');
        }

    }
