<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AdminProduct extends Controller_Async
{

    public function before()
    {
        parent::before();
    }

    public function action_save()
    {
        $id = $this->request->param('id');

        $name       = $this->request->post('name');
        $description= $this->request->post('description');
        $brand      = $this->request->post('brand');
        $format     = $this->request->post('format');
        $pkg_size   = $this->request->post('package_size');
        $type       = $this->request->post('type');
        $code       = $this->request->post('code');

        $product = ORM::factory('Product', $id);

        $product->name = $name;
        $product->description = $description;
        $product->brand = $brand;
        $product->format = $format;
        $product->package_size = $pkg_size;
        $product->type = $type;
        $product->code = $code;

        $product->save();

        $this->data['success'] = true;
        $this->data['feedback'] = 'Enregistrement reussi';
    }
}