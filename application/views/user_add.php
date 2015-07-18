<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('AdminWeb/adminCreate', ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-lg-2">Courriel</label>
            <div class="col-lg-10">
                <?php echo Form::input('email', '', ['class' => 'form-control']);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-2">Mot de passe</label>
            <div class="col-lg-10">
                <?php echo Form::password('password', '', ['class' => 'form-control']);?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4">
                <?php echo Form::submit('create', 'Créer', ['class' => 'form-control btn btn-primary']);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10" id="feedback">
            </div>
        </div>
    </div>
</div>

<script>
    $('input:submit[name=create]').click(postData);
</script>