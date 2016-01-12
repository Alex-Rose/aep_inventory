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
            responsive: true,
            order: [[ 5, "desc" ]],
            processing: true,
            serverSide: true,
            ajax: {
                url: "AdminInvoice/list",
                type: "POST"
            },
            columns : [
                { "data" : 'name'},
                { "data" : 'summary'},
                { "data" : 'total'},
                { "data" : 'action'},
                { "data" : 'code'},
                { "data" : 'created'},
            ],
            columnDefs: [ { "targets": [1,2,3], "orderable": false } ]
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
