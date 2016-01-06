<?php

    class Helper_Datatables
    {
        private static $orders_sort = [
            0 => 'client.name',
            1 => '',
            2 => '',
            3 => '',
            4 => 'order.ID',
            5 => 'order.created'
        ];

        static function orders($draw, $start, $length, $search, $sort, $sortDir){
            if ($search != null && !empty($search))
            {
                $orders = ORM::factory('Order')->with('client')->where('name', 'LIKE', '%'.$search.'%')->order_by(self::$orders_sort[$sort], $sortDir)->find_all();
            }
            else
            {
                $orders = ORM::factory('Order')->with('client')->order_by(self::$orders_sort[$sort], $sortDir)->find_all();
            }


            $data = [
                'draw' => $draw,
                'recordsTotal'=> ORM::factory('Order')->count_all(),
                'recordsFiltered' => count($orders),
            ];

            $rows = [];

            $i = -1;
            foreach ($orders as $order)
            {
                $i++;
                if ($i < $start)
                {
                    continue;
                }

                if ($i >= $start + $length)
                {
                    break;
                }

                $row = [];
                array_push($row, '<a href="'.URL::site('order/edit/'.$order->pk()).'"><i class="fa fa-edit"></i></a> <a href="'.URL::site('order/view/'.$order->pk()).'">'.$order->client->name.'</a>');
                $cell = '<ul class="no_deco">';
                foreach ($order->items->find_all() as $item)
                {
                    $cell .= '<li>';
                    $cell .= '<span class="label label-info">'.$item->quantity.'</span> ';
                    $cell .= $item->product->name;
                    $cell .= '</li>';
                }

                $cell .= '</ul>';

                array_push($row, $cell);

                array_push($row, number_format(round($order->getTotals()['total'], 2), 2).' $');
                array_push($row, Form::checkbox('delivered', '', (bool)$order->delivered, ['disabled' => 'disabled']));

                $cell = '<td># '.$order->pk();
                if ($order->invoice->loaded())
                {
                    $cell .= ' - facture '. HTML::anchor('invoice/view/'.$order->invoice->pk(), '#'.$order->invoice->code);
                }

                array_push($row, $cell);
                array_push($row, date('d-m-Y', strtotime($order->created)));

                array_push($rows, $row);
            }

            $data['data'] = $rows;

            return $data;
        }
    }