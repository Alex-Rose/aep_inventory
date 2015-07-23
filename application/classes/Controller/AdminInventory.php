<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_AdminInventory extends Controller_Async
    {

        public function before()
        {
            parent::before();
        }

        public function action_add()
        {
            $id = $this->request->param('id');

            $inv = ORM::factory('Inventory', $id);

            if ($inv->loaded())
            {
                $inv->quantity += 1;
                $inv->save();

                $this->data['succes'] = true;
                $this->data['quantity'] = $inv->quantity;

            }
        }

        public function action_remove()
        {
            $id = $this->request->param('id');

            $inv = ORM::factory('Inventory', $id);

            if ($inv->loaded())
            {
                $inv->quantity -= 1;

                if ($inv->quantity < 0)
                {
                    $inv->quantity = 0;
                }

                $inv->save();

                $this->data['succes'] = true;
                $this->data['quantity'] = $inv->quantity;

            }
        }

        public function action_set()
        {
            $id = $this->request->param('id');
            $val = $this->request->post('value');

            $inv = ORM::factory('Inventory', $id);

            if ($inv->loaded())
            {
                $inv->quantity = $val;

                if ($inv->quantity < 0)
                {
                    $inv->quantity = 0;
                }

                $inv->save();

                $this->data['succes'] = true;
                $this->data['quantity'] = $inv->quantity;

            }
        }

        public function action_addNew()
        {
            $id = $this->request->post('id');
            $qty = $this->request->post('quantity');

            $product = ORM::factory('Product', $id);

            if ($product->loaded())
            {
                $inventory = ORM::factory('Inventory')->where('productID', '=', $id)->find();

                $dup = false;

                if (!$inventory->loaded())
                {
                    $inventory->productID = $id;
                    $inventory->quantity = 0;
                }
                else
                {
                    $dup = true;
                }

                $inventory->quantity += $qty;
                $inventory->save();

                $this->data['success'] = true;
                $this->data['name'] = $product->name;
                $this->data['code'] = $product->code;
                $this->data['quantity'] = $inventory->quantity;
                $this->data['dup'] = $dup;
            }
            else
            {
                $this->data['feedback'] = Helper_Alert::danger('Le produit n\'existe pas');
            }
        }
//        public function action_save()
//        {
//            $id = $this->request->param('id');
//
//            $name       = $this->request->post('name');
//            $description= $this->request->post('description');
//            $brand      = $this->request->post('brand');
//            $format     = $this->request->post('format');
//            $pkg_size   = $this->request->post('package_size');
//            $type       = $this->request->post('type');
//            $code       = $this->request->post('code');
//            $salePrice  = $this->request->post('price');
//            $cost       = $this->request->post('cost');
//            $taxes      = $this->request->post('taxes');
//            $refund     = $this->request->post('refund');
//
//            $product = ORM::factory('Product', $id);
//
//            $product->name = $name;
//            $product->description = $description;
//            $product->brand = $brand;
//            $product->format = $format;
//            $product->package_size = $pkg_size;
//            $product->type = $type;
//            $product->code = $code;
//
//            $product->save();
//
//            $price = ORM::factory('Price')->where('productID', '=', $product->pk())->find();
//
//            $price->productID = $product->pk();
//            $price->cost    = $cost;
//            $price->price   = $salePrice;
//            $price->taxes   = $taxes;
//            $price->refund  = $refund;
//            $price->save();
//
//            $this->data['success'] = true;
//            $this->data['feedback'] = 'Enregistrement reussi';
//        }

//        public function action_search()
//        {
//            $query = $this->request->param('id');
//
//            $keywords = explode(' ', $query);
//
//            $products = ORM::factory('Product')->where_open();
//            foreach ($keywords as $kw)
//            {
//                $products->where('name', 'LIKE', '%'.$kw.'%');
//            }
//            $products->where_close();
//
//            $products->or_where('code', 'LIKE', '%'.$query.'%');
//
//            $products = $products->find_all();
//
//            $results = [];
//            foreach ($products as $product)
//            {
//                $result = [];
//                $result['name'] = $product->name;
//                $result['ID'] = $product->pk();
//                $result['brand'] = $product->brand;
//                $result['code'] = $product->code;
//                array_push($results, $result);
//            }
//
//            $this->data['success'] = true;
//            $this->data['results'] = $results;
//        }
    }
