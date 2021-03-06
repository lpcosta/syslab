/* by Leandro Pereira*/
$( ".tabs" ).tabs({
      /*show: { 
          effect: "blind", duration: 5
      }*/
   });
   
/*######### autocomplete ##################*/  
function autoCompletar(obj,target,fnc){
    $('#'+obj.id).autocomplete({
        source: function(request, response){
            $.ajax({
                url:"./app/sistema/ajax/auto-complete.php",
                dataType:"json",
                type:'POST',
                data:{p:request.term,acao:target},
                success: function(data){
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(e,ui){
            $("#"+obj.id).val(ui.item.label);
            switch(fnc){
                case 'equipamento':
                    buscaEquipamento(ui.item.value);
                    break;
                case 'localidade':
                    buscaLocalidade(ui.item.value);
                    break;
                case 'peca':
                    buscaPeca(ui.item.value);
                    break;
                case 'usuario':
                    buscaUsuario(ui.item.value);
                    break;
                case 'pesquisaPatrimonioId':
                    pesquisaPatrimonioId(ui.item.value);
                    break;
                case 'avalia':
                    avaliaEquipamento(ui.item.value);
                    break;
                case 'consultalocal':
                    consultaLocalidade(ui.item.value);
                    break;
                default:
                    return false;
            }
            return false;
        }
    });  
}
/*######### fim autocomplete ##################*/  

/******************************************************************************/
/*################# BUSCA TECNICO ############################*/
function buscaUsuario(id){
    $.ajax({
        type: "POST",
        url: "./app/sistema/ajax/busca-usuario.php",
        data: {id:id},
        dataType:'HTML',
        beforeSend:function(){
         $('.form_load').fadeIn(300);
        },
        success: function( res )
        {$('.form_load').fadeOut();
            $('.dados-edita').html(res);
        }
    });
}


/*################# BUSCA PEÇA ############################*/
function buscaPeca(id){
    $.ajax({
      url:'./app/sistema/ajax/busca-peca.php',
      data: {codigo:id},
      type:'POST',
      dataType:'HTML',
      success: function (res){
        $('.dados-edita').html(res).slideDown(800);
        $('.btn-edita-peca').show();
      }
    });
}
/*################# BUSCA CIDADE ############################*/
function buscaCidade(e)/*essa função busca cidades e preenche um combo com as cidades e cep*/
{
   $.post('./app/sistema/ajax/buscacidade.php',
            {
                estado: $(e).val()
            }, function (res)
    {
        if (res) {
            $("#txtCidade").attr('disabled', false);
            $("#txtCidade").children(".cidades").remove();
            $("#txtCidade").append(res);
        } else
        {
            $("#txtCidade").attr('disabled', true);
            $("#txtCep").attr('disabled', true);
        }
    });
}
/*################# BUSCA CEP ############################*/
function buscaCep(c)
{
   $.post('./app/sistema/ajax/buscacep.php',
            {
                cidade: $(c).val()
            }, function (res)
    {
        if (res) {
            $("#txtCep").attr('disabled', false);
            $("#txtCep").val(res);
        } else
        {
            $("#txtCep").attr('disabled', true);
        }
    });
}
/*################# BUSCA IDAVALIAÇÃO ############################*/
function buscaIdAvaliacao(){
    $("#form-dados-avaliacao").validate({
        rules:{
            entrada:{required:true},
            patrimonio:{required:true},
       },
        submitHandler: function(){
          modal('validado');
        }
       
    });
}
/*################# BUSCA LOCALIDADE ############################*/
function buscaLocalidade(id){
    $.ajax({
        type: "POST",
        url: "./app/sistema/ajax/busca-localidade.php",
        data: {id:id},
        dataType:'HTML',
        beforeSend:function(){
         $('.form_load').fadeIn(300);
        },
        success: function( res )
        {$('.form_load').fadeOut();
            $('.dados-edita').html(res);
        }
    });
}

function consultaLocalidade(id){
   $.ajax({
        type: "POST",
        url: "./app/sistema/ajax/consulta-localidade.php",
        data: {id:id},
        dataType:'HTML',
        beforeSend:function(){
         $('.form_load').fadeIn(300);
        },
        success: function( res )
        {$('.form_load').fadeOut();
            $('.dados').html(res);
        }
    });
}
/*################# BUSCA EQUIPAMENTO ############################*/
function buscaEquipamento(id){
    $.ajax({
        type: "POST",
        url: "./app/sistema/ajax/busca-equipamento.php",
        data: {id:id},
        dataType:'HTML',
        beforeSend:function(){
         $('.form_load').fadeIn(300);
        },
        success: function( res )
        {$('.form_load').fadeOut();
            $('.dados-edita').html(res);
        }
    });
}
/*################# BUSCA AVALIAÇÃO ############################*/
function buscaAvaliacao(id){
    $.ajax({url: './app/sistema/ajax/busca-avaliacao.php',
        data: {ID:id},type:'POST',dataType:'HTML',
            success: function (res){
            $('.edita-avaliacao').html(res);
            }
        });
}

function liberaCamposEdicaoEquipamento(){
    var categoria = $('#txtCategoria').val();
    
    $('.editable').attr('disabled',false);
   
    switch(categoria){
        case '1':
            $('.editable-monitor').attr('disabled',false);
            break;
        case  '2':
        case  '5':
        case '17':
        case '23':
        case '22':
        case '26':
            $('.editable-cpu').attr('disabled',false);
            break;
        case '3':
            $('.editable-estab').attr('disabled',false);
            break;
        case '4':
            $('.editable-monitor').attr('disabled',false);
            break;
        default:
            $('.editable').attr('disabled',true);
    }
    
    $('.btn-acao-edita').toggle();
    $('.btn-acao-salva').toggle();
}
function liberaCamposEdicao()
{
    $('.editable').attr('disabled',false);
    $('.btn-acao-edita').toggle();
    $('.btn-acao-salva').toggle();
}

function bloqueiaCamposEdicao(){
    $('.editable').attr('disabled',true);
    $('.editable-cpu').attr('disabled',true);
    $('.editable-monitor').attr('disabled',true);
    $('.editable-estab').attr('disabled',true);
    $('.editable-monitor').attr('disabled',true);
}

/*EDITA-QUIPAMENTO*/
function editaEquipamento(){
    var dados = $(".edita").serialize();
        $.ajax({
            url: './app/sistema/ajax/edita.php',
            data: dados,
            type:'POST',
            dataType:'HTML',
        beforeSend:function(){
       $('.form_load').fadeIn(500);
        },
        success: function (res){
            $('.form_load').fadeOut(500);
            $('.btn-acao-edita').toggle();
            $('.btn-acao-salva').toggle();
            bloqueiaCamposEdicao();
            modal(res);
        }
    });
}


function editaUsuario(){
    var dados = $(".edita").serialize();
    $.ajax({
        url: "./app/sistema/ajax/edita.php",
        data: dados,
        type: "POST",
        dataType:'HTML',
        beforeSend:function(){
         $('.form_load').fadeIn(500);
        },
        success: function(res)
        {
            $('.form_load').fadeOut(500);
            $('.btn-acao-edita').toggle();
            $('.btn-acao-salva').toggle();
            buscaUsuario($('#txtIdTecnico').val());
            modal(res);    
        }
    });
}

function editaPeca(){
    var dados = $(".form-edita").serialize();
    $.ajax({
        url: "./app/sistema/ajax/edita.php",
        data: dados,
        type: "POST",
        dataType:'HTML',
        beforeSend:function(){
         $('.form_load').fadeIn(500);
        },
        success: function(res)
        {
            $('.form_load').fadeOut(500);
            $('.btn-acao-edita').toggle();
            $('.btn-acao-salva').toggle();
            buscaPeca($('#txtIdPeca').val());
            modal(res);    
        }
    });
}

function editaLocalidade(id){
   var dados = $(".edita").serialize();
   $.ajax({
        url: "./app/sistema/ajax/edita.php",
        data: dados,
        type: "POST",
        dataType:'HTML',
        beforeSend:function(){
         $('.form_load').fadeIn(500);
        },
        success: function(res)
        {
            $('.form_load').fadeOut(500);
            $('.btn-acao-edita').toggle();
            $('.btn-acao-salva').toggle();
            buscaLocalidade(id);
            modal(res);
        }
    });
}

function editaEntrada(id){
    var dados = $(".edita-entrada-"+id).serialize();
    $.ajax({
        url: "./app/sistema/ajax/edita.php",
        data: dados,
        type: "POST",
        dataType:'HTML',
        success: function(res)
        {
            $('.btn-salva-'+id).hide();
            $('.btn-edita-'+id).show();
            $('#frm-g-entrada').submit();
            modal(res);
        }
    });
}

function imprime() {
    var divToPrint = document.getElementById('printArea');
    newWin= window.open();
    newWin.document.write('<style>.text-uppercase{text-transform: uppercase;}.text-center{text-align:center;}.left{text-align:left;}.text-capitalize{text-transform: capitalize;}.relatorio{width:100%;}</style>');
    newWin.document.write(divToPrint.innerHTML);
    newWin.document.close();
    newWin.focus();
    newWin.print();
    newWin.close();
}

/*função que adicona chaves (product key winodws e office)*/
function addChave(t,c)
{
    if (t == 'windows' && c =='11')
    {
        $('#txtKeySo').val('DF4HY-VFCBJ-TFQYK-4GDV4-9KPB6');
        
    } else if (t=='office' && c == '7')
    {
        $('#txtKeyOffice').val('KGFVY-7733B-8WCK9-KTG64-BC7D8');
    } else if (t=='office' && c == '8')
    {
        $('#txtKeyOffice').val('GWH28-DGCMP-P6RC4-6J4MT-3HFDY');
    }
}/*fim da função que adiciona chaves keys*/

/*REALIZA LOGIN*/
function fctLogin()
{
    var dados = $('.j_Cadastra').serialize();
    $.ajax({
          url:'./app/sistema/ajax/jpLogin.php',
          data: dados,
          type:'POST',
          dataType:'HTML',
          beforeSend:function(){
             $('.form_load').fadeIn(500);
          },
          success: function (res){
           $('.form_load').fadeOut(1000);
           if(res != 1){
               $('.j_Aviso').addClass('alert alert-warning').html(res).slideDown(800);
           }else{
               setTimeout(function(){
                   location.href='https://syslab.lpcosta.com.br/';
               },1000)
           }
          }
      });
}/*FIM LOGIN*/

$('#form-reset-senha').validate({
    rules:{
        pass_atu        :{required:true,minlength: 8},
        novo_pass       :{required:true,minlength:8},
        conf_novo_pass  :{required:true,minlength:8}
    },
    submitHandler: function(){
        if($.trim($('#txtPassNew').val()) != $.trim($('#txtConfPassNew').val()))
        {
             modal('Senhas Não Conferem!');
        }else{
            var dados = $(".reset-senha").serialize();
            $.ajax({
                type: "POST",
                url: "./app/sistema/ajax/edita.php",
                data: dados,
                dataType:'HTML',
                success: function(res)
                {
                   modal(res);
                }
            });
        }
    }
});          


$(".data").datepicker({
    defaultDate: "getDate()",
    dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    nextText: 'Próximo',
    prevText: 'Anterior'
}).datepicker("setDate", new Date());

/*PEGA OS MODELOS DE EQUIPAMENTO CONFORME O FABRICANTE ESCOLHIDO*/     
function getModelos(fab,mod = null)
{
    $.post('./app/sistema/ajax/buscamodelos.php',
            {
                fabricante  : fab,
                modelo      : mod
            }, function (res){
                if(res){
                    $("#txtModelo").attr('disabled', false);
                    $("#txtModelo").children(".cmbv_modelos").remove();
                    $("#txtModelo").append(res);
                }
                else{
                    $("#txtModelo").children(".cmbv_modelos").remove();
                    $("#txtModelo").append("<option value='' class='cmbv_modelos'>Selecione..</option>");
                    {$('#txtModelo').attr('disabled',true);}
                }
            });
}/*FIM GETMODELOS*/  


/*####### FUNCOES QUE AUXILIA VALIDA E VERIFICA OS ITENS E AS ENTRADAS ###### */

function verificaEntrada(t){
    var dados = $('#form-cria-entrada').serialize();
    $.post('./app/sistema/ajax/cria-entrada.php',dados+'&id_tecnico='+t,function (res)
        {
            if ($.isNumeric(res)) {
               $("#txtTecnico").attr('disabled', true);
               $("#txtDocFun").attr('disabled', true);
               $("#txtNomeFun").attr('disabled', true);
               $('#nentrada').html('Entrada nº' + ' ' + res);
               $('#iten-entrada').slideDown(500);
               $('#numeroEntrada').val(res);
               $('#txtOs').focus();
               adicionaItemEntrada(t,res);
            } else
            {modal(res);}
        });
}

function validaItemEntrada(t,e){
    $('#iten-entrada').validate({
        rules:{
            os_sti       :{required:true,number:true},
            patrimonio   :{required:true,minlength:6,maxlength:7},
            id_categoria :{required:true},
            fabricante   :{required:true},
            modelo       :{required:true},
            id_local     :{required:true},
            motivo       :{required:true},
            local_uso    :{required:true},
            observacao   :{required:true, minWords: 5}
        },
        submitHandler: function(){
           adicionaItemEntrada(t,e);
        }
    });            
}

function adicionaItemEntrada(t,e){
    var dados = $('.entrada').serialize();
    $.ajax({
                type: "POST",
                url: "./app/sistema/ajax/add-itens-entrada.php",
                data: dados+'&tecnico='+t+'&entrada='+e,
                success: function( res )
                {
                    if($.isNumeric(res)){
                        if(res==1){modal("<span class='alert alert-warning text-primary text-uppercase'>Existe uma entrada em aberto para o <strong>patrimonio</strong> informado!</span>");}
                        else{modal("<span class='alert alert-warning text-primary text-uppercase'>existe uma entrada em aberto para a <strong>ordem</strong> informada!</span>");}
                    }
                    else{
                        $('#resposta-entrada').html(res); 
                        $('#txtOs').focus(); 
                        $("#iten-entrada input,select, textarea").val('');
                        $("#txtTecnico").val(t);
                    }
                }
        });
    return false;
}

function finalizaEntrada(e,mail,resp){
    $.ajax({
            type: "POST",
            url: "./app/sistema/ajax/finaliza-entrada.php",
            data: { entrada: e,mailResp:mail,responsavel:resp},
            dataType:'HTML',
            beforeSend:function(){
             $('.form_load').fadeIn(500);
            },
            success: function(res)
            {$('.form_load').fadeOut(500);
               if($.isNumeric(res)){
                    $("#dialog").html("<div class=\"alert alert-success text-center\">Entrada Finalizada com Sucesso! <br /> Deseja Gerar relatorio?</div>");
                    $("#dialog").dialog({
                    width       : "auto",
                    heigth      : "auto",
                    modal       : true,
                    minHeight   : 180,
                    show    :{effect: "slideDown",duration:1000},
                    hide    : {effect: "slideUp",duration:1000},      
                buttons:
                        {"SIM": function (){$(this).dialog("close");
                                location.href = 'index.php?pg=relatorio/entrada&id=' + res;
                            },
                        "NÃO": function (){
                                $(this).dialog("close");
                                location.href = 'index.php?pg=laboratorio/entrada';
                            }
                        }
                    });
                }else{modal(res);}
            }
    });
}

/*#######  FIM DAS FUNCOES QUE AUXILIA E VALIDA ITENS E ENTRADAS */

/*#### SAIDAS ####*/
function checaSaidaEntrada(s){
    if(s=='tecnico'){
        $('#txtFunc').hide();
        $('#txtTecnico').show();
        $('#chooseSaida').attr('disabled',true);
    }
    else if(s=='funcionario'){
       $('#txtTecnico').hide();
       $('#txtFunc').show();
       $('#chooseSaida').attr('disabled',true);
   }
   else{
       $('#txtTecnico').hide();
       $('#txtFunc').hide();
       $('#chooseSaida').attr('disabled',true);
   }
}

function verificaSaida(t){
    var dados = $('#form-cria-saida').serialize();
    $.post('./app/sistema/ajax/cria-saida.php',dados+'&tiposaida='+t,function (res){
        if($.isNumeric(res)){
            $('#txtSaida').html('Saída nº'+' '+res);
            $('#form-cria-saida').slideUp(500);
            $.post('./app/sistema/ajax/add-itens-saida.php',
                {saida: res}, function (res){
                   $('#itens-saida').html(res).slideDown(500);
                });
        }
        else{
            modal(res);
        }
        });
}

function addItemSaida(){

    $("#add-itens-saida").validate({
        rules:{
            patrimonio:{required:true}
        },
         messages: {patrimonio: "*" },
        submitHandler: function(){
            var dados =  $("#add-itens-saida").serialize();
            $.ajax({
                    type: "POST",
                    url: "./app/sistema/ajax/add-itens-saida.php",
                    data: dados,
                    success: function( res )
                    {
                        $('#itens-saida').html(res).slideDown(500);
                    }
                });
            return false;
            }
    });
}

function finalizaSaida(s,mail,resp){
    $.ajax({
            type: "POST",
            url: "./app/sistema/ajax/finaliza-saida.php",
            data: { saida: s,mailResp:mail,responsavel:resp},
            dataType:'HTML',
            beforeSend:function(){
             $('.form_load').fadeIn(500);
            },
            success: function(res)
            {$('.form_load').fadeOut(500);
               if($.isNumeric(res)){
                    $("#dialog").html("<div class=\"alert alert-success text-center\">Saída Finalizada com Sucesso! <br /> Deseja Gerar relatorio?</div>");
                    $("#dialog").dialog({
                    width       : "auto",
                    heigth      : "auto",
                    modal       : true,
                    minHeight   : 180,
                    show    :{effect: "slideDown",duration:1000},
                    hide    : {effect: "slideUp",duration:1000},      
                buttons:
                        {"SIM": function (){$(this).dialog("close");
                                location.href = 'index.php?pg=relatorio/saida&id=' + res;
                            },
                        "NÃO": function (){
                                $(this).dialog("close");
                                location.href = 'index.php?pg=laboratorio/saida';
                            }
                        }
                    });
                }else{modal(res);}
            }
    });
}

/*#### FIM SAIDAS #####*/

function setaLocalidade(cr,acao=null)
{
    if(cr == 30 || cr == 31 || cr == 32 || cr == 33){
        modal("<span class='alert alert-warning text-primary text-uppercase'>para essa localidade é necessário informar o cr do local</span>");
    }
    else
    {
        options = $('#txtLocalidade option');
        values = $.map(options, function (option) {
            return option.value;
        });
        if (cr !== '')
        {
            if ($.inArray(cr, values) !== -1)
            {
                $("#txtLocalidade").val(cr);
                $("#txtLocalidade").attr('value', cr);
                var id = $('#txtLocalidade').val();
                if(!acao){buscaLocalidade(id);}
            }
            else if (cr.trim()!= '')
            {
                $.post('./app/sistema/ajax/checacr.php',
                {
                    cr: cr
                }, function (res)
                    {
                    if ($.isNumeric(res)){
                        $('#txtLocalidade').attr('value', res);
                        $('#txtLocalidade').val(res); 
                        if(!acao){buscaLocalidade(res);}
                    } else
                    {
                      $('#txtCodLocal').val('').focus();
                       modal(res); 
                    }
                });
            } 
        }
    }
}

function setaPeca(peca,qtde=null)
{
    var options = $('#txtPeca option');
    values = $.map(options, function (option) {
        return option.value;
    });
    if (peca !== '')
    {
        if ($.inArray(peca, values) !== -1)
        {
            if(!qtde){
                var d = new Date().getTime();
                $.post('./app/sistema/ajax/busca-cod-peca.php',
                {peca:peca}, function (res){
                   
                    var dados = res.split(',');
                    if(dados[2]=='0'){
                        $("div.div-qtde").remove();$("#txtPecaSerie").attr({'value':d,'readonly':true});
                        $("#txtObservacao").before("<div class='col-md form-inline div-qtde'><label>Quantidade </label><input type='text'  name='qtde' class='form-control' onblur='$('#txtQtde').attr('value',this.value)' /></div>" );
                        }else{
                            $("div.div-qtde").remove();$("#txtPecaSerie").attr({'value':'','readonly':false});
                        }
                        $('#txtPreco').val(dados[1]);
                    });
                }
            $('#txtCodPeca').val(peca);
            $('#txtPeca').val(peca);
        }
        else 
        {
           $("#txtPeca").val('');
           modal("<span class='alert alert-warning text-danger'>Código Não Encontrado!</span>"); 
        } 
    }
}

function setaTipoRel(val){
    switch(val){
        case 'codigo':
            $(".tecnico-rel").hide().val('');
            $(".periodo-rel").hide().val('');
            $(".cod-rel").show();
            break;
        case 'tecnico':
            $(".cod-rel").hide();
            $(".periodo-rel").hide();
            $(".tecnico-rel").show();
            break;
        case 'periodo':
            $(".cod-rel").hide();
            $(".tecnico-rel").hide();
            $(".periodo-rel").show();
            break;
        default:
            $(".cod-rel").show();
            $(".tecnico-rel").hide();
            $(".periodo-rel").show();
    }
}

function validaRelatorio(t,idfrm){
    if(t=='agpeca'){
       if($.trim($('#txtEquipamento').val())=='' && $.trim($('#txtSecretaria').val())=='' ){
           modal('Favor informar um equipametno ou uma secretaria');
       }else if($.trim($('#txtSecretaria').val())=='26')
       {
           modal('Secretaria Inválida!');
       }else{
           $('.gera-relatorio').hide();
           $('.gera-excel').show();
           geraRelatorio(idfrm);
       };
    }else if(t=='bancada'){
        geraRelatorio(idfrm);
    }else if(t=='equipamento'){
       var  e = $('#txtEquipamento').val(),
            l = $('#txtLocalidade').val();
            if(e.trim() == ''){modal("<span class='alert alert-warning text-danger'>Selecione um <b>equipamento</b>!</span>");$('#txtEquipamento').focus();}
            else if(l.trim() == ''){modal("<span class='alert alert-warning text-danger'>É necessário informar uma <b>localidade</b>!</span>");$('#txtLocalidade').focus();}
            else{geraRelatorio(idfrm);}
    }else{
        switch($('#tipoRel').val()){
            case 'codigo':
                if(t=='saida' && $.trim($('#txtCodSaida').val())==''){
                    modal('informe um numero de saida!');
                }else if(t=='entrada'&& $.trim($('#txtCodEntrada').val())==''){
                    modal('informe um numero de entrada!');
                }else{geraRelatorio(idfrm);}
                break;
            case 'tecnico':
                if($('#txtTecnico').val()=='')
                {modal('Selecione um Técnico');}
                else{geraRelatorio(idfrm);}
            break;
            case 'periodo':
                if($('#dtInicial').val()== '' && $('#dtFinal').val()=='' )
                {modal('informe pelo menos uma Data');}
                else{geraRelatorio(idfrm);}
            break;
            default:
                return false;
        }
    }
}

function geraExel(pg){
    var categ  = $.trim($('#txtEquipamento').val());
    var secret = $.trim($('#txtSecretaria').val());
    switch(pg){
        case 'agpeca':
            if(categ=='0')
            {location.href='./excel/aguardo-geral-peca.php';}
            else if(categ != '0' && secret != '26' && secret == '')
            {location.href='./excel/categoria.php?categoria='+categ;}
            break;
        dafault:
            return false;
    }
}

function geraRelatorio(frm){
    var dados =  $(frm).serialize();
        $.ajax({
            type: "POST",
            url: "./app/sistema/ajax/relatorio.php",
            data: dados,
            dataType:'HTML',
            beforeSend:function(){
             $('.form_load').fadeIn(500);
            },
            success: function(res)
            {$('.form_load').fadeOut(500);
               $(".relatorio").html(res);
            }
        });
}


function checaCadastroPatrimonio(p)
{
    if($.trim(p)!=''){
        $.post('./app/sistema/ajax/checa-cadastro-patrimonio.php',
                {patrimonio: p}, function (res)
        {
            if (!$.isNumeric(res))
            {
                dados = res.split(',');
                var loc = ['30','31','32','33'];
                if($.inArray(dados[1], loc)=='0'){dados[1]='';}
                $('#txtEquipamento').val(dados[0]);
                $('#txtFabricante').val(dados[3]);
                $('#txtLocalidade').val(dados[1]);
                $('#txtCr').val(dados[2]);
                $('#txtAndar').val(dados[6]);
                $('#txtSala').val(dados[7]);

                getModelos(dados[3],dados[4]);
            
                switch(dados[1]){
                    case '1':
                        $('#txtObservacoes').attr('placeholder','Obs: NÃO ESQUECER DE Informar se a Impressora veio com com ou sem toner e se a mesma é usada na rede ou via cabo usb.');
                        break;
                    case '5':
                        $('#txtObservacoes').attr('placeholder','Obs: NÃO ESQUECER DE Informar se veio FONTE!');
                        break;
                    case '17':
                        $('#txtObservacoes').attr('placeholder','Obs: NÃO ESQUECER DE Informar se veio FONTE!');
                        break;
                    default:
                        false;
                }
                
            }
            else{
                switch(res){
                    case '1':
                        modal("<span class='alert alert-warning text-primary text-uppercase'>Já existe uma entrada com esse patrimônio!</span>");
                        break;
                    case '2':
                        modal("<div class='alert alert-warning text-primary text-uppercase'><p>Já existe uma entrada para O.S informada!</p>");
                        break;
                    case '3':
                         var p = $('#txtPatrimonio').val();
                        modal("<div class='alert alert-warning text-primary text-uppercase'><p>Patrimônio não Cadastrado!</p>"+
                               "<p>Deseja Cadastra-lo? <a href='index.php?pg=cadastra/equipamento&p="+p+"'>Sim</a></p></div>");
                        break;
                    case '4':
                        modal("<div class='alert alert-warning text-primary text-uppercase'>Consta um registro de baixa desse Patrimônio!<br /> Por favor verifique e tenta Novamente!</div>");
                        break;
                    default:
                    modal("<div class='alert alert-warning text-primary text-uppercase'>OPS! Não faço a mínima idéia do porque que aconteceu!<br />"+
                            "Por favor feche seu Navegador e tente Novamente!<br />"+
                            "Se o problema persistir... Ferrou!</div>");                   
                }
            }
        });
    }
}

/*MOSTRA E OCUPA CAMPOS OPCIONAIS NO CADASTRO DE EQUIPAMENTO*/
function setCadEquipamento(e){
   switch(e){
        case '1':
        case '28':
        case '29':
                $('.opcao-cad-cpu').hide();
                $('.opcao-cad-monitor').hide();
                $('.opcao-cad-estabilizador').hide();
                $('.opcao-cad-printer').slideDown(500);
            break;
        case  '2':
        case  '5':
        case '17':
        case '23':
        case '22':
        case '26':
                $('.opcao-cad-printer').hide();
                $('.opcao-cad-monitor').hide();
                $('.opcao-cad-estabilizador').hide();
                $('.opcao-cad-cpu').slideDown(500);
            break;
        case '3':
                $('.opcao-cad-printer').hide();
                $('.opcao-cad-monitor').hide();
                $('.opcao-cad-cpu').hide();
                $('.opcao-cad-estabilizador').slideDown(500);
            break;
        case '4':
                $('.opcao-cad-printer').hide();
                $('.opcao-cad-cpu').hide();
                $('.opcao-cad-estabilizador').hide();
                $('.opcao-cad-monitor').slideDown(500);
            break;
        default:
        $('.opcao-cad-cpu').slideUp();
        $('.opcao-cad-monitor').slideUp();
        $('.opcao-cad-printer').slideUp();
        $('.opcao-cad-estabilizador').slideUp();
   }
}/*FIM SETCADEQUIPAMENTO*/

/*mascaras de campos*/

    $.mask.definitions['~'] = "[+-]";
    $(".m_key").mask("*****-*****-*****-*****-*****");
    $("#txtIp").mask("999.999.999.999");
    $(".contatoFixo").mask("(99)9999-9999");
    $(".contatoMovel").mask("(99)99999-9999");
    $("#txtCnpj").mask("99.999.999/9999-99");
    $("#txtCep").mask("99.999-999");
    $(".data").mask("99/99/9999");
   
function maskKey(el)/*mascara para chave key de windows e office */
{
    var e = $(el).val();
    if (event.keyCode != 8)
    {
        if (e.length === 5)
            $(el).val(e + '-');
        if (e.length === 11)
            $(el).val(e + '-');
        if (e.length === 17)
            $(el).val(e + '-');
        if (e.length === 23)
            $(el).val(e + '-');
    }
}
/*fim das mascaras de campos*/

/*valida CNPJ*/
    function validarCNPJ(cnpj){
        var cnpj = cnpj;
        var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
        var dig1= new Number;
        var dig2= new Number;

        exp = /\.|\-|\//g
        cnpj = cnpj.toString().replace( exp, "" ); 
        var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));

        for(i = 0; i<valida.length; i++){
                dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);  
                dig2 += cnpj.charAt(i)*valida[i];       
        }
        dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
        dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));

        if(((dig1*10)+dig2) != digito){  
            modal("<span class=\"alert alert-warning\">CNPJ Inválido!</span>");
        }
    }
/*fim valida CNPJ*/

/*valida cpf*/
//valida o CPF digitado
function ValidarCPF(cpfval){
        var cpf = cpfval;
        exp = /\.|\-/g
        cpf = cpf.toString().replace( exp, "" ); 
        var digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));
        var soma1=0, soma2=0;
        var vlr =11;

        for(i=0;i<9;i++){
                soma1+=eval(cpf.charAt(i)*(vlr-1));
                soma2+=eval(cpf.charAt(i)*vlr);
                vlr--;
        }       
        soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));
        soma2=(((soma2+(2*soma1))*10)%11);

        var digitoGerado=(soma1*10)+soma2;
        if(digitoGerado!=digitoDigitado)        
            modal("<span class=\"alert alert-warning\">CPF Inválido!</span>");        
}

/*fim valida cpf*/


/*FUNÇÕES QUE VALIDA FORMULARIOS*/

    /*CADASTRA WINDOWS*/
    $('#cadastra-windows').validate({
        rules:{
            windows         :{required:true,minlength:9,maxlength:15,minWords:2},
            VersaoWindows   :{required:true,minlength:4,maxlength:15},
            ArquiteturaSo   :{required:true}
        },
        submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-windows');
        }
    });/*FIM CADASTRO WINDOWS*/
    
    /*CADASTRA OFFICE*/
    $('#cadastra-office').validate({
        rules:{
            office              :{required:true,minlength:9,maxlength:15,minWords:2},
            versaoOffice        :{required:true,minlength:4,maxlength:15},
            arquiteturaOffice   :{required:true}
        },
        submitHandler: function(){
           cadastra('./app/sistema/ajax/cadastra.php','#cadastra-office');
        }
    });/*FIM CADASTRO OFFICE*/
    
$("#form-edita-peca").validate({
    rules:{
        id_peca:{required:true,number:true}
    },
     submitHandler: function(){
        var dados = $("#form-edita-peca").serialize();
            $.ajax({
                url: './app/sistema/ajax/edita-peca.php',
                data: dados,
                type:'POST',
                dataType:'HTML',
            beforeSend:function(){
           $('.form_load').fadeIn(500);
            },
            success: function (res){
                $('.form_load').fadeOut(500);
                if($.isNumeric(res)){
                   location.href='index.php?pg=edita/peca&id='+res;
                }else{modal("<span class='alert alert-warning text-danger'>Nenhum registro encontrado para o codigo informado!</span>");$('.form_load').fadeOut(500);}
            }
        });
        return false;
    }
});


$('#baixa-peca').validate({
   rules:{
       peca_id          :{required:true},
       ordem_servico    :{required:true}
   },
   submitHandler: function(){
        var dados = $("#baixa-peca").serialize();
            $.ajax({
                url: './app/sistema/ajax/baixa-peca-estoque.php',
                data: dados,
                type:'POST',
                dataType:'HTML',
            beforeSend:function(){
           $('.form_load').fadeIn(500);
            },
            success: function (res){
            $('.form_load').fadeOut(500);
               modal(res);
            }
        });
        return false;
    }
});

function baixaPeca(peca,os,id){
    $.ajax({
            url: './app/sistema/ajax/baixa-peca-estoque.php',
            data: {peca_id:peca,ordem_servico:os,bancada:id},
            type:'POST',
            dataType:'HTML',
            success: function (res){
                $('#btnAvalia').trigger('click');
               modal(res);
            }
        });
}

/*FIM EDITA-PATRIMONIO*/
    /*CADASTRO DE EQUIPAMENTO*/
    $('#cad-equip').validate({
            rules:{
                id_categoria :{required:true},
                fabricante   :{required:true},
                modelo       :{required:true},
                serie        :{required:true,minlength:5},
                patrimonio   :{required:true,minlength:6,maxlength:7},
                id_local     :{required:true}
            },
            submitHandler: function(){
                 cadastra('./app/sistema/ajax/cadastra.php','#cad-equip');
             }
        });/*FIM DO CADASTRO DE EQUIPAMENTO*/
    
    /*CADASTRO DE USUARIO*/
    $('#cadastra-user').validate({
       rules:{
           nomeUser    :{required:true,minWords:2},
           mailUser    :{required:true,email:true},
           empresaUser :{required:true},
           contatoUser :{required:true},
           loginUser   :{required:true,minlength:5},
           passUser    :{required:true,minlength:7,maxlength:12},
           tipoUser    :{required:true},
           grupoUser   :{required:true}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-user');
        }
    });
    /*FIM DO CADASTRO DE USUARIO*/
    
    /*CADASTRO DE EMPRESA*/
    $('#cadastra-empresa').validate({
       rules:{
           txtRazaoSocial   :{required:true},
           txtCnpj          :{required:true},
           txtFantasia      :{required:true},
           txtEstado        :{required:true},
           txtCidade        :{required:true},
           txtBairro        :{required:true},
           txtCep           :{required:true},
           txtRuaEmpresa    :{required:true},
           txtEmailEmpresa  :{required:true,email:true},
           txtContatoEmpresa:{required:true}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-empresa');
        }
    });
    /*FIM DO CADASTRO DE EMPRESA*/
/*########### PESQUISA ENTREGAS POR REGIAO##########*/
function modalGeral(id,url,titulo){
    $('#modal').attr('title',titulo);
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        success: function( res )
        {
          show_modal('#modal',res);                              
        }
    });
}
/*########### FIM PESQUISA ENTREGAS POR REGIAO##########*/


    /*PESQUISA PATRIMONIO*/
    $('#formSearch').validate({
        onfocusout: false,
        onkeyup: false,
        rules:{
            busca:{required: true}
                },
            messages: {busca:"*"},
            submitHandler: function(form){
                var dados = $(form).serialize();
                $.ajax({
                        type: "POST",
                        url: "./app/sistema/pesquisa/patrimonio.php",
                        data: dados,
                        success: function( res )
                        {
                          show_modal('#modal-busca-patrimonio',res);                              
                        }
                });
             return false;
        }
    });
    /*FIM DA PESQUISA DE PATRIMONIO*/
function mostraModal(p){
    $("#txtBusca").val(p);
    $("#formSearch").submit();
}

function pesquisaPatrimonioId(id){
    
    $.ajax({
        type: "POST",
        url: "./app/sistema/pesquisa/patrimonio.php",
        data: {busca:id,acao:'id'},
        success: function( res )
        {
          show_modal('#modal-busca-patrimonio',res);                              
        }
    });
}

/*PESQUISA OS*/
   $('#formSearchOs').validate({
        onfocusout: false,
        onkeyup: false,
        rules:{
            busca: {
                    required: true,
                    maxlength:7,
                    onkeyup:false
                }
                },
            messages: {busca:"*"},
            submitHandler: function(form){
                var dados = $(form).serialize();
                $.ajax({
                        type: "POST",
                        url: "./app/sistema/pesquisa/patrimonio.php",
                        data: dados,
                        success: function( res )
                        {
                          show_modal('#modal-busca-patrimonio',res);                              
                        }
                });
             return false;
        }
});
/*FIM DA PESQUISA DE os*/

/*CADASTRA SECRETARIA*/
    $('#cadastra-secretaria').validate({
       rules:{
           nomeSecretaria    :{required:true},
           siglaSecretaria   :{required:true,minlength:2}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-secretaria');
        }
    });
/*FIM DO CADASTRO DE SECRETARIA*/

/*CADASTRA CATEGORIA*/
    $('#cadastra-categoria').validate({
       rules:{
           nomeCategoria    :{required:true}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-categoria');
        }
    });
/*FIM DO CADASTRO DE CATEGORIA*/
    
/*CADASTRA STATUS*/
    $('#cadastra-status').validate({
       rules:{
           nomeStatus    :{required:true},
           corStatus    :{required:true}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-status');
        }
    });
/*FIM DO CADASTRO DE STATUS*/


/*VALIDA CADSTRO DE LOCALIDADE*/

    $('#cadastra-motivo').validate({
       rules:{
           motivoEntrada            :{required:true},
           categoriaMotivoEntrada   :{required:true}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-motivo');
        }
    });
/*FIM DA VALIDAÇÃO DE CADASTRO DE LOCALIDADE*/

/*CADASTRA MOTIVO ENTRADA*/
    $('#cadastra-localidade').validate({
       rules:{
           nomeLocalidade   :{required:true},
           crLocalidade     :{required:true,number:true},
           txtEndereco      :{required:true},
           txtBairro        :{required:true},
           txtCep           :{required:true},
           secretaria       :{required:true},
           txtRegiao        :{required:true}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-localidade');
        }
    });
/*FIM DO MOTIVO ENTRADA*/

    $('#form-reseta-login').validate({
       rules:{
           txtLogin :{required:true},
           txtEmail :{required:true,email:true}
       },
       submitHandler: function(){
           var dados = $('#form-reseta-login').serialize();
            $.ajax({
                url: './app/sistema/ajax/resetpassword.php',
                data: dados,
                type:'POST',
                dataType:'HTML',
            beforeSend:function(){
           $('.frm_load').fadeIn(500);
            },
            success: function (res){
            $('.frm_load').fadeOut(500);
                $('#error').html(res).slideDown(500);
            }
        });
    return false;
           
       }
          
    });

$("#cadastra-modelo-equipamento").validate({
    rules:{
        modelo          :{required:true},
        fabricante_id   :{required:true}
    },
    submitHandler: function(){
        cadastra('./app/sistema/ajax/cadastra.php','#cadastra-modelo-equipamento');
    }
});


$("#cadastra-peca").validate({
    rules:{
        descricao_peca :{required:true},
        categoria_id   :{required:true}
    },
    submitHandler: function(){
        cadastra('./app/sistema/ajax/cadastra.php','#cadastra-peca');
    }
});

$("#cadastra-fornecedor").validate({
    rules:{
        nome_fornecedor :{required:true}
    },
    submitHandler: function(){
        cadastra('./app/sistema/ajax/cadastra.php','#cadastra-fornecdor');
    }
});

$("#recebe-peca").validate({
    rules:{
        dt_recebimento  :{required:true},
        peca_id         :{required:true},
        peca_serie      :{required:true},
        fornecedor_id   :{required:true},
        preco_peca      :{required:true}
    },
    submitHandler: function(){
        cadastra('./app/sistema/ajax/cadastra.php','#recebe-peca');
    }
});

$('#cadastra-memoria').validate({
    rules:{
        tipo_memoria:{required:true},
        capacidade:{required:true}
    },
    messages: {tipo_memoria: "*",capacidade:"*"},
    submitHandler: function(){
        cadastra('./app/sistema/ajax/cadastra.php','#cadastra-memoria');
    }
});

function liberaEdicao(id){
    $('.editable-'+id).attr('disabled',false);
    $('.btn-edita-'+id).hide();
    $('.btn-salva-'+id).show();
}

function editaWindows(id){
    var dados = $(".edita-win-"+id).serialize();
    $.ajax({
            url: './app/sistema/ajax/edita.php',
            data: dados,
            type:'POST',
            dataType:'HTML',
        success: function (res){
            $('.editable-'+id).attr('disabled',true);
            $('.btn-edita-'+id).show();
            $('.btn-salva-'+id).hide();
            modal(res);
        }
    });
}
function editaOffice(id){
    var dados = $(".edita-office-"+id).serialize();
    $.ajax({
            url: './app/sistema/ajax/edita.php',
            data: dados,
            type:'POST',
            dataType:'HTML',
        success: function (res){
            $('.editable-'+id).attr('disabled',true);
            $('.btn-edita-'+id).show();
            $('.btn-salva-'+id).hide();
            modal(res);
        }
    });
}

function liberaEdicaoMemoria(i){
    $('.editable-'+i).attr('disabled',false);
    $('.btn-edit-'+i).hide();
    $('.btn-salva-'+i).show();
}

function editaMemoria(i){
    var dados = $(".edita-mem-"+i).serialize();
        $.ajax({
            url: './app/sistema/ajax/edita.php',
            data: dados,
            type:'POST',
            dataType:'HTML',
        success: function (res){
            $('.editable-'+i).attr('disabled',true);
            $('.btn-edit-'+i).show();
            $('.btn-salva-'+i).hide();
            modal(res);
        }
    });
}

function liberaEdicaoProcessador(i){
    $('.editable-'+i).attr('disabled',false);
    $('.btn-edita-proc-'+i).hide();
    $('.btn-salva-proc-'+i).show();
}

function editaProcessador(i){
    var dados = $(".edita-proc-"+i).serialize();
        $.ajax({
            url: './app/sistema/ajax/edita.php',
            data: dados,
            type:'POST',
            dataType:'HTML',
        success: function (res){
            $('.editable-'+i).attr('disabled',true);
            $('.btn-edita-proc-'+i).show();
            $('.btn-salva-proc-'+i).hide();
            modal(res);
        }
    });
}

$('#cadastra-processador').validate({
    rules:{
        processador:{required:true},
        geracao:{required:true}
    },
    messages: {processador: "*",geracao:"*"},
    submitHandler: function(){
        cadastra('./app/sistema/ajax/cadastra.php','#cadastra-processador');
    }
});

$("#form-bancada-search").validate({
    onfocusout: false,
    onkeyup: false,
    rules:{
        patrimonio:{required:true,minlength:5,maxlength:7}
    },
    submitHandler: function(){
        $.post('./app/sistema/ajax/avalia.php',
                {
                    busca: $("#txtPatrimonio").val()
                }, function (res)
                {  
                    if($.isNumeric(res))
                    {avaliaEquipamento(res);}
                    else{modal(res);}
                });
    }
});
function avaliaEquipamento(id){
    $.ajax({
        url: './app/sistema/ajax/avalia.php',
        data:{ id:id},
        type:'POST',
        dataType:'HTML',
        success: function (res){
           $(".dados-avalia").html(res).css({'border-bottom':'2px solid #09f'});
           $(".conteudo-bancada").hide();
           $("#txtPatrimonio").val($("#valPatrimonio").val());
        }
    });
}
/*################# validação da avaliação ###########################*/

function validaAvaliacao(s,e,id,peca,tipo)/*s=status,e=equipamento,id=do cadastro do equipamento e peca=quantidade de agaurdo de peça,tipo = somente tecncios de bancada podem avaliar*/
{
    if(tipo=='bancada'){
        if(s=='4' && peca > 0){
             modal("<span class='alert alert-warning text-danger'>É PRECISO DAR BAIXA NAS PEÇA(S) QUE ESTE EQUIPAMENTO AGUARDA ANTES DE AVALIA-LO!</span>");
        }else{
            $.ajax({
                url: './app/sistema/ajax/valida-avaliacao.php',
                data:{equipamento:e,id:id},
                type:'POST',
                dataType:'HTML',
                beforeSend:function(){
                   $('.frm_load').fadeIn(500);
                },
                success: function (res){
                    $('.frm_load').fadeOut(500);
                    if(res){modal(res);}
                    else{
                        switch(s){
                            case '4':
                                $('.avaliacao').show();
                                $('.btn-avalia').show();
                                $('.aguardo-peca').hide();
                                break;
                            case '5':
                                $('.avaliacao').show();
                                $('.btn-avalia').show();
                                $('.aguardo-peca').show();
                                break;
                            default:
                               $('.aguardo-peca').hide();
                               $('.avaliacao').show();
                               $('.btn-avalia').show();
                       }
                   }
                }
            });
        }
    }else{
       modal("<span class='alert alert-warning text-danger'>VOCÊ NÃO TEM AUTORIZAÇÃO PARA AVALIAR EQUIPAMENTO!</span>");
    }
}
/*###################### avalia equipamento ##############################*/
function avalia(s,a,p){
    var word = $.trim(a).split(' ');
    if($.trim(s) == ''){
        $('#txtStatus').css({border: '.1rem solid #f00', background: '#ccc'});
        modal("<span class='alert alert-warning text-danger'>selecione um status!");
    }else if(s=='5' && $.trim(p) == ''){
         modal("<span class='alert alert-warning text-danger'>Por favor informe uma peça!");
    }else if(a.trim() == ''){
        $('#txtAvalia').css({border: '.1rem solid #f00', background: '#ccc'}).focus();
        modal("<span class='alert alert-warning text-danger'>É necessário informar uma avaliação!</span>");
    }else if(a.trim().length < 25 || word.length < 5){
        $('#txtAvalia').css({border: '.1rem solid #f00', background: '#ccc'}).focus();
        modal("<div class='alert alert-warning text-danger'><p>É necessário informar a avaliação com no minimo 25 caracteres e 5 palavras!</p><p>Por favor detalhe mais sua avaliação!</div>");
    }
    else{
        var dados = $("#form-avalia-equipamento").serialize();
                $.ajax({
                    url: './app/sistema/ajax/avaliacao.php',
                    data: dados,
                    type:'POST',
                    dataType:'HTML',
                beforeSend:function(){
                    $('.form_load').fadeIn(500);
                },
                success: function (res){
                    $('.form_load').fadeOut(500);
                    if(s=='4')
                    {modal(res,'index.php?pg=bancada');}
                    else{$('#form-bancada-search').submit();}
                   
                }
            });
    }
}


/*FIM DAS FUNCOES QUE VALIDA FOMULARIOS*/

function editaAvaliacao(s){
    if(s != ''){
        var dados = $("form.edita").serialize();
        $.ajax({url: './app/sistema/ajax/edita.php',
            data: dados,type:'POST',dataType:'HTML',
                success: function (res){
                    if(res){modal(res);}
                    else{
                        $('#form-bancada-search').submit();
                        $("#btnAtualizaEdicaoAvaliacao").trigger('click');
                    }
                }
            });
    }else
        modal('Informe um Status');
}
/*FUNCOES DE CADASTRO*/

 /*função generica que realiza o cadastro via ajax;
 url=</ pagina que recebera os dados;
 form= id no formato[#idform], do formulario que contem os dados para cadastro)
 */
function cadastra(url,form){
var dados = $(form).serialize();
    $.ajax({url: url,data: dados,type:'POST',dataType:'HTML',
            beforeSend:function(){
           $('.form_load').fadeIn(500);
            },
            success: function (res){
            $('.form_load').fadeOut(500);
             modal(res);
            }
        });
    return false;
}/*fim cadastra()*/

/*############### RELATÓRIOS ##############################*/

$("#form-header-report").validate({
    onfocusout: false,
    onkeyup: false,
    rules:{
        dt_inicial:{required:true},
        dt_final:{required:true}
    },
    submitHandler: function(){
        var dados = $("#form-header-report").serialize();
        $.ajax({
            url: './app/sistema/ajax/relatorio.php',
            data: dados,
            type:'POST',
            dataType:'HTML',
            beforeSend:function(){
                $('.form_load').fadeIn(500);
            },
            success: function (res){
                $('.form_load').fadeOut(500);
               
                $(".relatorio").html(res);

                $('.btnPrinter').show();
            }
        });
    }
});

$('#frm-g-entrada').validate({
    rules:{
        entrada:{required:true,number:true}
    },
    submitHandler: function(){
        var dados = $("#frm-g-entrada").serialize();
        $.ajax({
            url: './app/sistema/ajax/busca-entrada.php',
            data: dados,
            type:'POST',
            dataType:'HTML',
            beforeSend:function(){
                $('.form_load').fadeIn(500);
            },
            success: function (res){
                $('.form_load').fadeOut(500);
               
                $(".dados-edita-entrada").html(res);
            }
        });
    }
});

/*############# FIM RELATÓRIOS ############################*/

function show_modal(id,html)
{
    //pegando a altura e largura da janela
    var winH = $(window).height();
    var winW = $(window).width();
    $(id).show();$(id).html(html);
    $(id).dialog({
        resizable: false,
        height: (winH / 1.1),
        width: (winW / 1.1),
        modal: true,
        show    :{effect: "slideDown",duration:800},
        hide    : {effect: "slideUp",duration:800},
        buttons: {
            Imprimir: function(){$(id).printArea();},
            Fechar: function(){$( this ).dialog( "close" );}
        }
        /*close: function() {
            if(bancada){
                $( this ).dialog( "close" );
                 
                  history.go(0);
              }
          }*/
    });
}

function modal(html,link=null)
{
    $("#dialog").html(html);
    $("#dialog").dialog({
        width       : "auto",
        heigth      : "auto",
        modal       : true,
        minHeight   : 180,
        show    :{effect: "slideDown",duration:1000},
        hide    : {effect: "slideUp",duration:1000},      
        buttons: {
          "Ok": function(){$( this ).dialog( "close" );}
        },
        close: function() {
            if(link){
                $( this ).dialog( "close" );
                location.href=link;
              }
          }
    });
}


function redefineSenha()
{
    $("#modal-redefine-login").dialog({
        width       : "auto",
        heigth      : "auto",
        modal       : true,
        minHeight   : 250,
        show    :{effect: "slideDown",duration:1000},
        hide    : {effect: "slideUp",duration:1000}      
    });
}
