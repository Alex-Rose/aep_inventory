<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_AdminWeb extends Controller_Async
    {

        public function before()
        {
            parent::before();
            $this->ensureLoggedIn();
        }

        public function action_createUser()
        {
            $email = $this->request->post('email');
            $password = $this->request->post('password');

            if ($email != null && $password != null)
            {
                if (Model_User::register($email, $password))
                {
                    $user = ORM::factory('User')->where('email', '=', $email)->find();
                    $user->sendConfirmationLink();

                    $this->data['feedback'] = Helper_Alert::success('Compte créé avec succès');
                    $this->data['success'] = true;
                }
                else
                {
                    $this->data['feedback'] = Helper_Alert::danger('Le courriel est déjà utilisé');
                }
            }
            else
            {
                $this->data['feedback'] = Helper_Alert::danger('Requête invalide');
            }
        }

        public function action_deleteUser()
        {
            $id = $this->request->param('id');
            $user = ORM::factory('User', $id);
            $this->data['id'] = $id;

            if ($user->loaded())
            {
                Model_Log::Log('User deleted id:'.$user->pk().' email:'.$user->email.' by uid:'.Model_User::current()->pk(), 'TRACE');
                $user->delete();
                $this->data['success'] = true;
                $this->data['feedback'] = Helper_Alert::success('L\'utilisateur à été supprimé');
            }
            else
            {
                $this->data['feedback'] = Helper_Alert::danger('L\'utilisateur n\'existe pas');
                $this->data['success'] = false;
            }
        }

        public function action_adminCreate()
        {
            $this->action_createUser();

            if ($this->data['success'] == true)
            {
                $this->data['feedback'] = Helper_Alert::success('Compte créé avec succès. L\'utilisateur recevra un courriel pour confirmer son compte.');
            }
        }

        public function action_changePassword()
        {
            $user = Model_User::current();
            $password = $this->request->post('password');

            if ($user->loaded() && $password != null)
            {
                $user->setPassword($password);
                $this->data['success'] = true;
                $this->data['feedback'] = Helper_Alert::success('Mot de passe changé avec succès');
            }
            else
            {
                $this->data['feedback'] = Helper_Alert::danger('Le mot de passe ne peut être vide');
            }

        }
    }
