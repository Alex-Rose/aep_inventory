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
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Montant</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Livrée</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Date créée</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($orders as $order)
                {
                    echo '<tr>';
                    echo '<td><a href="'.URL::site('order/edit/'.$order->pk()).'"><i class="fa fa-edit"></i></a> '.$order->client->name.'</td>';
                    echo '<td>Liste de produits</td>';
                    echo '<td>'.$order->client->phone.'</td>';
                    echo '<td>'.Form::checkbox('delivered', null, (bool)$order->delivered).'</td>';
                    echo '<td> '.$order->created.'</td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

</script>