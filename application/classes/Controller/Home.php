<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Home extends Controller_Base
    {
        public function before()
        {
		parent::before();
        }

        public function action_index()
        {
		$this->content = View::factory('home');
        }
}
