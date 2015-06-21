<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('AdminOrder/save/'.$order->pk(), ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-lg-2">Client</label>
            <div class="col-lg-10" id="client-search">
                <?php echo Form::input('name', $order->client->name, ['class' => 'form-control typeahead', 'data-url' => URL::site('AdminClient/allNames')]);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Produit</label>
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-5" id="product-search">
                        <?php echo Form::input('product-search', '', ['class' => 'form-control typeahead', 'data-url' => URL::site('AdminProduct/allProducts')]);?>
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="col-lg-1">
                        <input name="add-nb" type="number" value="1" class="form-control" />
                    </div>
                    <div class="col-lg-1">
                        <button name="add" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="row" style="padding-top: 12px;">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered table-hover product-table">
                            <tr><th>Code</th><th>Produit</th><th>Quantité</th><th>Prix</th></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-amount"><?php echo '0.00';?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Livrée</label>
            <div class="col-lg-1">
                <?php echo Form::checkbox('delivered', null, (bool)$order->delivered, ['class' => 'form-control', 'style' => 'width:34px']);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4">
                <?php echo Form::submit('save', 'Enregistrer', ['class' => 'form-control btn btn-primary']);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4" id="feedback">
            </div>
        </div>
    </div>
</div>

<?php echo Form::hidden('products-data', URL::site('AdminProduct/associative'));?>

<script>
    $('input:submit[name=save]').click(postData);

    $.get($('#client-search .typeahead').attr('data-url'), null, function(value){
        var clients = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // url points to a json file that contains an array of country names, see
            // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
            local: value
        });

        $('#client-search .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'clients',
                source: clients
            });
    });

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

    var products = [];
    $.get($('input:hidden[name=products-data]').val(), null, function(value){
        products = value;
    });

    $('button[name=add]').click(function(e){
        e.preventDefault();

        var row     = $(document.createElement('tr'));
        var code    = $(document.createElement('td'));
        var name    = $(document.createElement('td'));
        var qty     = $(document.createElement('td'));
        var price   = $(document.createElement('td'));


        var product = products[$('input[name=product-search]').val()];
        var newPrice = $('input[name=add-nb]').val() * parseFloat(product['price'])

        code.html(product['code']);
        name.html(product['name']);
        qty.html($('input[name=add-nb]').val());
        price.html(newPrice + ' $');

        row.append(code);
        row.append(name);
        row.append(qty);
        row.append(price);

        $('table.product-table').append(row);

        var totalAmount = $('#total-amount');
        totalAmount.html(parseFloat(totalAmount.html()) + newPrice);
    });


</script>