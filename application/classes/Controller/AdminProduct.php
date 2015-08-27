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
        $salePrice  = $this->request->post('price');
        $cost       = $this->request->post('cost');
        $taxes      = $this->request->post('taxes');
        $refund     = $this->request->post('refund');

        $product = ORM::factory('Product', $id);

        $product->name = $name;
        $product->description = $description;
        $product->brand = $brand;
        $product->format = $format;
        $product->package_size = $pkg_size;
        $product->type = $type;
        $product->code = $code;

        $product->save();

        $price = ORM::factory('Price')->where('productID', '=', $product->pk())->find();

        $price->productID = $product->pk();
        $price->cost    = $cost;
        $price->price   = $salePrice;
        $price->taxes   = $taxes;
        $price->refund  = $refund;
        $price->save();

        $this->updateInvoices($product);

        $this->data['success'] = true;
        $this->data['feedback'] = Helper_Alert::success('Enregistrement reussi');
    }

    public function action_search()
    {
        $query = $this->request->param('id');

        $keywords = explode(' ', $query);

        $products = ORM::factory('Product')->where_open();
        foreach ($keywords as $kw)
        {
            $products->where('name', 'LIKE', '%'.$kw.'%');
        }
        $products->where_close();

        $products->or_where('code', 'LIKE', '%'.$query.'%');

        $products = $products->limit(10)->find_all();

        $results = [];
        foreach ($products as $product)
        {
            $result = [];
            $result['name'] = $product->name;
            $result['ID'] = $product->pk();
            $result['brand'] = $product->brand;
            $result['code'] = $product->code;
            array_push($results, $result);
        }

        $this->data['success'] = true;
        $this->data['results'] = $results;
    }

    public function action_allProducts()
    {
        $products = ORM::factory('Product')->find_all();

        $result = [];
        foreach ($products as $product)
        {
            array_push($result, $product->code . ' - ' . $product->name);
        }

        $this->data = $result;
    }

    // This is not very scalable. Consider making calls to get what is needed OR cache result on clients
    public function action_associative()
    {
        $products = ORM::factory('Product')->find_all();

        $result = [];
        foreach ($products as $product)
        {
            $p = [];
            $p['ID'] = $product->pk();
            $p['name'] = $product->name;
            $p['code'] = $product->code;
            $p['description'] = $product->description;
            $p['brand'] = $product->format;
            $p['package_size'] = $product->package_size;
            $p['type'] = $product->type;
            $price = $product->prices->order_by('created', 'DESC')->find();

                $p['cost'] = $price->cost;
                $p['price'] = $price->price;
                $p['taxes'] = $price->taxes;
                $p['refund'] = $price->refund;

            $result[$product->code] = $p;
        }

        $this->data = $result;
    }

    public function action_formats()
    {
        $sQuery = 'SELECT DISTINCT(format) FROM product';
        $dQuery = DB::query(Database::SELECT, $sQuery)->execute();

        $results = [];
        foreach($dQuery as $t)
        {
            array_push($results, $t['format']);
        }

        $this->data = $results;
    }

    public function action_packages()
    {
        $sQuery = 'SELECT DISTINCT(package_size) FROM product';
        $dQuery = DB::query(Database::SELECT, $sQuery)->execute();

        $results = [];
        foreach($dQuery as $t)
        {
            array_push($results, $t['package_size']);
        }

        $this->data = $results;
    }

    public function action_types()
    {
        $sQuery = 'SELECT DISTINCT(type) FROM product';
        $dQuery = DB::query(Database::SELECT, $sQuery)->execute();

        $results = [];
        foreach($dQuery as $t)
        {
            array_push($results, $t['type']);
        }

        $this->data = $results;
    }

    protected function updateInvoices($product)
    {
        $items = ORM::factory('InvoiceItem')->with('invoice')->where('productID', '=', $product->pk())->where('invoice.paymentID', 'IS', null)->find_all();

        foreach ($items as $i)
        {
            $gstName = Model_Parameter::getValue('GST_NAME_SHORT');
            $qstName = Model_Parameter::getValue('QST_NAME_SHORT');
            $gstRate = floatval(Model_Parameter::getValue('GST_RATE'));
            $qstRate = floatval(Model_Parameter::getValue('QST_RATE'));

            if ($product->price->taxes == 'GST' || $product->price->taxes == 'BOTH')
            {
                $i->tax_1_name = $gstName;
                $i->tax_1_amount = $product->price->price * $i->quantity * $gstRate;
            }

            if ($product->price->taxes == 'QST' || $product->price->taxes == 'BOTH')
            {
                $i->tax_2_name = $qstName;
                $i->tax_2_amount = $product->price->price * $i->quantity * $qstRate;
            }

            $i->tax_incremental = true;
            $i->price           = $product->price->price * $i->quantity;
            $i->refund          = $product->price->refund * $i->quantity;
            $i->name            = $product->name;
            $i->brand           = $product->brand;
            $i->format          = $product->format;
            $i->package_size    = $product->package_size;
            $i->type            = $product->type;
            $i->code            = $product->code;
            $i->save();
        }
    }
}
