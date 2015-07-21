<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('AdminInvoice/pay/'.$invoice->pk(), ['class' => 'form-horizontal', 'role' => 'form']); ?>

        <div class="form-group">
            <label class="control-label col-lg-2">Client</label>
            <div class="col-lg-10 form-text">
                <strong>
                    <?php echo $invoice->client->name;?>
                </strong>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Prix net</label>
            <div class="col-lg-10 form-text">
                <?php echo $invoice->price;?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo $invoice->tax_1_name;?></label>
            <div class="col-lg-10 form-text">
                <?php echo $invoice->tax_1_amount;?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo $invoice->tax_2_name;?></label>
            <div class="col-lg-10 form-text">
                <?php echo $invoice->tax_2_amount;?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Montant total</label>
            <div class="col-lg-2">
                <div class="input-group">
                    <?php echo Form::input('amount', $invoice->total, ['class' => 'form-control', 'disabled' => 'disabled']);?>
                    <div class="input-group-addon">$</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Methode de paiement</label>
            <div class="col-lg-4">
                <?php echo Form::select('method', ['cash' => 'Argent comptant', 'impute' => 'Imputer'], 0, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4">
                <?php echo Form::submit('save', 'Enregistrer', ['class' => 'form-control btn btn-primary']);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10" id="feedback">
            </div>
        </div>

    </div>
</div>

<script>
    $('input:submit[name=save]').click(postData);

</script>
