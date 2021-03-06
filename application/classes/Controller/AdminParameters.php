<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AdminParameters extends Controller_Async
{

    public function before()
    {
        parent::before();
    }

    public function action_save()
    {
        $qst = $this->request->post('qst');
        $gst = $this->request->post('gst');
        $qstName = $this->request->post('qstName');
        $gstName = $this->request->post('gstName');
        $gstNameShort = $this->request->post('gstNameShort');
        $qstNameShort = $this->request->post('qstNameShort');

        $qst = (floatval($qst) / 100);
        $gst = (floatval($gst) / 100);

        $this->updateParameter('QST_RATE', $qst);
        $this->updateParameter('GST_RATE', $gst);
        $this->updateParameter('QST_NAME', $qstName);
        $this->updateParameter('GST_NAME', $gstName);
        $this->updateParameter('GST_NAME_SHORT', $gstNameShort);
        $this->updateParameter('QST_NAME_SHORT', $qstNameShort);

        $this->data['success'] = true;
        $this->data['feedback'] = Helper_Alert::success('Paramètres enregistrés');
    }

    private function updateParameter($key, $value)
    {
        $parameter = Model_Parameter::getParameter($key);
        $parameter->key = $key;
        $parameter->value = $value;
        $parameter->save();
    }
}
