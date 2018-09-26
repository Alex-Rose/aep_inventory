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
            $amount = Helper_Number::getFromString($this->request->post('amount'));
            $method = $this->request->post('method');

            $invoice = ORM::factory('Invoice', $id);

            if ($invoice->loaded())
            {
                $payment = ORM::factory('Payment')->where('invoiceID', '=', $invoice->pk())->find();

                if ($method == 'unpaid')
                {
                    if ($invoice->payment->loaded())
                    {
                        $invoice->payment->delete();
                    }

                    $invoice->paymentID = null;
                    $invoice->save();

                    $this->data['success'] = true;
                    $this->data['feedback'] = Helper_Alert::success('Détails enregistrés');
                }
                else
                {
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

        public function action_delete()
        {
            $id = $this->request->param('id');
            $invoice = ORM::factory('Invoice', $id);

            if ($invoice->loaded())
            {
                if (!$invoice->payment->loaded())
                {
                    $invoice->delete();
                    $this->data['success'] = true;
                    $this->data['feedback'] = Helper_Alert::success('Facture supprimée');

                    Model_Log::Log('AdminOrder - User '. $this->user->pk() .' deleted invoice '. $id, 'TRACE');
                }
                else
                {
                    $this->data['success'] = false;
                    $deleteLink = HTML::anchor('AdminInvoice/unpay/'.$id, 'supprimer le paiement', ['class' => 'delete-payment']);
                    $this->data['feedback'] = Helper_Alert::danger('La facture n\'a pas été supprimée. Veuillez d\'abord '.$deleteLink);
                }
            }
            else
            {
                $this->data['feedback'] = Helper_Alert::danger('Facture introuvable');
            }
        }

        public function action_list(){
            $this->writeJson = true;

            $page = $this->request->post('draw');
            $start = $this->request->post('start');
            $nb = $this->request->post('length');
            $search = $_POST['search']['value'];
            $sort = $_POST['order'][0]['column'];
            $sortDir = $_POST['order'][0]['dir'];

            $this->data = Helper_Datatables::invoices($page, $start, $nb, $search, $sort, $sortDir);
        }
    }
