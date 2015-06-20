<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
<!--        <div class="dataTable_wrapper">-->
<!--            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">-->
<!--                <div class="row">-->
<!--                    <div class="col-sm-6">-->
<!--                        <div class="dataTables_length" id="dataTables-example_length">-->
<!--                            <label>Show-->
<!--                                <select name="dataTables-example_length" aria-controls="dataTables-example" class="form-control input-sm">-->
<!--                                    <option value="10">10</option>-->
<!--                                    <option value="25">25</option>-->
<!--                                    <option value="50">50</option>-->
<!--                                    <option value="100">100</option>-->
<!--                                </select>-->
<!--                                entries</label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-sm-6">-->
<!--                        <div id="dataTables-example_filter" class="dataTables_filter">-->
<!--                            <label>Search:-->
<!--                                <input type="search" class="form-control input-sm" placeholder="" aria-controls="dataTables-example">-->
<!--                            </label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-sm-12">-->
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Code</th>
                                    <th aria-controls="dataTables-example" rowspan="1" colspan="1" >Produit</th>
                                    <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($inventory as $inv)
                                {
                                    echo '<tr>';
                                    echo '<td>'.$inv->product->code.'</td>';
                                    echo '<td>'.$inv->product->name.'</td>';
                                    echo '<td><div style="display: flex;"><div class="qty" style="flex-grow: 1;">'.$inv->quantity.' </div>';
                                    echo '<div style="align-self: flex-end">';
                                    echo '<a class="add" href="'.URL::site('AdminInventory/add/'.$inv->pk()).'"><i class="fa fa-plus"></i></a> ';
                                    echo '<a class="remove" href="'.URL::site('AdminInventory/remove/'.$inv->pk()).'"><i class="fa fa-minus"></i></a>';
                                    echo '</div></div></td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="row">
    <div class="col-lg-12">
        <h3>Ajouter à l'inventaire</h3>
    </div>
</div>

<div class="row">
    <?php echo Form::open('AdminInventory/new', ['role' => 'form']);?>
    <div class="col-lg-4">
        <div class="input-group">
            <input class="search form-control" id="prod-search" type="text" data-url="<?php echo URL::site('AdminProduct/search');?>">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <ul id="search-results" class="list-group">

        </ul>
    </div>
</div>

    <li id="result-model" hidden>
        <div class="row">
            <div class="col-lg-1"><button class="btn btn-default">Ajouter</button></div>
            <div class="col-lg-2 code" style="margin-top: 7px;"></div>
            <div class="col-lg-8 name" style="margin-top: 7px;"></div>
            <div class="col-lg-1"><input type="number" value="1" class="addQty" style="width: 36px"></div>
        </div>
    </li>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).on('click', 'a.add', function(e){
        e.preventDefault();

        var url = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: url
        });

        var div = $(this).parents('td').find('.qty');
        var nb = parseInt(div.html());
        div.html(nb + 1);
    });

    $(document).on('click', 'a.remove', function(e){
        e.preventDefault();

        var url = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: url
        });

        var div = $(this).parents('td').find('.qty');
        var nb = parseInt(div.html());
        div.html((nb > 0 ? nb - 1: 0));
    });

    var searchTimeout = undefined;

    $('#prod-search').keyup(function(e){
        if (e.keyCode == 13 || e.which == 13){
            e.preventDefault();
        }

        var url = $(this).attr('data-url');
        url += '/' + $(this).val();

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function(){
            $.ajax({
                type: 'GET',
                url: url
            }).done(function(data){
                var model = $('#result-model');
                var results = $('#search-results');
                results.html('');
                $.each(data.results, function(i, item){
                    var r = $(document.createElement('li'));
                    r.html(model.html());
                    r.addClass('list-group-item');
                    r.find('.name').html(item.name);
                    r.find('.code').html(item.code);
                    results.append(r);
                });
            });
        }, 400);

    });


</script>