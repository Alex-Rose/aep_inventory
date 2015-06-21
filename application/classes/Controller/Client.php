<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Client extends Controller_Base
    {
        public function before()
        {
            parent::before();

            $this->ensureLoggedIn();
        }

        public function action_index()
        {
            $this->title = 'Liste des clients';
            $this->clients = ORM::factory('Client')->find_all();
            $this->content = View::factory('client');
        }

        // For nav menu
        public function action_list()
        {
            $this->title = 'Liste des clients';
            $this->clients = ORM::factory('Client')->find_all();
            $this->content = View::factory('client');
        }

        public function action_add()
        {
            $this->title = 'Ajout d\'un client';
            $this->client = ORM::factory('Client');
            $this->content = View::factory('client_edit');
        }

        public function action_edit()
        {
            $id = $this->request->param('id');

            $this->title = 'Modification d\'un client';
            $this->client = ORM::factory('Client', $id);
            $this->content = View::factory('client_edit');
        }
    }
