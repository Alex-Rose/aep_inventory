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
            <div class="col-lg-10" id="client-search">
                <div class="form-text"><?php echo $invoice->client->name . ' - ' . $invoice->client->email; ?></div>
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
                                <th style="width:200px">Quantité</th>
                                <th style="width:200px">Prix</th></tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($invoice->items->find_all() as $item)
                                    {
                                        echo '<tr>';
                                        echo '<td class="code">'.$item->product->code.'</td>';
                                        echo '<td class="name">'.$item->product->name.'</td>';
                                        echo '<td class="name">'.$item->quantity.'</td>';
                                        echo '<td class="name">'.$item->product->price->price.' $</td>';
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
            <label class="control-label col-lg-2">Sous total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-amount"><?php echo number_format($invoice->price, 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Taxes</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-tax-amount"><?php echo number_format(round($invoice->tax_1_amount + $invoice->tax_1_amount, 2),2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Consigne</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-refund-amount"><?php echo number_format($invoice->refund, 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-wtax-amount"><?php echo number_format(round($invoice->total, 2), 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Livrée</label>
            <div class="col-lg-1">
                <?php echo Form::checkbox('delivered', null, (bool)$invoice->order->delivered, ['class' => 'form-control', 'style' => 'width:34px', 'disabled' => 'disabled']);?>
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
