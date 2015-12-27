<?php defined('SYSPATH') or die('No direct script access.');

    class Model_Order extends Helper_UsesNote
    {
        protected $_table_name  = 'order';
        protected $_primary_key = 'ID';

        protected $_belongs_to 	= ['client' => ['model' => 'Client', 'foreign_key' => 'clientID'],
                                   'note_item' => ['model' => 'Note', 'foreign_key' => 'noteID']];

        protected $_has_many 	= ['items' => ['model' => 'OrderItem', 'foreign_key' => 'orderID']];
        protected $_has_one 	= ['invoice' => ['model' => 'Invoice', 'foreign_key' => 'orderID']];

        public function createInvoice()
        {
            $invoice = ORM::factory('Invoice');

            $invoice->clientID = $this->client->pk();
            $invoice->orderID = $this->pk();
            $invoice->noteID = $this->noteID;
            $invoice->tax_incremental = true;
            $invoice->userID = Model_User::current()->pk();
            $invoice->save();

            $total = 0.0;
            $gst = 0.0;
            $qst = 0.0;
            $refund = 0.0;
            $price = 0.0;

            $gstName = Model_Parameter::getValue('GST_NAME_SHORT');
            $qstName = Model_Parameter::getValue('QST_NAME_SHORT');
            $gstRate = floatval(Model_Parameter::getValue('GST_RATE'));
            $qstRate = floatval(Model_Parameter::getValue('QST_RATE'));

            foreach ($this->items->find_all() as $item)
            {
                $i = ORM::factory('InvoiceItem');
                $i->invoiceID       = $invoice->pk();
                $i->productID       = $item->product->pk();
                $i->quantity        = $item->quantity;

                if ($item->product->price->taxes == 'GST' || $item->product->price->taxes == 'BOTH')
                {
                    $i->tax_1_name = $gstName;
                    $i->tax_1_amount = $item->product->price->price * $item->quantity * $gstRate;
                }

                if ($item->product->price->taxes == 'QST' || $item->product->price->taxes == 'BOTH')
                {
                    $i->tax_2_name = $qstName;
                    $i->tax_2_amount = $item->product->price->price * $item->quantity * $qstRate;
                }

                $i->tax_incremental = true;
                $i->price           = $item->product->price->price * $item->quantity;
                $i->price_unit      = $item->product->price->price;
                $i->refund          = $item->product->price->refund * $item->quantity;
                $i->refund_unit     = $item->product->price->refund;
                $i->name            = $item->product->name;
                $i->brand           = $item->product->brand;
                $i->format          = $item->product->format;
                $i->package_size    = $item->product->package_size;
                $i->type            = $item->product->type;
                $i->code            = $item->product->code;
                $i->save();

                $total  += $i->price;
                $total  += $i->tax_1_amount;
                $total  += $i->tax_2_amount;
                $total  += $i->refund;
                $gst    += $i->tax_1_amount;
                $qst    += $i->tax_2_amount;
                $refund += $i->refund;
                $price  += $i->price;
            }

            $invoice->total         = round($total, 2);
            $invoice->tax_1_name    = $gstName;
            $invoice->tax_1_amount  = round($gst, 2);
            $invoice->tax_2_name    = $qstName;
            $invoice->tax_2_amount  = round($qst, 2);
            $invoice->refund        = round($refund, 2);
            $invoice->price         = round($price, 2);
            $invoice->price_w_tax   = round($price + $gst + $qst, 2);
            $invoice->code          = (int)date("Y") - 1875 . $invoice->pk();
            $invoice->save();

            return $invoice;
        }

        public function getTotals()
        {
            $price = 0.0;
            $gst = 0.0;
            $qst = 0.0;
            $refund = 0.0;
            $deposit = 0.0;

            $gstRate = floatval(Model_Parameter::getValue('GST_RATE'));
            $qstRate = floatval(Model_Parameter::getValue('QST_RATE'));

            foreach ($this->items->find_all() as $item)
            {
                if ($item->product->price->taxes == 'GST' || $item->product->price->taxes == 'BOTH')
                {
                    $gst += $item->product->price->price * $item->quantity * $gstRate;
                }

                if ($item->product->price->taxes == 'QST' || $item->product->price->taxes == 'BOTH')
                {
                    $qst += $item->product->price->price * $item->quantity * $qstRate;
                }

                $price += $item->product->price->price * $item->quantity;

                if ($item->product->price->refund > 0)
                {
                    $deposit += $item->product->price->refund * $item->quantity;
                }
                else if ($item->product->price->refund < 0)
                {
                    $refund += $item->product->price->refund * $item->quantity;
                }
            }

            $total = $gst + $qst + $price + $refund;
            $priceWTax = $gst + $qst + $price;
            $totalRefund = $deposit + $refund;


            return [
                'price'     => $price,
                'total'     => $total,
                'qst'       => $qst,
                'gst'       => $gst,
                'refund'    => $refund,
                'deposit'   => $deposit,
                'totalRefund'=> $totalRefund,
                'priceWTax' => $priceWTax,
            ];
        }

        public function checkStocks()
        {
            foreach ($this->items->find_all() as $item)
            {
                $inventory = Model_Inventory::checkStocks($item->productID);

                if ($inventory < $item->quantity)
                {
                    return false;
                }
            }

            return true;
        }

        public function isPaid()
        {
            return $this->invoice->loaded() && $this->invoice->payment->loaded();
        }

        public function delete()
        {
            $items = $this->items->find_all();

            foreach ($items as $item)
            {
                $item->delete();
            }

            if ($this->note_item->loaded())
            {
                $this->note_item->delete();
            }

            parent::delete();
        }
    }
