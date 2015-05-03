<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Auth extends Controller_Base
    {
        protected $feedback = [null => ''];

        public function __construct(Request $request, Response $response)
        {

            $this->feedback[1] = Helper_Alert::danger('Courriel ou mot de passe invalide. Mot de passe '.HTML::anchor('forgot', 'oublié').'?');
            $this->feedback[2] = Helper_Alert::success('Votre mot de passe a été modifié. Vous pouvez maintenant vous connecter');
            $this->feedback[3] = Helper_Alert::danger('Votre mot de passe n\'a pu être modifié. Contactez l\'administrateur');
            parent::__construct($request, $response);
        }

        public function before()
        {
            $this->render = false;
            parent::before();
        }

        public function action_login()
        {
            if ($this->user->isLogged())
            {
                HTTP::redirect('home');
            }

            $base = View::factory('layouts/base');

            $view = View::factory('login');

            $email = Session::instance()->get('mail_attempt');
            Session::instance()->set('mail_attempt', null);
            $view->bind('email', $email);

            $feedback = $this->feedback[$this->request->param('id')];
            $view->bind('feedback', $feedback);


            $base->bind('fullScreen', $view);

            echo $base->render();
        }

        public function action_logout()
        {
            Model_User::setup_user(null);

            HTTP::redirect('home');
        }

        public function action_process()
        {
            $email = $this->request->post('email');
            $password = $this->request->post('password');

            if (Model_User::login($email, $password))
            {
                $redirect = Session::instance()->get('redirect');
                if ($redirect != null)
                {
                    Session::instance()->set('redirect', null);
                }
                else
                {
                    $redirect = 'home';
                }

                HTTP::redirect($redirect);
            }
            else
            {
                Session::instance()->set('mail_attempt', $email);
                HTTP::redirect('login/1');
            }
        }

        public function action_forgot()
        {
            if ($this->user->isLogged())
            {
                HTTP::redirect('home');
            }

            $base = View::factory('layouts/base');

            $view = View::factory('forgot');

            $email = Session::instance()->get('mail_attempt');
            Session::instance()->set('mail_attempt', null);
            $view->bind('email', $email);

            $base->bind('fullScreen', $view);

            echo $base->render();
        }

        public function action_validate()
        {

        }

        public function action_reset()
        {
            $id = $this->request->param('id');

            if ($this->user->isLogged())
            {
                HTTP::redirect('home');
            }

            $base = View::factory('layouts/base');

            $view = View::factory('reset');

            if ($id != null)
            {
                $user = ORM::factory('User')->where('activation', '=', $id)->find();
                if ($user->loaded())
                {
                    $email = $user->email;
                    $view->set('activation', $id);
                    $view->set('email', $email);
                }
                else
                {
                    $view->set('activation', null);
                    $view->set('email', null);
                    $feedback = Helper_Alert::danger('Code de réinitialisation invalide');
                }
            }
            else
            {
                $feedback = Helper_Alert::danger('Code de réinitialisation invalide');
            }

            $view->bind('feedback', $feedback);

            $base->bind('fullScreen', $view);

            echo $base->render();
        }

        public function action_processReset()
        {
            $activation = $this->request->post('activation');
            $email = $this->request->post('email');
            $password = $this->request->post('password');
            $password2 = $this->request->post('password2');

            if ($activation != null && $email != null && $password != null && $password2 != null)
            {
                $user = ORM::factory('User')->where('email', '=', $email)->where('activation', '=', $activation)->find();

                if ($user->loaded())
                {
                    $user->activation = null;
                    $user->setPassword($password);
                    $user->save();

                    HTTP::redirect('login/2');
                }
                else
                {
                    HTTP::redirect('login/3');
                }
            }
            else
            {
                HTTP::redirect('login/3');
            }
        }

        public function action_sendReset()
        {
            $email = $this->request->post('email');

            if ($email != null)
            {
                $user = ORM::factory('User')->where('email', '=', $email)->find();

                if ($user->loaded())
                {
                    $user->setActivateCode();

                    $email = new Helper_Email();
                    $email->to = $user->email;
                    $email->from = 'biere@aep.polymtl.ca';
                    $email->senderName = 'Bière AEP';
                    $email->subject = 'Réinitialisation de votre mot de passe Bière AEP';
                    $email->content = '<html><p>Bonjour,</p>
                        <p>Vous venez de faire une demande de réinitialisation de mot de passe. Vous pouvez modifier votre mot de passe
                        en visitant la page suivante :</p>
                        <p>' . HTML::anchor('auth/reset/' . $user->activation, URL::site('auth/reset/' . $user->activation, true, true), [], true, true) . '</p>
                        <p>Pour toute question, veuillez contacter biere@aep.polymtl.ca</p>
                        </html>';
                    $email->send();

                    echo Helper_Alert::success('Un courriel vous a été envoyé avec les informations pour réinitialiser votre mot de passe');
                }
                else
                {
                    echo Helper_Alert::danger('L\'adresse courriel n\'existe pas');
                }
            }
            else
            {
                echo Helper_Alert::danger('Vous devez entrer l\'adresse courriel');
            }
        }



    }
