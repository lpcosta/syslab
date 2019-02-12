<?php
   paginaSegura();
   $sql = new Read();
   $localidade = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#localidade">Consultar Localidade</a></li>
    </ul>
    <div id="localidade">
        <div class="row">
            <div class="col form-inline">
                <input type="text" id="txtCr" class="form-control" onblur="setaLocalidade(this.value); consultaLocalidade(this.value); " maxlength="5" placeholder="CR" onkeyup="if (event.keyCode == 13){$('#bsclocalidade').focus();}" style="width: 80px;"/>
                <select id="txtLocalidade" onchange="consultaLocalidade(this.value);" class="text-capitalize form-control" style="width: calc(100% - 85px);" >
                    <option selected value="">Selecione...</option>                        
                    <?$sql->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local");
                    foreach($sql->getResult() as $res):
                        print "<option value=".$res['id'].">".$res['local']."</option>";
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="col form-inline">
                <label style="width: 100px;">Localidade</label>
                <input type="text" id="bsclocalidade" onkeydown="autoCompletar(this,'localidade','consultalocal')" class="form-control" style="width: calc(100% - 105px);" />
            </div>
        </div>
        <div class="sanfona dados"></div>
    </div>
</div>

