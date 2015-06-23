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
            $this->orders = ORM::factory('Order')->find_all();
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

            $this->title = 'Modification d\'une commande';
            $this->order = ORM::factory('Order', $id);
            $this->content = View::factory('order_edit');
        }
    }