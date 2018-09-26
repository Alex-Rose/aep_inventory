<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title.($order->pk() != null ? ' # '.$order->pk() : '');?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('AdminOrder/save', ['class' => 'form-horizontal', 'role' => 'form']); ?>

        <?php if (isset($comment)) { ?>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4">
                 <?php echo $comment; ?>
            </div>
        </div>
        <?php } ?>

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
                        <div class="input-group" style="height: 29px;">
                            <?php echo Form::input('product-search', '', ['class' => 'form-control typeahead', 'data-url' => URL::site('AdminProduct/allProducts')]);?>
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-1" data-toggle="tooltip" data-placement="top" title="Quantité">
                        <input name="add-nb" type="number" value="1" class="form-control" />
                    </div>
                    <div class="col-lg-1">
                        <button name="add" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="row" style="padding-top: 12px;">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered table-hover product-table">
                            <thead>
                                <tr><th>Code</th>
                                    <th>Produit</th>
                                    <th style="width:200px">Quantité</th>
                                    <th style="width:200px">Prix</th></tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Note</label>
            <div class="col-lg-10">
                <div class="">
                    <?php echo Form::textarea('note', $order->note, ['class' => 'form-control']);?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Sous-total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-amount"><?php echo Helper_Number::format(0.0);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo Model_Parameter::getValue('GST_NAME_SHORT');?></label>
            <div class="col-lg-10">
                <div class="form-text"><span id="gst-amount"><?php echo Helper_Number::format(0.0);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo Model_Parameter::getValue('QST_NAME_SHORT');?></label>
            <div class="col-lg-10">
                <div class="form-text"><span id="qst-amount"><?php echo Helper_Number::format(0.0);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Sous-total bières</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-wtax-amount"><?php echo Helper_Number::format(0.0);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"></label>
            <div class="col-lg-10">

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Dépôt</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="deposit-amount"><?php echo Helper_Number::format(0.0);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Remboursement vides</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="refund-amount"><?php echo Helper_Number::format(0.0);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total dépôts / vides</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-refund-amount"><?php echo Helper_Number::format(0.00);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="grand-total-amount"><?php echo '0.00';?></span> <span data-toggle="tooltip" data-placement="top" title="Prix arrondi. Le prix réel peut varier légèrement">$</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Livrée</label>
            <div class="col-lg-1">
                <?php echo Form::checkbox('delivered', null, (bool)$order->delivered, ['class' => 'form-control', 'style' => 'width:34px']);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-3">
                <?php echo Form::submit('save', 'Enregistrer', ['class' => 'form-control btn btn-primary']);?>
            </div>

            <?php if (!$order->invoice->loaded()){ ?>
                <div class="col-lg-3">
                    <?php echo Form::submit('bill', 'Facturer', ['class' => 'form-control btn btn-success', 'data-url' => URL::site('AdminOrder/bill')]);?>
                </div>
            <?php } else { ?>
                <div class="col-lg-3">
                    <?php echo HTML::anchor('invoice/view/'.$order->invoice->pk(), 'Voir la facture', ['class' => 'form-control btn btn-default', 'id' => 'viewInvoice']);?>
                </div>
            <?php } ?>

        </div>

        <?php if ($order->loaded()) { ?>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-3">
                <?php echo Form::submit('delete', 'Supprimer la commande', ['class' => 'form-control btn btn-danger',
                    'data-url' => URL::site('AdminOrder/delete/'.$order->pk()),
                    'data-code' => $order->pk(),
                    'data-toggle' => "modal",
                    'data-target' => "#modal-confirm"]);?>
            </div>
        </div>
        <?php } ?>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4" id="feedback">
            </div>
        </div>
    </div>
</div>

<?php echo Form::hidden('products-data', URL::site('AdminProduct/associative'));?>
<?php echo Form::hidden('products-list', URL::site('AdminOrder/allItems/'.$order->pk()));?>
<?php echo Form::hidden('GST', Model_Parameter::getValue('GST_RATE'));?>
<?php echo Form::hidden('QST', Model_Parameter::getValue('QST_RATE'));?>
<?php echo Form::hidden('ID', $order->pk());?>
<?php echo Form::hidden('invoice-view-url', URL::site('invoice/view'));?>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmer la suppression</h4>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la commande #<span id="modal-nb"></span></p>
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

    var products = [];

    $(document).ready(function(){

        $('[data-toggle="tooltip]').tooltip();

        $.get($('input:hidden[name=products-data]').val(), null, function(value){
            products = value;

            $.get($('input:hidden[name=products-list]').val(), null, function(value){
                $(value).each(function(i, item){
                    addProduct(item.code, item.quantity);
                })
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    });

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



    function addProduct(productCode, amount){
        var row     = $(document.createElement('tr'));
        var code    = $(document.createElement('td'));
        var name    = $(document.createElement('td'));
        var qty     = $(document.createElement('td'));
        var qtyRow  = $(document.createElement('div'));
        var qtyCol1 = $(document.createElement('div'));
        var qtyCol2 = $(document.createElement('div'));
        var qtyInput= $(document.createElement('input'));
        var qtyBtn  = $(document.createElement('button'));
        var price   = $(document.createElement('td'));


        var product = products[productCode];
        var newPrice = amount * parseFloat(product['price']);
        code.html(product['code']);
        code.addClass('code');
        name.html(product['name']);
        name.addClass('name');

        qtyRow.addClass('row');
        qtyCol1.addClass('col-lg-4');
        qtyCol2.addClass('col-lg-2');

        qtyInput.addClass('form-control');
        qtyInput.val(amount);
        qtyInput.attr('min', 0);
        qtyInput.attr('type', 'number');
        qtyInput.attr('name', 'qty');
        qtyInput.css('width', 'number');
        qtyInput.addClass('qty-selector');

        qtyBtn.html('Supprimer');
        qtyBtn.addClass('btn btn-danger');
        qtyBtn.addClass('remove');
        qtyBtn.hide();


        qtyCol1.append(qtyInput);
        qtyCol2.append(qtyBtn);
        qtyRow.append(qtyCol1);
        qtyRow.append(qtyCol2);
        qty.append(qtyRow);
        qty.addClass('qty');

        price.html(newPrice.toFixed(2) + ' $');
        price.addClass('price');

        row.append(code);
        row.append(name);
        row.append(qty);
        row.append(price);

        $('table.product-table > tbody').append(row);

        recalculateTotal();

        $('input[name=product-search]').val('');
    }

    $('button[name=add]').click(function(e){
        e.preventDefault();

        addProduct($('input[name=product-search]').val().split('\\')[0].trim(), $('input[name=add-nb]').val());
    });

    $('input:submit[name=save]').click(function(e){
        e.preventDefault();

        var products = {};
        $('table.product-table tbody > tr').each(function(i, item){
            products[$(item).find('.code').html()] = $(item).find('.qty-selector').val();
        });

        var url = $(this).closest('form').attr('action');
        var client = $('input[name=name]').val();
        var delivered = $('input:checkbox[name=delivered]').prop('checked');
        var id = $('input:hidden[name=ID]').val();
        var note = $('textarea[name=note]').val();

        $.ajax({
            method: 'POST',
            url: url,
            data: { 'ID': id, 'client': client, 'delivered': delivered, 'note': note, 'products': JSON.stringify(products)}
        }).done(function(data) {
            $('input:hidden[name=ID]').val(data.ID);
            $('#feedback').html(data.feedback);
            window.scrollTo(0,document.body.scrollHeight);

            if (data.invoiceID != null) {
                var url = $('input:hidden[name=invoice-view-url]').val();
                url += '/' + data.invoiceID;
                $('#viewInvoice').attr('href', url);
            }
        });
    });

    $('input:submit[name=bill]').click(function(e) {
        e.preventDefault();

        var id = $('input:hidden[name=ID]').val();
        var url = $(this).attr('data-url');

        $.ajax({
            method: 'POST',
            url: url,
            data: { 'id': id}
        }).done(function(data) {
            $('#feedback').html(data.feedback);
            window.scrollTo(0,document.body.scrollHeight);
        });
    });

    $('input.typeahead').keypress(function (e) {
        if (e.which == 13) {
            e.preventDefault();
            $('.tt-suggestion:first-child').trigger('click');
        }
    });

    $('input.typeahead[name=product-search]').keypress(function (e) {
        if (e.which == 13) {
            e.preventDefault();
            addProduct();
        }
    });

    $('input:submit[name=delete]').click(function(e) {
        e.preventDefault();
        var code = $(this).attr('data-code');
        var url = $(this).attr('data-url');
        $('#modal-nb').html(code);
        $('#modal-delete').attr('data-url', url);
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
                setTimeout(function(){
                    window.location = data.redirect;
                }, 3000);
            } else {
                $('#modal-delete').prop('disabled', false);
            }

            $('#modal-feedback').html(data.feedback);
        });
    });

    $(document).on('change', 'input.qty-selector', function(e){
        var button = $(this).parents('td.qty').find('button.remove');
        if ($(this).val() == 0){
            button.slideDown({duration: 200});
        }
        else
        {
            button.slideUp({duration: 200});
        }

        var product = products[$(this).parents('tr').find('.code').html()];
        var newPrice = $(this).val() * parseFloat(product['price']);

        $(this).parents('tr').find('.price').html(newPrice.toFixed(2) + ' $');

        recalculateTotal();
    });

    $(document).on('click', 'button.remove', function(e){
        e.preventDefault();
        $(this).parents('tr').remove();
    });

    function recalculateTotal(){
        var totalAmount = $('#total-amount');

        var total = 0.0;
        $('.price').each(function(i, item){
            total += parseFloat($(item).html());
        });
        totalAmount.html(total.toFixed(2));

        recalculateTax();
        recalculateRefund();
        recalculateGrandTotal();
    }

    function recalculateTax(){
        var totalAmount = $('#total-wtax-amount');
        var qstAmount   = $('#qst-amount');
        var gstAmount   = $('#gst-amount');
        var gstRate = parseFloat($('input:hidden[name=GST]').val());
        var qstRate = parseFloat($('input:hidden[name=QST]').val());

        var total = 0.0;
        var qstTotal = 0.0;
        var gstTotal = 0.0;
        $('.price').each(function(i, item){
            var amount = parseFloat($(item).html());
            var gst = Math.round(amount * gstRate * 100) / 100;

            var qst = Math.round(amount * qstRate * 100) / 100;
            total += qst + gst + amount;
            qstTotal += qst;
            gstTotal += gst;
        });

        totalAmount.html(total.toFixed(2));
        qstAmount.html(qstTotal.toFixed(2));
        gstAmount.html(gstTotal.toFixed(2));
    }

    function recalculateRefund()
    {
        var totalAmount = $('#total-refund-amount');
        var depositTotal= $('#deposit-amount');
        var refundTotal = $('#refund-amount');

        var total   = 0.0;
        var deposit = 0.0;
        var refund  = 0.0;
        $('.code').each(function(i, item){
            var amount = products[$(item).html()].refund;
            var qty = $(item).parents('tr').find('.qty-selector').val();

            var sub = qty * amount;
            if (sub > 0)
            {
                deposit += sub;
            }
            else
            {
                refund += sub;
            }

            total += sub;
        });

        totalAmount.html(total.toFixed(2));
        depositTotal.html(deposit.toFixed(2));
        refundTotal.html(refund.toFixed(2));
    }

    function recalculateGrandTotal()
    {
        var totalAmount = $('#grand-total-amount');

        var amount = parseFloat($('#total-wtax-amount').html()) + parseFloat($('#total-refund-amount').html());
        totalAmount.html(amount.toFixed(2));
    }
</script>
