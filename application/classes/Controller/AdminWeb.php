<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_AdminWeb extends Controller_Async
    {

        public function before()
        {
            parent::before();
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
    }