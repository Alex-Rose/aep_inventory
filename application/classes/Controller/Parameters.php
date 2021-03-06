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
        $this->gstName = Model_Parameter::getValue('GST_NAME');
        $this->qstName = Model_Parameter::getValue('QST_NAME');
        $this->qstNameShort = Model_Parameter::getValue('QST_NAME_SHORT');
        $this->gstNameShort = Model_Parameter::getValue('GST_NAME_SHORT');
        $this->content = View::factory('param_site');
    }

}
