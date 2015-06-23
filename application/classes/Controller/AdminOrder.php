<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AdminOrder extends Controller_Async
{
    public function before()
    {
        parent::before();

        $this->ensureLoggedIn();
    }

    public function action_save()
    {
        $id = $this->request->post('ID');
        $client = $this->request->post('client');
        $delivered = $this->request->post('delivered') == 'true';
        $products = $this->request->post('products');

        $order = ORM::factory('Order', $id);
        $client = ORM::factory('Client')->where('name', '=', $client)->find();
        $products = json_decode($products);

        if ($client->loaded())
        {
            // Cleanup any items in the order
            foreach($order->items->find_all() as $item)
            {
                $item->delete();
            }

            $order->clientID = $client->pk();
            $order->delivered = $delivered;
            $order->save();

            foreach ($products as $code => $amount)
            {
                $product = ORM::factory('Product')->where('code', '=', $code)->find();

                if ($product->loaded())
                {
                    $item = ORM::factory('OrderItem');
                    $item->orderID = $order->pk();
                    $item->productID = $product->pk();
                    $item->quantity = $amount;
                    $item->save();
                }
            }

            $this->data['success'] = true;
            $this->data['ID'] = $order->pk();
            $this->data['feedback'] = Helper_Alert::success('Commande enregistrée avec succès');
        }

    }
}
