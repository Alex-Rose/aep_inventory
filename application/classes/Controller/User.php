<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_User extends Controller_Base
    {
        public function before()
        {
            parent::before();

            $this->ensureLoggedIn();
        }

        public function action_index()
        {
            $this->title = 'Liste des utilisateurs';
            $this->users = ORM::factory('User')->find_all();

            $this->content = View::factory('user_list');
        }

        public function action_list()
        {
            $this->title = 'Liste des utilisateurs';
            $this->users = ORM::factory('User')->find_all();

            $this->content = View::factory('user_list');
        }

        public function action_delete()
        {
            $id = $this->request->param('id');

            $this->title = 'Supprimer un utilisateur';
            $this->user = ORM::factory('User', $id);

            $this->content = View::factory('user_delete');
        }

        public function action_add()
        {
            $this->title = 'Créer un utilisateur';

            $this->content = View::factory('user_add');
        }

        public function action_edit()
        {
            $this->title = 'Modifier mon profile';

            $this->content = View::factory('user_edit');
        }
    }
