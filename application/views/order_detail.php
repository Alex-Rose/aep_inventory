<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php echo Form::open('AdminOrder/save', ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-lg-2">Client</label>
            <div class="col-lg-10" id="client-search">
                <div class="form-text"><?php echo $order->client->name . ' - ' . $order->client->email; ?></div>
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
                                    foreach ($order->items->find_all() as $item)
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

        <?php $totals = $order->getTotals();?>
        <div class="form-group">
            <label class="control-label col-lg-2">Sous total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-amount"><?php echo number_format($totals['price'], 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Taxes</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-tax-amount"><?php echo number_format(round($totals['gst'] + $totals['qst'], 2),2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Consigne</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-refund-amount"><?php echo number_format($totals['refund'], 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Total</label>
            <div class="col-lg-10">
                <div class="form-text"><span id="total-wtax-amount"><?php echo number_format(round($totals['total'], 2), 2);?></span> $</div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Livrée</label>
            <div class="col-lg-1">
                <?php echo Form::checkbox('delivered', null, (bool)$order->delivered, ['class' => 'form-control', 'style' => 'width:34px', 'disabled' => 'disabled']);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4">
                <?php if (isset($comment)) echo $comment; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
                <?php
                    if (!$order->isPaid())
                    {
                        echo '<div class="col-lg-4">';
                        echo HTML::anchor('order/edit/'.$order->pk(), 'Modifider la commande', ['class' => 'btn btn-primary btn-block']);
                        echo '</div>';
                    }
                ?>
                <div class="col-lg-4">
                    <?php
                        if (!$order->invoice->loaded())
                        {
                            echo Form::submit('bill', 'Facturer', ['class' => 'form-control btn btn-success', 'data-url' => URL::site('AdminOrder/bill')]);
                        }
                        else
                        {
                            echo HTML::anchor('invoice/view/'.$order->invoice->pk(), 'Voir la facture', ['class' => 'form-control btn btn-default']);
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4" id="feedback">
            </div>
        </div>
    </div>
</div>

<?php echo Form::hidden('ID', $order->pk());?>

<script>
    $('input:submit[name=bill]').click(function(e) {
        e.preventDefault();

        var id = $('input:hidden[name=ID]').val();
        var url = $(this).attr('data-url');

        $.ajax({
            method: 'POST',
            url: url,
            data: { 'id': id}
        }).done(function(data) {
            $('#feedback').html(data.feedback);
        });
    });

</script>
