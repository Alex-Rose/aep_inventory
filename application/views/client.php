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
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Nom</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Téléphone</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Courriel</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Solde</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($clients as $client)
                {
                    echo '<tr>';
                    echo '<td><a href="'.URL::site('client/list/edit/'.$client->pk()).'"><i class="fa fa-edit"></i></a> <a href="'.URL::site('client/list/details/'.$client->pk()).'">'.$client->name.'</a></td>';
                    echo '<td>'.$client->phone.'</td>';
                    echo '<td>'.$client->email.'</td>';
                    echo '<td> 0$ </td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php echo HTML::anchor('client/add', 'Ajouter un nouveau client', ['class' => 'btn btn-primary']);?>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

</script>
