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

        static function invoices($draw, $start, $length, $search, $sort, $sortDir)
        {
            if ($search != null && !empty($search))
            {
                $orders = ORM::factory('Order')->with('invoice')->with('client')->where('orderID', 'IS NOT', null)->where('name', 'LIKE', '%' . $search . '%')->order_by(self::$orders_sort[$sort], $sortDir)->find_all();
            }
            else
            {
                $orders = ORM::factory('Order')->with('invoice')->with('client')->where('orderID', 'IS NOT', null)->order_by(self::$orders_sort[$sort], $sortDir)->find_all();
            }


            $data = [
                'draw' => $draw,
                'recordsTotal' => ORM::factory('Order')->with('invoice')->with('client')->where('orderID', 'IS NOT', null)->count_all(),
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

                $row['DT_RowId'] = 'row-'.$order->invoice->pk();

                $row['name'] = $order->client->name;

                $cell = '<ul class="no_deco">';
                foreach ($order->invoice->items->find_all() as $item)
                {
                    $cell .= '<li>';
                    $cell .= '<span class="label label-info">'.$item->quantity.'</span> ';
                    $cell .= $item->name;
                    $cell .= '</li>';
                }
                $cell .= '</li>';
                $row['summary'] = $cell;

                $row['total'] = Helper_Number::format($order->invoice->total).' $';

                $cell = '<div class="actions">';
                $class = $order->delivered ? 'btn-success active' : 'btn-default';
                $tooltip = $order->delivered ? 'Livrée' : 'Livraison en attente';
                $url = URL::site('AdminOrder/toggleDelivered/'.$order->pk());
                $cell .= '<button type="button" class="delivered btn btn-sm '.$class.'" data-toggle="button" aria-pressed="'.($order->delivered ? 'true' : 'false').'" autocomplete="off" data-placement="top" title="'.$tooltip.'" data-url='.$url.'>';
                $cell .= '<i class="fa fa-truck"></i>';
                $cell .= '</button> ';

                $class = $order->invoice->paymentID ? 'btn-primary' : 'btn-default';
                $disabled = $order->invoice->paymentID ? 'disabled' : '';
                $tooltip = $order->invoice->paymentID ? 'Payée' : 'Impayée';
                $cell .= '<a href="'.URL::site('invoice/pay/'.$order->invoice->pk()).'" class="paid btn btn-sm '.$class.'" title="'.$tooltip.'"><i class="fa fa-usd"></i></a>';

                $cell .= ' <a href="'.URL::site('invoice/print/'.$order->invoice->pk()).'" class="paid btn btn-sm btn-default" title="Imprimer la facture" target="_blank"><i class="fa fa-print"></i></a>';
                $cell .= ' <a href="'.URL::site('invoice/view/'.$order->invoice->pk()).'" class="paid btn btn-sm btn-default" title="Détails de la facture"><i class="fa fa-search"></i></a>';
                $cell .= ' <a href="#" class="paid btn btn-sm btn-default delete-invoice" title="Supprimer la facture" data-url="'.URL::site('AdminInvoice/delete/'.$order->invoice->pk()).'" data-code="'.$order->invoice->code.'" data-row-id="row-'.$order->invoice->pk().'" data-toggle="modal" data-target="#modal-confirm"><i class="fa fa-remove"></i></a>';
                $cell .= '</div>';

                $row['action'] = $cell;

                $row['code'] = '<a href="'.URL::site('invoice/view/'.$order->invoice->pk()).'"># '.$order->invoice->code.'</a>';
                $row['created'] = date('d-m-Y', strtotime($order->created));

                array_push($rows, $row);
            }

            $data['data'] = $rows;

            return $data;
        }
    }