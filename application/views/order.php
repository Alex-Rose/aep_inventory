<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
            <thead>
            <tr>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Client</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Sommaire</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Montant</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Livrée</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;"># Commande</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Date créée</th>
            </tr>
            </thead>
            <tbody>
            <?php
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
                    echo '<td># '.$order->pk();
                    if ($order->invoice->loaded())
                    {
                        echo ' - facture '. HTML::anchor('invoice/view/'.$order->invoice->pk(), '#'.$order->invoice->code);
                    }
                    echo '</td>';
                    echo '<td> '.date('d-m-Y', strtotime($order->created)).'</td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php echo HTML::anchor('order/create', 'Créer une nouvelle commande', ['class' => 'btn btn-primary']);?>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

</script>
