<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Commandes durant le dernier mois
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                        <thead>
                        <tr>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Client</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Sommaire</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Montant</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Livrée</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Date créée</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $orders = ORM::factory('Order')->where('created', '>=', date('Y-m-d 00:00:00', strtotime('first day of 0 month')))->find_all();
                            foreach ($orders as $order)
                            {
                                echo '<tr>';
                                echo '<td><a href="'.URL::site('order/edit/'.$order->pk()).'"><i class="fa fa-edit"></i></a> <a href="'.URL::site('order/view/'.$order->pk()).'">'.$order->client->name.'</a></td>';
                                echo '<td><ul class="no_deco">';
                                foreach ($order->items->find_all() as $item)
                                {
                                    echo '<li>';
                                    echo '<span class="label label-info">'.$item->quantity.'</span> ';
                                    echo $item->product->name;
                                    echo '</li>';
                                }

                                echo '</ul></td>';

                                echo '<td>'.number_format(round($order->getTotals()['total'], 2), 2).' $</td>';
                                echo '<td>'.Form::checkbox('delivered', '', (bool)$order->delivered, ['disabled' => 'disabled']).'</td>';
                                echo '<td> '.date('d-m-Y', strtotime($order->created)).'</td>';
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $grandTotal = 0;
    $paidTotal = 0;
    $unpaidTotal = 0;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Factures durant le dernier mois
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                        <thead>
                        <tr>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Client</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Sommaire</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Montant</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Livrée</th>
                            <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Date créée</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $invoices = ORM::factory('Invoice')->where('created', '>=', date('Y-m-d 00:00:00', strtotime('first day of 0 month')))->find_all();
                            foreach ($invoices as $invoice)
                            {
                                echo '<tr>';
                                echo '<td><a href="'.URL::site('invoice/view/'.$invoice->pk()).'">'.$invoice->client->name.'</a></td>';
                                echo '<td><ul class="no_deco">';
                                foreach ($invoice->items->find_all() as $item)
                                {
                                    echo '<li>';
                                    echo '<span class="label label-info">'.$item->quantity.'</span> ';
                                    echo $item->product->name;
                                    echo '</li>';
                                }

                                echo '</ul></td>';

                                echo '<td>'.number_format(round($invoice->total, 2), 2).' $</td>';
                                echo '<td>'.Form::checkbox('delivered', '', (bool)$invoice->order->delivered, ['disabled' => 'disabled']).'</td>';
                                echo '<td> '.date('d-m-Y', strtotime($invoice->created)).'</td>';
                                echo '</tr>';

                                $grandTotal += $invoice->total;

                                if ($invoice->payment->loaded())
                                {
                                    $paidTotal += $invoice->total;
                                }
                                else
                                {
                                    $unpaidTotal += $invoice->total;
                                }
                            }
                        ?>
                        </tbody>
                    </table>

                    <?php echo Form::open('', ['class' => 'form-horizontal', 'role' => 'form']); ?>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Total des ventes</label>
                        <div class="col-lg-10" id="client-search">
                            <div class="form-text"><?php echo number_format(round($grandTotal, 2), 2).' $'; ?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">Total des paiements reçus</label>
                        <div class="col-lg-10" id="client-search">
                            <div class="form-text"><?php echo number_format(round($paidTotal, 2), 2).' $'; ?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">Total à recevoir</label>
                        <div class="col-lg-10" id="client-search">
                            <div class="form-text"><?php echo number_format(round($unpaidTotal, 2), 2).' $'; ?></div>
                        </div>
                    </div>
                    <?php echo Form::close();?>
                </div>
            </div>
        </div>
    </div>
</div>
