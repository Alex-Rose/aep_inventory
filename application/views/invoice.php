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
                    echo '<tr id="row-'.$order->invoice->pk().'">';
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
                    echo '<td>'.Helper_Number::format($order->invoice->total).' $</td>';
                    echo '<td>';
                    echo '<div class="actions">';
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
                    echo ' <a href="#" class="paid btn btn-sm btn-default delete-invoice" title="Supprimer la facture" data-url="'.URL::site('AdminInvoice/delete/'.$order->invoice->pk()).'" data-code="'.$order->invoice->code.'" data-row-id="row-'.$order->invoice->pk().'" data-toggle="modal" data-target="#modal-confirm"><i class="fa fa-remove"></i></a>';
                    echo '</div>';
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal-confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmer la suppression</h4>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la facture #<span id="modal-nb"></span></p>
                <p id="modal-feedback"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-dismiss">Annuler</button>
                <button type="button" class="btn btn-danger" id="modal-delete" data-url="" data-row-id="">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
    var table = undefined;
    $(document).ready(function() {
        table = $('#dataTables-invoiceList').DataTable({
            responsive: true
        });

        $('.delivered').tooltip();
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

    $(document).on('click', 'a.delete-invoice', function(e) {
        e.preventDefault();
        var code = $(this).attr('data-code');
        var url = $(this).attr('data-url');
        $('#modal-nb').html(code);
        $('#modal-delete').attr('data-url', url);
        $('#modal-delete').attr('data-row-id', $(this).attr('data-row-id'));
    });

    $(document).on('click', 'a.delete-payment', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $.ajax({
            method: 'POST',
            url: url,
            data: {}
        }).done(function(data) {
            $('#modal-feedback').html(data.feedback);
        });
    });

    $('#modal-confirm').on('hide.bs.modal', function(e){
        $('#modal-feedback').html('');
        $('#modal-delete').show();
        $('#modal-delete').prop('disabled', false);
        $('#modal-dismiss').html('Annuler');
    });

    $('#modal-delete').on('click', function(e){
        e.preventDefault();
        $('#modal-delete').prop('disabled', true);
        var url = $(this).attr('data-url');

        $.ajax({
            method: 'POST',
            url: url,
            data: {}
        }).done(function(data) {
            if (data.success) {
                $('#modal-delete').hide();
                $('#modal-dismiss').html('Fermer');

                try {
                    var rowId = $('#modal-delete').attr('data-row-id');
                    var row = table.row($('#'+rowId));
                    var rowNode = row.node();
                    table.row(rowNode).remove().draw();
                } catch (ex) {
                    console.error('Unable to remove row from table');
                }

            } else {
                $('#modal-delete').prop('disabled', false);
            }

            $('#modal-feedback').html(data.feedback);
        });
    })

</script>
