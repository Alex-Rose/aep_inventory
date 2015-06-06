<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Inventory extends Controller_Base
    {
        public function before()
        {
            parent::before();

            $this->ensureLoggedIn();
        }

        public function action_index()
        {
            $this->inventory = ORM::factory('Inventory')->find_all();
            $this->content = View::factory('inventory');
        }
    }
