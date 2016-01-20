<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Product extends Controller_Base
    {
        public function before()
        {
            parent::before();

            $this->ensureLoggedIn();
        }

        public function action_index()
        {
            $this->title = 'Liste des produits';
            $this->products = ORM::factory('Product')->where('discontinued', '=', false)->find_all();
            $this->content = View::factory('product_list');
        }

        public function action_edit()
        {
            $id = $this->request->param('id');

            $this->title = 'Modification de produit';
            $this->product = ORM::factory('Product', $id);
            $this->price = ORM::factory('Price')->where('productID', '=', $this->product->pk())->find();
            $this->content = View::factory('product_edit');
        }

        public function action_add()
        {
            $this->title = 'Création de produit';
            $this->product = ORM::factory('Product');
            $this->price = ORM::factory('Price');
            $this->content = View::factory('product_edit');
        }

        public function action_list()
        {
            $this->title = 'Liste des produits';
            $this->products = ORM::factory('Product')->where('discontinued', '=', false)->find_all();
            $this->content = View::factory('product_list');
        }
    }
