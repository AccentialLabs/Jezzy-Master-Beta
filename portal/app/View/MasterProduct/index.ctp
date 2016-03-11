<?php

echo $this->Html->css('View/MasterProduct', array('inline' => false)); 
echo $this->Html->script('View/MasterProduct', array('inline' => false));
?>
<br/>
<div>
    <h1 class="page-header letterSize"><span>Ofertas</span></h1>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="pull-right">
            <a href="/jezzy-master/portal/masterInsertOffer"><button class="btn btn-default pull-right" type="button" >Nova Oferta   <span class="glyphicon glyphicon-plus"></span></button></a>
            <button class="btn btn-default pull-right" type="button" id="openSpreadsheet" data-toggle="modal" data-target="#myModal">Importar planilha de produtos   <span class="glyphicon glyphicon-floppy-save"></span></button>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#section0">Minhas Ofertas</a></li>
        <li><a data-toggle="tab" href="#sectionA">Todas Ofertas</a></li>
        <li><a data-toggle="tab" href="#sectionB">Ofertas Ativas</a></li>
        <li><a data-toggle="tab" href="#sectionC">Ofertas Inativas</a></li>
    </ul>
    <div class="tab-content">

        <div id="section0" class="tab-pane fade in active">
            <br/>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="input-group pull-left" >
                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span> </span>
                        <input type="text" id="txtBusca" placeholder="Pesquise por Nome da Oferta, Empresa, Data..." class="form-control"/>
                    </div>
                </div>
            </div>
            <br/><br/>
            <table class="table table-hover" id="myOffers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITULO</th>
                        <th>VALOR</th>
                        <th>INICIO</th>
                        <th>FINAL</th>
                        <th>STATUS</th>
                        <th>AVALIAÇÃO</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($myOffers as $offer){
                            $numeroVotantes = $offer['Statistics'][0]['votantes'];
                            if (!empty($offer['Statistics'][0]['votantes'])) {
                                $nota = $offer['Statistics'][0]['evaluation'] / $offer['Statistics'][0]['votantes'];
                            } else {
                                $nota = 0;
                            }
                            $estrelas = $this->Html->image('jezzy_icons/' . $nota . '.png', array('class' => 'starOffer', 'title' => $nota));
                        ?>
                    <tr>
                        <td><?php echo $offer['Offer']['id'];?></td>
                        <td><?php echo $offer['Offer']['title'];?></td>
                        <td><?php echo str_replace(".", ",", $offer['Offer']['value']);?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['begins_at']));?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['ends_at']));?></td>
                        <td><?php 
                             if ($offer['Offer']['status'] == 'INACTIVE') {
                             echo "INATIVA";
                        
                            } else {
                                echo "ATIVA";
                          
                            }
                        ?></td>
                        <td><?php echo $estrelas; ?></td>
                        <td>
                            <?php 
                           if ($offer['Offer']['status'] == 'INACTIVE') {
                               echo '<span class="glyphicon glyphicon-play active-icon"></span>';
                            } else {
                                echo '<span class="glyphicon glyphicon-pause inactive-icon"></span>';
                            } ?>
                        </td>
                        <td>
                            <span class="glyphicon glyphicon-pencil" alt="Desativar oferta"></span>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>

        <div id="sectionA" class="tab-pane fade">
            <br/>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="input-group pull-left" >
                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span> </span>
                        <input type="text" id="txtBusca" placeholder="Pesquise por Nome da Oferta, Empresa, Data..." class="form-control"/>
                    </div>
                </div>
                <div class="col-md-4 pull-right">
                    <button class="btn btn-default pull-right" type="button" >--</button>
                </div>
            </div>
            <br/><br/>
            <table class="table table-hover" id="allOffers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITULO</th>
                        <th>VALOR</th>
                        <th>INICIO</th>
                        <th>FINAL</th>
                        <th>STATUS</th>
                        <th>EMPRESA</th>
                        <th>AVALIAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($offers as $offer){
                         if ($offer['Offer']['status'] == 'INACTIVE') {
                                $iconPlayPause = '<span class="glyphicon glyphicon-play active-icon"></span>';
                            } else {
                                $iconPlayPause = '<span class="glyphicon glyphicon-pause inactive-icon"></span>';
                            }
                            
                            $numeroVotantes = $offer['Statistics'][0]['votantes'];
                            if (!empty($offer['Statistics'][0]['votantes'])) {
                                $nota = $offer['Statistics'][0]['evaluation'] / $offer['Statistics'][0]['votantes'];
                            } else {
                                $nota = 0;
                            }
                            $estrelas = $this->Html->image('jezzy_icons/' . $nota . '.png', array('class' => 'starOffer', 'title' => $nota));
                        ?>
                    <tr>
                        <td><?php echo $offer['Offer']['id'];?></td>
                        <td><?php echo $offer['Offer']['title'];?></td>
                        <td><?php echo str_replace(".", ",", $offer['Offer']['value']);?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['begins_at']));?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['ends_at']));?></td>
                        <td><?php echo $iconPlayPause; ?></td>
                        <td><small><?php echo $offer['Company']['id'].'</small><br/>'. $offer['Company']['fancy_name'];?></td>
                        <td><?php echo $estrelas; ?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>

        <!-- OFERTAS ATIVAS -->
        <div id="sectionB" class="tab-pane fade">
            <br/>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="input-group pull-left" >
                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span> </span>
                        <input type="text" id="txtBusca" placeholder="Pesquise por Nome da Oferta, Empresa, Data..." class="form-control"/>
                    </div>
                </div>
                <div class="col-md-4 pull-right">
                    <button class="btn btn-default pull-right" type="button" >--</button>
                </div>
            </div>
            <br/><br/>
            <table class="table table-hover" id="activeOffers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITULO</th>
                        <th>VALOR</th>
                        <th>INICIO</th>
                        <th>FINAL</th>
                        <th>STATUS</th>
                        <th>EMPRESA</th>
                        <th>AVALIAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($offers as $offer){
                        if($offer['Offer']['status'] == 'ACTIVE'){
                         if ($offer['Offer']['status'] == 'INACTIVE') {
                                $iconPlayPause = '<span class="glyphicon glyphicon-play active-icon"></span>';
                            } else {
                                $iconPlayPause = '<span class="glyphicon glyphicon-pause inactive-icon"></span>';
                            }
                            
                            $numeroVotantes = $offer['Statistics'][0]['votantes'];
                            if (!empty($offer['Statistics'][0]['votantes'])) {
                                $nota = $offer['Statistics'][0]['evaluation'] / $offer['Statistics'][0]['votantes'];
                            } else {
                                $nota = 0;
                            }
                            $estrelas = $this->Html->image('jezzy_icons/' . $nota . '.png', array('class' => 'starOffer', 'title' => $nota));
                        ?>
                    <tr>
                        <td><?php echo $offer['Offer']['id'];?></td>
                        <td><?php echo $offer['Offer']['title'];?></td>
                        <td><?php echo str_replace(".", ",", $offer['Offer']['value']);?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['begins_at']));?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['ends_at']));?></td>
                        <td><?php echo $iconPlayPause; ?></td>
                        <td><small><?php echo $offer['Company']['id'].'</small><br/>'. $offer['Company']['fancy_name'];?></td>
                        <td><?php echo $estrelas; ?></td>
                    </tr>
                    <?php }
                    
                            }?>
                </tbody>
            </table>
        </div>

        <!-- OFERTAS ATIVAS -->
        <div id="sectionC" class="tab-pane fade">
            <br/>
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="input-group pull-left" >
                        <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span> </span>
                        <input type="text" id="txtBusca" placeholder="Pesquise por Nome da Oferta, Empresa, Data..." class="form-control"/>
                    </div>
                </div>
                <div class="col-md-4 pull-right">
                    <button class="btn btn-default pull-right" type="button" >--</button>
                </div>
            </div>
            <br/><br/>
            <table class="table table-hover" id="inactiveOffers">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITULO</th>
                        <th>VALOR</th>
                        <th>INICIO</th>
                        <th>FINAL</th>
                        <th>STATUS</th>
                        <th>EMPRESA</th>
                        <th>AVALIAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($offers as $offer){
                        if($offer['Offer']['status'] == 'INACTIVE'){
                         if ($offer['Offer']['status'] == 'INACTIVE') {
                                $iconPlayPause = '<span class="glyphicon glyphicon-play active-icon"></span>';
                            } else {
                                $iconPlayPause = '<span class="glyphicon glyphicon-pause inactive-icon"></span>';
                            }
                            
                            $numeroVotantes = $offer['Statistics'][0]['votantes'];
                            if (!empty($offer['Statistics'][0]['votantes'])) {
                                $nota = $offer['Statistics'][0]['evaluation'] / $offer['Statistics'][0]['votantes'];
                            } else {
                                $nota = 0;
                            }
                            $estrelas = $this->Html->image('jezzy_icons/' . $nota . '.png', array('class' => 'starOffer', 'title' => $nota));
                        ?>
                    <tr>
                        <td><?php echo $offer['Offer']['id'];?></td>
                        <td><?php echo $offer['Offer']['title'];?></td>
                        <td><?php echo str_replace(".", ",", $offer['Offer']['value']);?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['begins_at']));?></td>
                        <td><?php echo date('d/m/Y', strtotime($offer['Offer']['ends_at']));?></td>
                        <td><?php echo $iconPlayPause; ?></td>
                        <td><small><?php echo $offer['Company']['id'].'</small><br/>'. $offer['Company']['fancy_name'];?></td>
                        <td><?php echo $estrelas; ?></td>
                    </tr>
                    <?php }
                    
                            }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL PLANILHA -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4  id="myModalLabel">Importar planilha de Produtos</h4>
            </div>
            <form action="masterProduct/sendFileXls" method="post" enctype="multipart/form-data">
                <div class="modal-body" id="recebe-offer-detail">

                    <input type="file" id="xlsFile" name="xlsFile">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
