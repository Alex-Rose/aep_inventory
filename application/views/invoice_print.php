<div class="row">
    <div class="col-xs-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php echo Form::open('', ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-xs-4">Nom</label>
            <div class="col-xs-8" id="client-search">
                <div class="form-text"><?php echo $invoice->client->name . ' - ' . $invoice->client->email; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-4">Courriel</label>
            <div class="col-xs-8" id="client-search">
                <div class="form-text"><?php echo $invoice->client->email; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-4">Adresse</label>
            <div class="col-xs-8" id="client-search">
                <div class="form-text"><?php echo $invoice->client->address; ?></div>
            </div>
        </div>

        <div class="form-group">

            <div class="col-xs-12">
                <div class="row" style="padding-top: 12px;">
                    <div class="col-xs-12">
                        <table class="table table-striped table-bordered table-hover product-table">
                            <thead>
                            <tr><th style="width:12%">Code</th>
                                <th style="width:64%">Produit</th>
                                <th style="width:12%">Quantité</th>
                                <th style="width:12%">Prix</th></tr>
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
            <label class="control-label col-xs-4">Sous total</label>
            <div class="col-xs-8">
                <div class="form-text"><span id="total-amount"><?php echo number_format($invoice->price, 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-4"><?php echo $invoice->tax_1_name;?></label>
            <div class="col-xs-8">
                <div class="form-text"><span id="total-tax-amount"><?php echo number_format(round($invoice->tax_1_amount, 2),2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-4"><?php echo $invoice->tax_2_name;?></label>
            <div class="col-xs-8">
                <div class="form-text"><span id="total-tax-amount"><?php echo number_format(round($invoice->tax_2_amount, 2),2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-4">Consigne</label>
            <div class="col-xs-8">
                <div class="form-text"><span id="total-refund-amount"><?php echo number_format($invoice->refund, 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-4">Total</label>
            <div class="col-xs-8">
                <div class="form-text"><strong><span id="total-wtax-amount"><?php echo number_format(round($invoice->total, 2), 2);?></span> $</strong></div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        window.print();
    });
</script>
