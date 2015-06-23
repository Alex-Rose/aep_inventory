<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title;?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
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
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-tag fa-fw"></i> Historique de commande
            </div>
            <div class="panel-body">
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel panel-default">
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

</script>
