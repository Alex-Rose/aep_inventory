<?php defined('SYSPATH') or die('No direct script access.');

    class Model_User extends ORM
    {
        private static $current = false;

        protected $_table_name = 'user';
        protected $_primary_key = 'ID';

        public function isLogged()
        {
            return $this->loaded();
        }

        // Must be called after user contains an email address
        public function setPassword($password)
        {
            $this->password = hash('SHA512', strtolower($this->email).$password.'4V3ryLongH45h###***!');
            $this->save();
        }

        // Must be called after user contains an email address
        public function setActivateCode()
        {
            $this->activation = md5($this->email.$this->pk().time());
            $this->save();
        }

        // Returns true if the user has the required role
        public function isAdmin($required = ['ADMIN'])
        {
            return $this->role > 0;
        }

        public function sendConfirmationLink()
        {
            $email = new Helper_Email();
            $email->to = $this->email;
            $email->from = 'biere@aep.polymtl.ca';
            $email->senderName = 'Bière AEP';
            $email->subject = 'Création de votre compte Bière AEP';
            $email->content = '<html><p>Bonjour,</p>
                <p>Vous venez de créer votre compte Bière AEP. Avant de pouvoir l\'utiliser, vous devez
                confirmer votre adresse courriel en visitant la page suivante :</p>
                <p>'.HTML::anchor('auth/validate/'.$this->activation, URL::site('auth/validate/'.$this->activation, true, true), [], true, true).'</p>
                <p>Pour toute question, veuillez contacter biere@aep.polymtl.ca</p>
                </html>';
            $email->send();
        }

        public static function current()
        {
            if (self::$current === false) {
                self::setup_user(Session::instance()->get('user'));
            }

            return self::$current;
        }

        public static function setup_user($user)
        {
            if (!$user instanceof Model_User) {
                $user = ORM::factory('User', $user);
            }

            if ($user->loaded()) {
                self::$current = $user;
                Session::instance()->set('user', $user->pk());

                return true;
            } else {
                self::$current = ORM::factory('user');
                Session::instance()->set('user', null);

                return false;
            }
        }

        public static function login($email, $password)
        {
            $password = hash('SHA512', strtolower($email).$password.'4V3ryLongH45h###***!');

            $user = ORM::factory('User')->where('password','=',$password)->where('email','=',$email)->find();

            return self::setup_user($user);
        }

        public static function register($email, $password)
        {
            $user = ORM::factory('User')->where('email', '=', $email)->find();

            if (!$user->loaded())
            {
                $user = ORM::factory('User');
                $user->save();
                $user->activation = md5($email.$user->pk().time());
                $user->email = $email;
                $user->save();

                $user->setPassword($password);

                return true;
            }
            else
            {
                return false;
            }
        }
    }