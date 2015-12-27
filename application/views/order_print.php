<div class="row">
    <div class="col-xs-12">
        <h4><?php echo $title;?></h4>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php echo Form::open('', ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-xs-2">Numéro de commande</label>
            <div class="col-xs-6 client">
                <div># <?php echo $order->pk(); ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Date</label>
            <div class="col-xs-10 client">
                <div><?php echo Helper_Number::date($order->created); ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Nom</label>
            <div class="col-xs-10 client">
                <div><?php echo $order->client->name . ' - ' . $order->client->email; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Courriel</label>
            <div class="col-xs-10 client">
                <div><?php echo $order->client->email; ?></div>
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
                                foreach ($order->items->find_all() as $item)
                                {
                                    $product = $item->product;

                                    echo '<tr>';
                                    echo '<td class="code">'.$product->code.'</td>';
                                    echo '<td class="name">'.$product->name.'</td>';
                                    echo '<td class="qty-txt">'.$item->quantity.'</td>';
                                    echo '<td class="amount">'.Helper_Number::format($product->price->price).' $</td>';
                                    echo '<td class="amount">'.Helper_Number::format($item->quantity * $product->price->price).' $</td>';
                                    echo '<td class="amount">'.Helper_Number::format($item->quantity * $product->price->refund).' $</td>';
                                    echo '</tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php $totals = $order->getTotals(); ?>

        <div class="form-group">
            <label class="control-label col-xs-1">Note</label>
            <div class="col-xs-7">
                <?php echo nl2br($order->note);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Sous-total</label>
            <div class="col-xs-2">
                <div><span id="total-amount"><?php echo Helper_Number::format($totals['price']);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7"><?php echo Model_Parameter::getValue('GST_NAME_SHORT');?></label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($totals['gst']);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7"><?php echo Model_Parameter::getValue('QST_NAME_SHORT');?></label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($totals['qst']);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Sous-total bières</label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($totals['priceWTax']);?></span> $</div>
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
                <div><span><?php echo Helper_Number::format($totals['deposit']);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Remboursement vides</label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($totals['deposit'] - $totals['totalRefund']);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-3 col-xs-offset-7">Total dépôts / vides</label>
            <div class="col-xs-2">
                <div><span><?php echo Helper_Number::format($totals['totalRefund']);?></span> $</div>
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
                <div><strong><span id="total-wtax-amount"><?php echo Helper_Number::format($totals['total']);?></span> $</strong></div>
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
