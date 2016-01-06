<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>

<div class="row" style="margin-bottom:10px;">
    <div class="col-lg-12">
        <?php echo HTML::anchor('order/create', 'Créer une nouvelle commande', ['class' => 'btn btn-sm btn-primary']);?>
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
            
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?php echo HTML::anchor('order/create', 'Créer une nouvelle commande', ['class' => 'btn btn-primary']);?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $.fn.dataTable.moment( 'DD-MM-YYYY' );

        $('#dataTables-example').DataTable({
            responsive: true,
            order: [[ 5, "desc" ]],
            processing: true,
            serverSide: true,
            ajax: {
                url: "AdminOrder/list",
                type: "POST"
            },
            columnDefs: [ { "targets": [1,2,3], "orderable": false } ]

        });
    });

</script>
