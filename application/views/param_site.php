<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('AdminParameters/save', ['class' => 'form-horizontal', 'role' => 'form']); ?>

        <div class="form-group">
            <label class="control-label col-lg-2">Nom de la taxe provinciale</label>
            <div class="col-lg-10">
                <?php echo Form::input('qstName', $qstName, ['class' => 'form-control', 'data-url' => URL::site('AdminParameters/save/QST_NAME')]);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Abbréviation de la taxe provinciale</label>
            <div class="col-lg-10">
                <?php echo Form::input('qstNameShort', $qstNameShort, ['class' => 'form-control', 'data-url' => URL::site('AdminParameters/save/QST_NAME_SHORT')]);?>
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-lg-2">Taxe Provinciale</label>
            <div class="col-lg-10">
                <div class="input-group">
                    <div class="input-group-addon">%</div>
                    <?php echo Form::input('qst', $qstRate, ['class' => 'form-control', 'data-url' => URL::site('AdminParameters/save/QST_RATE')]);?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Nom de la taxe fédérale</label>
            <div class="col-lg-10">
                <?php echo Form::input('gstName', $gstName, ['class' => 'form-control', 'data-url' => URL::site('AdminParameters/save/GST_NAME')]);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Abbréviation de la taxe fédérale</label>
            <div class="col-lg-10">
                <?php echo Form::input('gstNameShort', $gstNameShort, ['class' => 'form-control', 'data-url' => URL::site('AdminParameters/save/GST_NAME_SHORT')]);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Taxe Fédérale</label>
            <div class="col-lg-10">
                <div class="input-group">
                    <div class="input-group-addon">%</div>
                    <?php echo Form::input('gst', $gstRate, ['class' => 'form-control', 'data-url' => URL::site('AdminParameters/save/GST_RATE')]);?>
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
    $('input:submit[name=save]').click(postData);
</script>
