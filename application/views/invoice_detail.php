<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('', ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-lg-2">Client</label>
            <div class="col-lg-10">
                <div class="form-text"><?php echo $invoice->client->name . ' - ' . $invoice->client->email; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Date</label>
            <div class="col-lg-10">
                <div class="form-text"><?php echo $invoice->created; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Facture émise par</label>
            <div class="col-lg-10">
                <div class="form-text"><?php echo $invoice->user->name; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Commande</label>
            <div class="col-lg-10" id="client-search">
                <div class="form-text"><a href="<?php echo URL::site('order/view/'.$invoice->order->pk())?>"># <?php echo $invoice->order->pk() ?></a></div>
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
            <label class="control-label col-lg-2">Notes</label>
            <div class="col-lg-10">
                <div class="form-text">
                    <?php echo nl2br($invoice->note);?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"></label>
            <div class="col-lg-10">

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Sous-total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-amount"><?php echo Helper_Number::format($invoice->price);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo $invoice->tax_1_name;?></label>
            <div class="col-lg-10">
                <div class="form-text"><span><?php echo Helper_Number::format($invoice->tax_1_amount);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"><?php echo $invoice->tax_2_name;?></label>
            <div class="col-lg-10">
                <div class="form-text"><span><?php echo Helper_Number::format($invoice->tax_2_amount);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Sous-total bières</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-tax-amount"><?php echo Helper_Number::format($invoice->price_w_tax);?></span> $</div>
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
                <div class="form-text"><span><?php echo Helper_Number::format($invoice->totalDeposit());?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Remboursement vides</label>
            <div class="col-lg-10">
                <div class="form-text"><span><?php echo Helper_Number::format($invoice->totalRefund());?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total dépôts / vides</label>
            <div class="col-lg-10">
                <div class="form-text"><span><?php echo Helper_Number::format($invoice->refund);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2"></label>
            <div class="col-lg-10">

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-wtax-amount"><?php echo Helper_Number::format($invoice->total);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Méthode de paiement</label>
            <div class="col-lg-1">
                <div class="form-text"><?php echo ($invoice->payment->loaded() ? ($invoice->payment->method == 'cash' ? 'Argent comptant' : 'Imputer') : '');?></div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-2">
                <a href="<?php echo URL::site('invoice/print/'.$invoice->pk());?>" target="_blank" class="form-control btn btn-success">Imprimer</a>
            </div>
            <div class="col-lg-2">
                <a href="<?php echo URL::site('invoice/pay/'.$invoice->pk());?>" class="form-control btn btn-primary">Paiement</a>
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
