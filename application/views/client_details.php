<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <?php echo Form::open('AdminClient/save/'.$client->pk(), ['class' => 'form-horizontal', 'role' => 'form']); ?>
        <div class="form-group">
            <label class="control-label col-lg-2">Nom</label>
            <div class="col-lg-10">
                <div class="form-text">
                <?php echo $client->name;?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Adresse</label>
            <div class="col-lg-10">
                <div class="form-text">
                    <?php echo $client->address;?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Téléphone</label>
            <div class="col-lg-10">
                <div class="form-text">
                    <?php echo $client->phone;?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2">Courriel</label>
            <div class="col-lg-10">
                <div class="form-text">
                    <?php echo $client->email;?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-4" id="feedback">
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-dollar fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $client->balance;?> $</div>
                        <div>Solde du compte</div>
                    </div>
                </div>
            </div>
            <a href="#" class="details">
                <div class="panel-footer">
                    <span class="pull-left">Détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default" id="orders-panel">
            <div class="panel-heading">
                <i class="fa fa-tag fa-fw"></i> Historique de commande
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                    <thead>
                    <tr>
                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">État</th>
                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Sommaire</th>
                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Montant</th>
                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Consigne</th>
                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($client->orders->find_all() as $order)
                            {
                                echo '<tr>';
                                echo '<td>';
                                $billed = $order->invoice->loaded();
                                $paid = $order->invoice->loaded() && $order->invoice->paymentID != null;
                                $instock = $order->checkStocks();
                                $tooltip = 'data-toggle="tooltip" data-placement="top"';
                                if (!$billed)
                                {

                                    echo '<div class="label label-default" title="La commande n\'a pas été facturée" '.$tooltip.'><i class="fa fa-dollar"></i> Soumission</div>';
                                }
                                else if (!$paid)
                                {
                                    echo '<div class="label label-danger unpaid" title="La facture n\'est pas payée" '.$tooltip.'><i class="fa fa-dollar"></i> Impayé</div>';
                                }
                                else if (!$order->delivered && !$instock)
                                {
                                    echo '<div class="label label-success unpaid" title="La facture a été payée" '.$tooltip.'><i class="fa fa-dollar"></i> Payé</div>';
                                    echo '<br/>';
                                    echo '<div class="label label-warning" title="Certains produits ne sont pas disponibles dans l\'inventaire" '.$tooltip.'><i class="fa fa-shopping-cart"></i> Stock insuffisants</div>';
                                }
                            else if (!$order->delivered)
                                {
                                    echo '<div class="label label-success" title="La facture a été payée" '.$tooltip.'><i class="fa fa-dollar"></i> Payé</div>';
                                    echo '<br/>';
                                    echo '<div class="label label-primary" title="En attente de livraison" '.$tooltip.'><i class="fa fa-shopping-cart"></i> En attente</div>';
                                }
                                else
                                {
                                    echo '<div class="label label-success" title="La commande est payée et a été livrée" '.$tooltip.'><i class="fa fa-check"></i> Livré</div>';
                                }
                                echo '</td>';
                                echo '<td>';
                                foreach ($order->items->find_all() as $item)
                                {
                                    echo '<li>';
                                    echo '<span class="label label-info">'.$item->quantity.'</span> ';
                                    echo $item->product->name;
                                    echo '</li>';
                                }
                                echo '</td>';
                                $totals = $order->getTotals();
                                echo '<td>'.number_format(round($totals['total'], 2), 2).' $</td>';
                                echo '<td>'.number_format(round($totals['refund'], 2), 2).' $</td>';
                                echo '<td> '.$order->created.'</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel panel-default" id="transactions-panel">
            <div class="panel-heading">
                <i class="fa fa-history fa-fw"></i> Historique de transaction
            </div>
            <div class="panel-body">
<!--                <a href="#" class="list-group-item">-->
<!--                    <i class="fa fa-dollar fa-fw"></i> Paiement 192.95-->
<!--                    <span class="pull-right text-muted small"><em>2015-05-06</em>-->
<!--                    </span>-->
<!--                </a>-->
<!---->
<!--                <a href="#" class="list-group-item">-->
<!--                    <i class="fa fa-times fa-fw"></i> Remboursement 192.95-->
<!--                    <span class="pull-right text-muted small"><em>2015-05-06</em>-->
<!--                    </span>-->
<!--                </a>-->





                <?php
                    foreach ($client->payments->order_by('created', 'DESC')->find_all() as $paiement)
                    {
                        echo '<a href="#" class="list-group-item">';
                        echo '<i class="fa fa-dollar fa-fw"></i> Paiement '. $paiement->amount .' $';
                        echo '<span class="pull-right text-muted small"><em>'.date('d-m-Y', strtotime($paiement->created)).'</em>';
                        echo ' </span></a>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('.details').click(function(e){
        e.preventDefault();

        var panel = $('#transactions-panel, .unpaid');

        panel.removeClass('focus-animated');
        setTimeout(function() { panel.addClass('focus-animated'); }, 50);

    });
</script>
