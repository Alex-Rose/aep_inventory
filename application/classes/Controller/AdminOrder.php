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
        $note = $this->request->post('note');

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
            $order->note = $note;
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

            if ($order->invoice->loaded() && $order->invoice->paymentID == null) // Should check this before editing the order
            {
                $order->invoice->delete();
                $invoice = $order->createInvoice();
                $this->data['invoiceID'] = $invoice->pk();
            }

            $this->data['success'] = true;
            $this->data['ID'] = $order->pk();
            $this->data['feedback'] = Helper_Alert::success('Commande enregistrée avec succès');

        }
        else
        {
            $this->data['feedback'] = Helper_Alert::danger('Le client n\'existe pas');
        }
    }

    public function action_allItems()
    {
        $id = $this->request->param('id');
        $result = [];

        $order = ORM::factory('Order', $id);

        if ($order->loaded())
        {
            foreach ($order->items->find_all() as $item)
            {
                $i = [];
                $i['code'] = $item->product->code;
                $i['quantity'] = $item->quantity;

                array_push($result, $i);
            }
        }

        $this->data = $result;
    }

    public function action_bill()
    {
        $id = $this->request->post('id');

        $order = ORM::factory('Order', $id);

        if ($order->loaded())
        {
            $invoice = $order->createInvoice();

            $this->data['success'] = true;
            $this->data['feedback'] = Helper_Alert::success('La commande a été facturée. Voir la '. HTML::anchor('invoice/view/'.$invoice->pk(), 'facture'));
        }
        else
        {
            $this->data['feedback'] = Helper_Alert::danger('Commande introuvable');
        }
    }

    public function action_toggleDelivered()
    {
        $id = $this->request->param('id');

        $order = ORM::factory('Order', $id);

        if ($order->loaded())
        {
            $order->delivered = !(bool)$order->delivered;
            $order->save();

            $this->data['success'] = true;
            $this->data['feedback'] = Helper_Alert::success('La commande a été livrée');
        }
    }

    public function action_list()
    {
        $this->writeJson = true;

        $page = $this->request->post('draw');
        $start = $this->request->post('start');
        $nb = $this->request->post('length');
        $search = $_POST['search']['value'];
        $sort = $_POST['order'][0]['column'];
        $sortDir = $_POST['order'][0]['dir'];

        $this->data = Helper_Datatables::orders($page, $start, $nb, $search, $sort, $sortDir);
    }

    public function action_delete()
    {
        $this->writeJson = true;

        $id = $this->request->param('id');

        $order = ORM::factory('Order', $id);

        if ($order->loaded())
        {
            if (!$order->invoice->loaded())
            {
                $order->delete();
                $this->data['success'] = true;
                $this->data['feedback'] = Helper_Alert::success('Commande supprimée');
                $this->data['redirect'] = URL::site('Order');

                Model_Log::Log('AdminOrder - User '. $this->user->pk() .' deleted order '. $id, 'TRACE');
            }
            else
            {
                $this->data['success'] = false;
                $this->data['feedback'] = Helper_Alert::danger('Vous devez d\'abord supprimer la facture');
            }
        }
        else
        {
            $this->data['success'] = false;
            $this->data['feedback'] = Helper_Alert::danger('La commande n\'existe pas');
        }
    }
}
