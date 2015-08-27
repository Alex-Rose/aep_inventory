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
            <label class="control-label col-lg-2">Produits</label>
            <div class="col-lg-10">
                <div class="row" style="padding-top: 12px;">
                    <div class="col-lg-12">
                        <table class="table table-striped table-bordered table-hover product-table">
                            <thead>
                            <tr><th>Code</th>
                                <th>Produit</th>
                                <th style="width:100px">Quantité</th>
                                <th style="width:200px">Prix unitaire</th>
                                <th style="width:200px">Prix</th>
                                <th style="width:200px">Dépôt (total)</th></tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($invoice->items->find_all() as $item)
                                {
                                    echo '<tr>';
                                    echo '<td class="code">'.$item->code.'</td>';
                                    echo '<td class="name">'.$item->name.'</td>';
                                    echo '<td class="qty-txt">'.$item->quantity.'</td>';
                                    echo '<td class="amount">'.Helper_Number::format($item->price_unit).' $</td>';
                                    echo '<td class="amount">'.Helper_Number::format($item->price).' $</td>';
                                    echo '<td class="amount">'.Helper_Number::format($item->refund).' $</td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Sous-total</label>
            <div class="col-lg-10 form-text">
                <?php echo Helper_Number::format($invoice->price);?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo $invoice->tax_1_name;?></label>
            <div class="col-lg-10 form-text">
                <?php echo Helper_Number::format($invoice->tax_1_amount);?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo $invoice->tax_2_name;?></label>
            <div class="col-lg-10 form-text">
                <?php echo Helper_Number::format($invoice->tax_2_amount);?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Sous-total bières</label>
            <div class="col-lg-10 form-text">
                <?php echo Helper_Number::format($invoice->price_w_tax);?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"></label>
            <div class="col-lg-10 form-text">

            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-lg-2">Dépôt (vides)</label>
            <div class="col-lg-10 form-text">
                <?php echo Helper_Number::format($invoice->totalDeposit());?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Remboursement vides</label>
            <div class="col-lg-10 form-text">
                <?php  echo Helper_Number::format($invoice->totalRefund());?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total dépôts / vides</label>
            <div class="col-lg-10 form-text">
                <?php echo Helper_Number::format($invoice->totalDeposit() + $invoice->totalRefund());?> $
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"></label>
            <div class="col-lg-10 form-text">

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Montant Total</label>
            <div class="col-lg-2">
                <div class="input-group">
                    <?php echo Form::input('amount', Helper_Number::format($amount), ['class' => 'form-control', 'disabled' => 'disabled']);?>
                    <div class="input-group-addon">$</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Methode de paiement</label>
            <div class="col-lg-4">
                <?php echo Form::select('method', ['cash' => 'Argent comptant', 'impute' => 'Porter au compte'], $method, ['class' => 'form-control']);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Statut</label>
            <div class="col-lg-4 form-text">
                <?php
                    $tooltip = 'data-toggle="tooltip" data-placement="top"';
                    $style = 'style="padding: 5px 10px"';
                    if ($invoice->paymentID)
                    {
                        echo '<div class="label label-success" title="La commande est payée" '.$tooltip.' '.$style.'><i class="fa fa-check"></i> Payée</div>';
                    }
                    else
                    {
                        echo '<div class="label label-danger unpaid" title="La facture n\'est pas payée" '.$tooltip.' '.$style.'><i class="fa fa-dollar"></i> Impayé</div>';
                    }
                 ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-3">
                <?php echo Form::submit('save', 'Enregistrer', ['class' => 'form-control btn btn-primary']);?>
            </div>
            <?php if ($invoice->payment->loaded()){ ?>
                <div class="col-lg-3">
                    <?php echo Form::submit('delete', 'Supprimer le paiement', ['class' => 'form-control btn btn-danger', 'data-url' => URL::site('AdminInvoice/unpay/'.$invoice->pk())]);?>
                </div>
            <?php } ?>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10" id="feedback">
            </div>
        </div>

    </div>
</div>

<?php echo form::hidden('invoice-url', URL::site('invoice')); ?>

<script>
    var helper = new formHelper();
    helper.setCallback(function(data){
        var url = $('input[name=invoice-url]').val();
        if (data.success){
            $('#feedback').html(data.feedback);
            window.location.replace(url);
        }else{
            $('#feedback').html(data.feedback);
        }
    });

    $('input:submit[name=save]').click(helper.handler);

    $('input:submit[name=delete]').click(function(e){
        e.preventDefault();
        var url = $(this).attr('data-url');
        var redirect = $('input[name=invoice-url]').val();
        $.ajax({
            method: 'POST',
            url: url,
            data: {}
        }).done(function (data){
            if (data.success){
                $('#feedback').html(data.feedback);
                window.location.replace(redirect);
            }else{
                $('#feedback').html(data.feedback);
            }
        });
    });
</script>
