<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('AdminProduct/save/'.$product->pk(), ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-lg-2">Nom</label>
            <div class="col-lg-10">
                <?php echo Form::input('name', $product->name, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Description</label>
            <div class="col-lg-10">
                <?php echo Form::input('description', $product->description, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Marque / distributeur</label>
            <div class="col-lg-10">
                <?php echo Form::input('brand', $product->brand, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Format</label>
            <div class="col-lg-10 auto-complete" id="format-search">
                <?php echo Form::input('format', $product->format, ['class' => 'form-control typeahead', 'data-url' => URL::site('AdminProduct/formats')]);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Format de groupe</label>
            <div class="col-lg-10 auto-complete" id="package-search">
                <?php echo Form::input('package_size', $product->package_size, ['class' => 'form-control typeahead', 'data-url' => URL::site('AdminProduct/packages')]);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Type de contenant</label>
            <div class="col-lg-10 auto-complete">
                <?php echo Form::input('type', $product->type, ['class' => 'form-control typeahead', 'data-url' => URL::site('AdminProduct/types')]);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Code de produit</label>
            <div class="col-lg-10">
                <?php echo Form::input('code', $product->code, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Prix coûtant</label>
            <div class="col-lg-10">
                <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <?php echo Form::input('cost', number_format($price->cost, 2), ['class' => 'form-control']);?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Prix de vente</label>
            <div class="col-lg-10">
                <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <?php echo Form::input('price', number_format($price->price, 2), ['class' => 'form-control']);?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Taxes</label>
            <div class="col-lg-2">
                <?php echo Form::select('taxes', ['GST' => 'TPS', 'QST' => 'TVQ', 'BOTH' => 'TPS + TVQ'], $price->taxes, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Consigne Québec</label>
            <div class="col-lg-10">
                <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <?php echo Form::input('refund', number_format($price->refund, 2), ['class' => 'form-control']);?>
                </div>
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

<script>

    $('.auto-complete').each(function(i, item){
        var input = $(item).find('.typeahead');
        $.get($(input).attr('data-url'), null, function(value){
            var formats = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                // url points to a json file that contains an array of country names, see
                // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
                local: value
            });

            $(input).typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'formats',
                    source: formats
                });
        });
    });

    $('input:submit[name=save]').click(postData);

</script>
