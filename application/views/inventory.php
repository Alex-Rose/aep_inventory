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
                        <table class="table table-striped table-bordered table-hover dataTable no-footer products-table" id="dataTables-example">
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
                                    echo '<td><input class="quantity" type="number" value="'.$inv->quantity.'" min="0" data-url="'.URL::site('AdminInventory/set/'.$inv->pk()).'"/></td>';
                                    // echo '<td><div style="display: flex;"><div class="qty" style="flex-grow: 1;">'.$inv->quantity.' </div>';
                                    // echo '<div style="align-self: flex-end">';
                                    // echo '<a class="add" href="'.URL::site('AdminInventory/add/'.$inv->pk()).'"><i class="fa fa-plus"></i></a> ';
                                    // echo '<a class="remove" href="'.URL::site('AdminInventory/remove/'.$inv->pk()).'"><i class="fa fa-minus"></i></a>';
                                    // echo '</div></div></td>';
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
    <div class="col-lg-5" id="product-search">
        <div class="input-group" style="height: 29px;">
            <?php echo Form::input('product-search', '', ['class' => 'form-control typeahead', 'data-url' => URL::site('AdminProduct/allProducts')]);?>
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
        </div>
    </div>
    <div class="col-lg-2" data-toggle="tooltip" data-placement="top" title="Quantité">
        <input name="add-nb" type="number" value="1" class="form-control" />
    </div>
    <div class="col-lg-1">
        <button name="add-new" class="btn btn-success add-new" data-url="<?php echo URL::site('AdminInventory/AddNew');?>"><i class="fa fa-plus"></i></button>
    </div>
</div>

<tr id="row-model" hidden>
    <td class="code"></td>
    <td class="name"></td>
    <td class="quantity"></td>
</tr>

<?php echo Form::hidden('products-data', URL::site('AdminProduct/associative'));?>

<script>
    var products = [];

    $.get($('input:hidden[name=products-data]').val(), null, function(value){
        products = value;
    });

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            "aoColumnDefs": [
              { 'bSortable': false, 'aTargets': [ 2 ] }
           ]
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

    $(document).on('change', 'input.quantity', function(e){
        var url = $(this).attr('data-url');
        var val = $(this).val();
        $.ajax({
            type: 'POST',
            url: url,
            data: {value: val}
        });
    });

    // var searchTimeout = undefined;

    $.get($('#product-search .typeahead').attr('data-url'), null, function(value){
        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // url points to a json file that contains an array of country names, see
            // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
            local: value
        });

        $('#product-search .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'products',
                source: products
            });
    });


    $('input.typeahead').keypress(function (e) {
        if (e.which == 13) {
            e.preventDefault();
            $('.tt-suggestion:first-child').trigger('click');
        }
    });

    $('.add-new').click(function(e){
        e.preventDefault();

        var url = $(this).attr('data-url');
        var productCode = $('input[name=product-search]').val().split('\\')[0].trim();
        var product = products[productCode];
        var id = product['ID'];
        var qty = $('input[name=add-nb]').val();

        $.ajax({
            type: 'POST',
            url: url,
            data: {id: id, quantity: qty}
        }).done(function (data){
            if (data.success){
                    var table = $('table.products-table > tbody');
                if (data.dup){
                    var qty = table.find('td:contains('+data.code+')').parents('tr').find('.quantity');
                    qty.val(data.quantity);
                }else{
                    var model = $('#row-model');
                    var r = $(document.createElement('tr'));
                    r.html(model.html());
                    r.find('.name').html(data.name);
                    r.find('.code').html(data.code);
                    r.find('.quantity').html(data.quantity);
                    table.append(r);
                    location.reload();
                }
            }
        });
    });

    function findByName(element, index, array) {

      var start = 2;
      while (start <= Math.sqrt(element)) {
        if (element % start++ < 1) {
          return false;
        }
      }
      return element > 1;
    }
    // $('#prod-search').keyup(function(e){
    //     if (e.keyCode == 13 || e.which == 13){
    //         e.preventDefault();
    //     }
    //
    //     var url = $(this).attr('data-url');
    //     url += '/' + $(this).val();
    //
    //     clearTimeout(searchTimeout);
    //     searchTimeout = setTimeout(function(){
    //         $.ajax({
    //             type: 'GET',
    //             url: url
    //         }).done(function(data){
    //             var model = $('#result-model');
    //             var results = $('#search-results');
    //             results.html('');
    //             $.each(data.results, function(i, item){
    //                 var r = $(document.createElement('li'));
    //                 r.html(model.html());
    //                 r.addClass('list-group-item');
    //                 r.find('.name').html(item.name);
    //                 r.find('.code').html(item.code);
    //                 results.append(r);
    //             });
    //         });
    //     }, 400);
    //
    // });


</script>
