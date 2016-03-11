<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<br/>
<h1 class="page-header" id="code">Vendas</h1>

<div id="">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#section0">Minhas Vendas</a></li>
        <li><a data-toggle="tab" href="#sectionB">Todas as Vendas</a></li>
        <li><a data-toggle="tab" href="#section">Status - Inicio da Transação</a></li>
        <li><a data-toggle="tab" href="#section">Status - Autorizado</a></li>
        <li><a data-toggle="tab" href="#section">Status - Iniciado</a></li>
        <li><a data-toggle="tab" href="#section">Status - Boleto Impresso</a></li>
        <li><a data-toggle="tab" href="#section">Status - Concluido</a></li>
        <li><a data-toggle="tab" href="#section">Status - Cancelado</a></li>
        <li><a data-toggle="tab" href="#section">Status - Em Analise</a></li>
        <li><a data-toggle="tab" href="#section">Status - Estornado</a></li>
        <li><a data-toggle="tab" href="#section">Status - Em Revisao</a></li>
        <li><a data-toggle="tab" href="#section">Status - Reembolsado</a></li>
    </ul>
    <div class="tab-content">
        <div id="section0" class="tab-pane fade in active"> 

        </div>

        <div id="sectionB" class="tab-pane fade in active"> 
            <h4>Todas Vendas</h4><br/>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DATA</th>
                        <th>PRODUTO</th>
                        <th>COMPRADOR</th>
                        <th>VALOR</th>
                        <th>COMENTÁRIO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todasVendas as $venda) { ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

