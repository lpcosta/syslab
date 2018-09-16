<div class="row form-group input-group pesquisa">
    <div class="col form-inline">
        <select id="txtTipoBusca" name="busca" class="form-control text-uppercase" onchange="$('#txtBusca').val('').focus();">
            <option selected value="patrimonio">Patrimônio</option>
            <option value="os">os</option>
        </select>
        &nbsp;
        <input type="text" class="form-control" name="txtbusca" id="txtBusca" required="" autofocus="" size="8" />
        &nbsp;
        <button type="button" name="btnBusca" id="btnBusca" class="btn btn-primary text-uppercase">buscar</button>
    </div>
</div>