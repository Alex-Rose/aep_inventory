<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-invoiceList">
            <thead>
            <tr>
                <th aria-controls="dataTables-invoiceList" rowspan="1" colspan="1" style="width: 100px;">Client</th>
                <th aria-controls="dataTables-invoiceList" rowspan="1" colspan="1" style="width: 100px;">Sommaire</th>
                <th aria-controls="dataTables-invoiceList" rowspan="1" colspan="1" style="width: 100px;">Montant</th>
                <th aria-controls="dataTables-invoiceList" rowspan="1" colspan="1" style="width: 100px;">Action</th>
                <th aria-controls="dataTables-invoiceList" rowspan="1" colspan="1" style="width: 100px;"># Facture</th>
                <th aria-controls="dataTables-invoiceList" rowspan="1" colspan="1" style="width: 100px;">Date créée</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($orders as $order)
                {
                    echo '<tr>';
                    echo '<td>';
//                    echo '<a href="'.URL::site('order/edit/'.$order->pk()).'"><i class="fa fa-edit"></i></a> ';
                    echo $order->client->name.'</td>';
                    echo '<td><ul class="no_deco">';
                    foreach ($order->invoice->items->find_all() as $item)
                    {
                        echo '<li>';
                        echo '<span class="label label-info">'.$item->quantity.'</span> ';
                        echo $item->name;
                        echo '</li>';
                    }
                    echo '</li></td>';
                    echo '<td>'.$order->client->phone.'</td>';
                    echo '<td>';
                    $class = $order->delivered ? 'btn-success active' : 'btn-default';
                    $tooltip = $order->delivered ? 'Livrée' : 'Livraison en attente';
                    $url = URL::site('AdminOrder/toggleDelivered/'.$order->pk());
                    echo '<button type="button" class="delivered btn btn-sm '.$class.'" data-toggle="button" aria-pressed="'.($order->delivered ? 'true' : 'false').'" autocomplete="off" data-placement="top" title="'.$tooltip.'" data-url='.$url.'>';
                    echo '<i class="fa fa-truck"></i>';
                    echo '</button> ';

//                    $class = $order->invoice->paymentID ? 'btn-primary active' : 'btn-default';
//                    $tooltip = $order->invoice->paymentID ? 'Payée' : 'Impayée';
//                    echo '<button type="button" class="paid btn btn-sm '.$class.'" data-toggle="button" aria-pressed="'.($order->invoice->paymentID ? 'true' : 'false').'" autocomplete="off" data-placement="top" title="'.$tooltip.'">';
//                    echo '<i class="fa fa-usd"></i>';
//                    echo '</button>';

                    $class = $order->invoice->paymentID ? 'btn-primary' : 'btn-default';
                    $disabled = $order->invoice->paymentID ? 'disabled' : '';
                    $tooltip = $order->invoice->paymentID ? 'Payée' : 'Impayée';
                    echo '<a href="'.URL::site('invoice/pay/'.$order->invoice->pk()).'" class="paid btn btn-sm '.$class.'" title="'.$tooltip.'"><i class="fa fa-usd"></i></a>';

                    echo ' <a href="'.URL::site('invoice/print/'.$order->invoice->pk()).'" class="paid btn btn-sm btn-default" title="Imprimer la facture" target="_blank"><i class="fa fa-print"></i></a>';
                    echo ' <a href="'.URL::site('invoice/view/'.$order->invoice->pk()).'" class="paid btn btn-sm btn-default" title="Détails de la facture"><i class="fa fa-search"></i></a>';

                    echo '</td>';
                    echo '<td><a href="'.URL::site('invoice/view/'.$order->invoice->pk()).'"># '.$order->invoice->code.'</a></td>';
                    echo '<td> '.$order->invoice->created.'</td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-invoiceList').DataTable({
            responsive: true
        });

        $('.delivered').tooltip()
        $('.paid').tooltip()
    });


    $('button.delivered').click(function(e){
        $(this).removeClass('btn-success');
        $(this).removeClass('btn-default');
        if (!$(this).hasClass('active')){
            $(this).addClass('btn-success');
        }
        else{
            $(this).addClass('btn-default');
       }

        var url = $(this).attr('data-url');
        $.ajax({
            method: 'POST',
            url: url,
            data: {}
        });
    });

</script>
