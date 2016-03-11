<?php

echo $this->Html->css('View/MasterConfig', array('inline' => false)); 
    echo $this->Html->script('View/MasterConfig', array('inline' => false));
?>
<br/>
<h1 class="page-header" id="code">Configurações</h1>

<div id="">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#section0">Perfil de Usuários</a></li>
        <li><a data-toggle="tab" href="#sectionB">Cargos e Permissões</a></li>
    </ul>
    <div class="tab-content">

        <div id="section0" class="tab-pane fade in active">
            <br />
            <div class="col-md-4">
                <div class="input-group pull-left" >
                    <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span> </span>
                    <input type="text" id="txtBusca" placeholder="Pesquise por Nome, Cargo, Status..." class="form-control"/>
                </div>
            </div>
            <div class="col-md-4 pull-right">
                <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal">Cadastrar usuário</button>
            </div>

            <br />
            <?php   if($secondariesUsers){ ?>
            <table class="table table-hover" id="allSecondaryUsers">
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>EMAIL</th>
                        <th>CARGO</th>
                        <th>STATUS</th>
                        <th class="td-icon">EDITAR</th>
                        <th class="td-icon"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                  $index = 0;
                    foreach ($secondariesUsers as $secondary) { ?>
                    <tr>
                        <td><?php echo $secondary['secondary_masterusers']['name']; ?></td>
                        <td><?php echo $secondary['secondary_masterusers']['email']; ?></td>
                        <td><?php echo $secondary['secondary_masterusers_types']['name']; ?></td>
                        <td id='status-<?php  echo $secondary['secondary_masterusers']['id'];?>'>
                            <?php if($secondary['secondary_masterusers']['status'] == 'ACTIVE'){ ?>
                            <span class='label label-success'>Ativo</span>
                            <?php }else{ ?>
                            <span class='label label-danger'>Inativo</span>
                            <?php }?>
                        </td>
                        <td class="td-icon"><span class="glyphicon glyphicon-pencil glyph-button table-icon" onclick="editSecondaryUser(<?php echo $index;?>)"></span></td>
                        <td class="td-icon" id='button-<?php  echo $secondary['secondary_masterusers']['id'];?>'>
                                <?php if($secondary['secondary_masterusers']['status'] == 'ACTIVE'){ ?>
                            <span class="glyphicon glyphicon-remove-sign table-icon" onclick='removeSecondaryUser(<?php  echo $secondary['secondary_masterusers']['id'];?>)'></span>
                            <?php }else{ ?>
                            <span class="glyphicon glyphicon-play table-icon reative" onlick='reativeSecondaryUser(<?php  echo $secondary['secondary_masterusers']['id'];?>)'></span>
                            <?php }?>
                        </td>
                    </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
            <?php }else{
                        
            echo "<span class=''>Nenhum usuário secundário criado até o momento.</span>";}
                    ?>
        </div>

        <div id="sectionB" class="tab-pane fade">
            <br/>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="col-md-4">CARGO</th>
                        <th class="col-md-4">ATRIBUIÇÃO</th>
                        <th class="col-md-4">DESCRIÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($secondsMasterUsersTypes as $type) { ?>
                    <tr>
                        <td><strong><?php echo $type['secondary_masterusers_types']['name']; ?></strong></td>
                        <td><?php 
                        switch ($type['secondary_masterusers_types']['id']){
                            case 3:
                                echo "Acesso total";
                                break;
                            case 4:
                                echo "Ofertas, Entregas e NFe";
                                break;
                            case 5:
                                echo "Contas e Faturamento";
                                break;
                        }
                        ?></td>
                        <td><small><?php echo $type['secondary_masterusers_types']['description']; ?></small></td>
                    </tr>
                    <?php    
                        } 
                    ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- M O D A L  -->
<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" id="modelContent">
            <div class="modal-body">
                <div class="form-horizontal" id="form-insert-edit">
                    <div class="form-group marginTop10">
                        <label for="inputEmail3" class="col-sm-2 control-label">Nome *</label>
                        <div class="col-sm-6">
                            <input name="data[secundary_user][name]" type="text" class="form-control" id="secundary_user_name" value="<?php echo $user['secondary_masterusers']['name']; ?>" placeholder="Nome" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">E-mail *</label>
                        <div class="col-sm-6">
                            <input name="data[secundary_user][email]" type="email" class="form-control"  id="secundary_user_email" placeholder="E-mail" value="<?php echo $user['secondary_masterusers']['email']; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Cargo *</label>
                        <div class="col-sm-3">
                            <select  class="form-control" name="data[secundary_user][type]" id="secundary_user_type" >
                                <option value="<?php echo $user['secondary_masterusers_types']['id']; ?>">value="<?php echo $user['secondary_masterusers_types']['name']; ?>"</option>
                                <?php
                                if (is_array($secondsMasterUsersTypes)) {
                                    foreach ($secondsMasterUsersTypes as $user) {
                                        echo '<option value="' . $user['secondary_masterusers_types']['id'] . '">' . $user['secondary_masterusers_types']['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="userModalButom" type="button" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>