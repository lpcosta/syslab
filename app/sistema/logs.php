<?php
paginaSegura();
$sql = new Read();

//$sql = $crud->select('tecnico, data, ip, host,acao,msg ', 'sys024 ', 'order by data desc limit 50', ['']);
$sql->ExeRead("tb_sys024 ORDER BY data DESC limit 50");

?>
<div class="tabs">
    <ul>
        <li><a href="#cad-entrada" id="log">Logs do Sistema</a></li>
    </ul>
    <div id="log">
        <table class="table-hover" style="width: 90%; margin: 0 auto;">
            <tr>
                <th>TÉCNICO</th>
                <th class="text-center">MENSAGEM</th>
                <th class="text-center">DATA</th>
                <th>HOST</th>
            </tr>
            <?foreach ($sql->getResult() as $log):
                if($log['acao']==1):
                    $msg = $log['msg'].' '.$log['ip']; 
                else:
                    $msg = $log['msg'].' '.' no ip '.$log['ip'];
                endif;
            ?>
            <tr style="text-transform: capitalize;">
                <td><?=$log['tecnico']?></td>
                <td class="text-center"><?=$msg;?></td>
                <td class="text-center"><?=date('d-m-Y H:i:s',strtotime($log['data']))?></td>
                <td><?=$log['host']?></td>
            </tr>
            <?endforeach;?>
        </table>
    </div>
</div>