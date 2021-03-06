<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Order extends Controller_Base
    {
        public function before()
        {
            parent::before();

            $this->ensureLoggedIn();
        }

        public function action_index()
        {
            $this->title = 'Liste des commandes';
            $this->content = View::factory('order');
        }

        public function action_create()
        {
            $this->title = 'Ajout d\'une commande';
            $this->order = ORM::factory('Order');
            $this->content = View::factory('order_edit');
        }

        public function action_edit()
        {
            $id = $this->request->param('id');

            $this->order = ORM::factory('Order', $id);

            if (!$this->order->isPaid())
            {
                $this->title = 'Modification de la commande';
                $this->content = View::factory('order_edit');
                $this->validateOrder();
            }
            else
            {
                $this->title = 'Détails de la commande';
                $this->content = View::factory('order_detail');
                $this->comment = Helper_Alert::warning('La commande à été payée et ne peut être modifiée. <br/>Pour modifier la commande, veuillez d\'abord annuler le paiement.');
            }
        }

        public function action_view()
        {
            $id = $this->request->param('id');

            $this->title = 'Détails de la commande';
            $this->order = ORM::factory('Order', $id);
            $this->content = View::factory('order_detail');
        }

        public function action_print()
        {
            $id = $this->request->param('id');
            $this->order = ORM::factory('Order', $id);
            $this->pageTitle = 'Bière AEP - Commande #'.$this->order->pk();
            $this->title = 'AEP - Commande de bière';
            $this->addCss = ['assets/css/print.css'];
            $this->content = View::factory('order_print');
        }

        protected function validateOrder()
        {
            $discontinued = [];
            foreach ($this->order->items->find_all() as $item)
            {
                if ($item->product->discontinued)
                {
                    $discontinued[$item->product->code] = $item->product->name;
                    $item->delete();
                }
            }

            if (!empty($discontinued))
            {
                $comment = 'La commande contenait des produits discontinués. Ces derniers ont été supprimés. <br/><ul>';

                foreach ($discontinued as $code => $name)
                {
                    $comment .= '<li>['.$code.'] '.$name.'</li>';
                }

                $comment .= '</ul>';

                $this->comment = Helper_Alert::warning($comment);

                if ($this->order->invoice->loaded() && $this->order->invoice->paymentID == null) // Should check this before editing the order
                {
                    $this->order->invoice->delete();
                    $this->order->createInvoice();
                }
            }
        }
    }
