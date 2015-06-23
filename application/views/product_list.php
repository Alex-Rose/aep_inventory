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
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Code</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Nom</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Distributeur</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Format</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Format de groupe</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Type de contenant</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Prix de vente</th>
                <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Prix avec taxes
                    <span data-toggle="tooltip" data-placement="top" title="Exclue la consigne">*</span>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($products as $product)
                {
                    echo '<tr>';
                    echo '<td><a href="'.URL::site('product/edit/'.$product->pk()).'"><i class="fa fa-edit"></i></a> '.$product->code.'</td>';
                    echo '<td>'.$product->name.'</td>';
                    echo '<td>'.$product->brand.'</td>';
                    echo '<td>'.$product->format.'</td>';
                    echo '<td>'.$product->package_size.'</td>';
                    echo '<td>'.$product->type.'</td>';
                    echo '<td>'.number_format($product->price->price, 2).' $</td>';
                    echo '<td>'.number_format($product->priceWithTaxes, 2).' $</td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php echo HTML::anchor('product/add', 'Ajouter un nouveau produit');?>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>