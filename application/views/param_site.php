<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('', ['class' => 'form-horizontal', 'role' => 'form']); ?>
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

</script>