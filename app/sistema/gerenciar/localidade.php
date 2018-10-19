<?php
   paginaSegura();
   $sql = new Read();
?>
<div class="tabs">
    <ul>
        <li><a href="#edita-equipamento">Gerenciar Localidade</a></li>
    </ul>
    <div id="edita-equipamento">
        <input type="hidden" name="acao" value="pesquisa" />
        <div class="row">
            <div class="col form-inline">
                <label style="width: 100px;">Localidade</label>
                <input type="text" id="bsclocalidade" class="form-control" style="width: calc(100% - 105px);" />
            </div>
            <div class="col form-inline">
                <input type="text" id="txtCr" class="form-control" onblur="setaLocalidade(this.value);" placeholder="CR" onkeyup="if (event.keyCode == 13){$('#bsclocalidade').focus();}" style="width: 80px;"/>
                <select id="txtLocalidade" onchange="buscaLocalidade(this.value);" class="text-capitalize form-control" style="width: calc(100% - 85px);" >
                    <option selected value="">Selecione...</option>                        
                    <?$sql->FullRead("SELECT id,local FROM tb_sys008 ORDER BY local");
                    foreach($sql->getResult() as $res):
                        print "<option value=".$res['id'].">".$res['local']."</option>";
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
    </div>
    <hr style="margin-top: -10px;" />
    <div class="dados-edita">
       
    </div>
</div>