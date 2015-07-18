<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Parameters extends Controller_Base
{
    public function before()
    {
        parent::before();

        $this->ensureLoggedIn();
    }

    public function action_site()
    {
        $this->title = 'Paramètres du site';
        $this->gstRate = number_format(floatval(Model_Parameter::getValue('GST_RATE')) * 100, 4);
        $this->qstRate = number_format(floatval(Model_Parameter::getValue('QST_RATE')) * 100, 4);
        $this->content = View::factory('param_site');
    }

}
