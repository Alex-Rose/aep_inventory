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
            <div class="col-lg-10">
                <?php echo Form::input('format', $product->format, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Format de groupe</label>
            <div class="col-lg-10">
                <?php echo Form::input('package_size', $product->package_size, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Type de contenant</label>
            <div class="col-lg-10">
                <?php echo Form::input('type', $product->type, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Code de produit</label>
            <div class="col-lg-10">
                <?php echo Form::input('code', $product->code, ['class' => 'form-control']);?>
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
    $('input:submit[name=save]').click(postData);

    function postData(e){
        e.preventDefault();

        var actions = [];
        var post = {};
        var form = $(this).closest('form');
        var items = form.find('input:not(input:submit)');

        for (var i = 0; i < items.length; i++)
        {
            post[$(items[i]).attr('name')] = $(items[i]).val();
        }

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: post
        }).done(function(data){
            $('#feedback').html(data.feedback);
        });

    }

</script>