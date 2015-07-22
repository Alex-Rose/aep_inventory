<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_AdminInvoice extends Controller_Async
    {

        public function before()
        {
            parent::before();
            $this->ensureLoggedIn();
        }

        public function action_pay()
        {
            $id = $this->request->param('id');
            $amount = $this->request->post('amount');
            $method = $this->request->post('method');

            $invoice = ORM::factory('Invoice', $id);

            if ($invoice->loaded())
            {
                $payment = ORM::factory('Payment')->where('invoiceID', '=', $invoice->pk())->find();

                $payment->invoiceID = $invoice->pk();
                $payment->method = $method;
                $payment->amount = $amount;
                $payment->userID = Model_User::current()->pk();
                $payment->save();

                $invoice->paymentID = $payment->pk();
                $invoice->save();

                $this->data['success'] = true;
                $this->data['feedback'] = Helper_Alert::success('Paiement enregistré avec succès');
            }
            else
            {
                $this->data['feedback'] = Helper_Alert::danger('Facture introuvable');
            }

        }

        public function action_unpay()
        {
            $id = $this->request->param('id');
            $invoice = ORM::factory('Invoice', $id);

            if ($invoice->loaded())
            {
                if ($invoice->payment->loaded())
                {
                    $invoice->payment->delete();
                }

                $invoice->paymentID = null;
                $invoice->save();

                $this->data['success'] = true;
                $this->data['feedback'] = Helper_Alert::danger('Paiement supprimé');
            }
            else
            {
                $this->data['feedback'] = Helper_Alert::danger('Facture introuvable');
            }

        }
    }
