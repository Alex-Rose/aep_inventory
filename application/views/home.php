 <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tableau de bord</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ORM::factory('Client')->count_all();?></div>
                                    <div>Clients</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo URL::site('client/list');?>">
                            <div class="panel-footer">
                                <span class="pull-left">Voir les clients</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ORM::factory('Order')->where('delivered', '=', false)->count_all();?></div>
                                    <div>Commandes en attente</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo URL::site('order');?>">
                            <div class="panel-footer">
                                <span class="pull-left">Voir les commandes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-edit fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ORM::factory('Invoice')->where('paymentID', 'IS', null)->count_all();?></div>
                                    <div>Factures impayées</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo URL::site('invoice');?>">
                            <div class="panel-footer">
                                <span class="pull-left">Voir les factures</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ORM::factory('Inventory')->where('quantity', '<=', 0)->count_all();?></div>
                                    <div>Rupture de stocks</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo URL::site('inventory');?>">
                            <div class="panel-footer">
                                <span class="pull-left">Voir les produits</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Commandes récentes
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Client</th>
                                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;">Sommaire</th>
                                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Montant</th>
                                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Livrée</th>
                                        <th aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;">Date créée</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $orders = ORM::factory('Order')->where('created', '>=', date('Y-m-d H:i:s', strtotime('last monday')))->find_all();
                                        foreach ($orders as $order)
                                        {
                                            echo '<tr>';
                                            echo '<td><a href="'.URL::site('order/edit/'.$order->pk()).'"><i class="fa fa-edit"></i></a> <a href="'.URL::site('order/view/'.$order->pk()).'">'.$order->client->name.'</a></td>';
                                            echo '<td><ul class="no_deco">';
                                            foreach ($order->items->find_all() as $item)
                                            {
                                                echo '<li>';
                                                echo '<span class="label label-info">'.$item->quantity.'</span> ';
                                                echo $item->product->name;
                                                echo '</li>';
                                            }

                                            echo '</ul></td>';

                                            echo '<td>'.number_format(round($order->getTotals()['total'], 2), 2).' $</td>';
                                            echo '<td>'.Form::checkbox('delivered', '', (bool)$order->delivered, ['disabled' => 'disabled']).'</td>';
                                            echo '<td> '.date('d-m-Y', strtotime($order->created)).'</td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel -->

                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-star-o fa-fw"></i> Accès rapide
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12">

                                <?php echo HTML::anchor('order/create', 'Créer une commande', ['class' => 'btn btn-info btn-xl btn-block']);?>
                                <?php echo HTML::anchor('client/list', 'Liste des clients', ['class' => 'btn btn-info btn-xl btn-block']);?>
                                <?php echo HTML::anchor('inventory', 'Voir l\'inventaire', ['class' => 'btn btn-default btn-xl btn-block']);?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
