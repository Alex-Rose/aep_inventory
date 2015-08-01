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
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Courriel</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Status</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($users as $user)
                {
                    echo '<tr>';
                    echo '<td>'.$user->email.'</td>';
                    echo '<td>'.($user->activation == null ? 'Actif' : 'Inactif').'</td>';
                    echo '<td><a href="'.URL::site('parameter/user/delete/'.$user->pk()).'" class="no_deco"><span class="label label-danger"><i class="fa fa-times"></i> Supprimer</span></a></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php echo HTML::anchor('parameter/user/add', 'Ajouter un nouvel utilisateur', ['class' => 'btn btn-primary']);?>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 2 ] }
            ]
        });
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
