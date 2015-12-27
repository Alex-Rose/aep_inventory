<div class="row">
    <div class="col-xs-12">
        <h4><?php echo $title;?></h4>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php echo Form::open('', ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-xs-2">Facture</label>
            <div class="col-xs-6 client">
                <div># <?php echo $invoice->code; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Date</label>
            <div class="col-xs-10 client">
                <div><?php echo $invoice->created; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Nom</label>
            <div class="col-xs-10 client">
                <div><?php echo $invoice->client->name . ' - ' . $invoice->client->email; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Courriel</label>
            <div class="col-xs-10 client">
                <div><?php echo $invoice->client->email; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Adresse</label>
            <div class="col-xs-10 client">
                <div><?php echo $invoice->client->address; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Facture émise par</label>
            <div class="col-xs-10 client">
                <div><?php echo $invoice->user->name; ?></div>
            </div>
        </div>

        <div class="form-group">

            <div class="col-xs-12">
                <div class="row" style="padding-top: 12px;">
                    <div class="col-xs-12">
                        <table class="table table-striped table-bordered table-hover product-table">
                            <thead>
                            <tr><th style="width:12%">Code</th>
                                <th style="width:44%">Produit</th>
                                <th style="width:8%">Quantité</th>
                                <th style="width:12%">Prix unitaire</th>
                                <th style="width:12%">Prix</th>
                                <th style="width:12%">Dépôt (total)</th></tr>
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
            <label class="control-label col-xs-1">Note</label>
            <div class="col-xs-7">
                <?php echo nl2br($invoice->note);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-4">
                <div class="h4"><?php echo ($invoice->payment->loaded() ? ($invoice->payment->method == 'cash' ? 'Argent comptant' : 'Imputer') : 'Paiement :');?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Sous-total</label>
            <div class="col-xs-2">
                <div><span id="total-amount"><?php echo Helper_Number::format($invoice->price);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7"><?php echo $invoice->tax_1_name;?></label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($invoice->tax_1_amount);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7"><?php echo $invoice->tax_2_name;?></label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($invoice->tax_2_amount);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Sous-total bières</label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($invoice->price_w_tax);?></span> $</div>
            </div>
        </div>

        <div class="form-group spacer">
            <label class="control-label col-xs-4"></label>
            <div class="col-xs-2">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Dépôt</label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($invoice->totalDeposit());?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Remboursement vides</label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($invoice->totalRefund());?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Total dépôts / vides</label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($invoice->refund);?></span> $</div>
            </div>
        </div>

        <div class="form-group spacer">
            <label class="control-label col-xs-4"></label>
            <div class="col-xs-2">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Total</label>
            <div class="col-xs-2">
                <div><strong><span id="total-wtax-amount"><?php echo Helper_Number::format($invoice->total);?></span> $</strong></div>
            </div>
        </div>

        <div class="form-group spacer">
            <label class="control-label col-xs-4"></label>
            <div class="col-xs-2">
            </div>
        </div>

    </div>
</div>


<script>
    $(document).ready(function(){
        window.print();
    });
</script>
