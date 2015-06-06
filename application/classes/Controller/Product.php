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
            $this->content = View::factory('home');
        }

        public function action_edit()
        {
            $this->title = 'Modification de produit';
            $this->product = ORM::factory('Product');
            $this->price = ORM::factory('Price')->where('productID', '=', $this->product->pk())->find();
            $this->content = View::factory('product_edit');
        }
    }
