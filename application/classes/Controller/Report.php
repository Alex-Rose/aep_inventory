<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Report extends Controller_Base
    {
        public function before()
        {
            parent::before();

            $this->ensureLoggedIn();
        }

        public function action_index()
        {
            $this->title = 'Rapport mensuel';
            $this->orders = ORM::factory('Order')->with('invoice')->where('orderID', 'IS NOT', null)->order_by('invoice.created', 'DESC')->find_all();
            $this->content = View::factory('report_month');
        }
    }
