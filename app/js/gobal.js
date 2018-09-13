/* by Leandro Pereira*/

 
$( ".tabs" ).tabs({
      beforeLoad: function( e, ui ) {
        ui.jqXHR.fail(function() {
          ui.panel.html(
            "<div class='text-center'><img src='./app/imagens/loader-lg.gif' alt='carregando...' title='carregando...' /></div>");
        });
      },
      /*event: "mouseover"*/
      show: { 
          effect: "blind", duration: 500
      }
   });
      
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
               $('.j_Aviso').addClass('alert alert-warning').text(res).slideDown(800);
           }else{
               setTimeout(function(){
                   location.href='http://localhost/syslab/index.php?ref=home';
               },1000)
           }
          }
      });
}

       
function getModelos(fab)/*essa função busca cidades e preenche um combo com as cidades e cep*/
{
    $.post('./app/sistema/ajax/buscamodelos.php',
            {
                fabricante: fab
            }, function (res){
                if(res){
                    $("#txtModelo").attr('disabled', false);
                    $("#txtModelo").children(".cmbv_modelos").remove();
                    $("#txtModelo").append(res);
                }
                else{
                    $("#txtModelo").children(".cmbv_modelos").remove();
                    $("#txtModelo").append("<option value='' class='cmbv_modelos'>Selecione..</option>");
                    $('#txtModelo').attr('disabled',true);
                }
            });
}  

function setCadEquipamento(e){
   switch(e){
        case '1':
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
}

/*mascaras de campos*/
$(function() {
        $.mask.definitions['~'] = "[+-]";
        $(".m_key").mask("99999-99999-99999-99999-99999");
        $("#txtIp").mask("999.999.999.999");
    });
/*fim das mascaras de campos*/

/*FUNÇÕES QUE VALIDA FORMULARIOS*/
$(document).ready(function(){
    $('#cadastra-windows').validate({
        rules:{
            windows:{
                required: true,
                minlength: 9,
                maxlength: 15,
                minWords: 2
            },
            VersaoWindows:{
                required: true,
                minlength: 4,
                maxlength: 15
            },
            ArquiteturaSo:{
                required: true
            }
        },
        submitHandler: function(){
            cadastra('software','windows');
        }
    });
    
    $('#cadastra-office').validate({
        rules:{
            office:{
                required: true,
                minlength: 9,
                maxlength: 15,
                minWords: 2
            },
            versaoOffice:{
                required: true,
                minlength: 4,
                maxlength: 15
            },
            arquiteturaOffice:{
                required: true
            }
        },
        submitHandler: function(){
            cadastra('software','office');
        }
            
    });
});
/*
function validaCadastro(c,p=null){
    
    switch(c){
        case 'software':
            if(p=='windows'){
                if($.trim($('#txtWindows').val()) == ""){
                    $('#txtWindows').focus().css({border:'1px solid #f00'});
                }else if($.trim($('#txtVersaoWindows').val()) == ""){
                    $('#txtVersaoWindows').focus().css({border:'1px solid #f00'});
                }else if($.trim($('#txtArquiteturaSo').val()) == ""){
                    $('#txtArquiteturaSo').focus().css({border:'1px solid #f00'});
                }else{cadastra(c,p)}
            }else if(p == 'office'){
                if($.trim($('#txtOffice').val()) == ""){
                    $('#txtOffice').focus().css({border:'1px solid #f00'});
                }else if($.trim($('#txtVersaoOffice').val()) == ""){
                    $('#txtVersaoOffice').focus().css({border:'1px solid #f00'});
                }else if($.trim($('#txtArquiteturaOffice').val()) == ""){
                    $('#txtArquiteturaOffice').focus().css({border:'1px solid #f00'});
                }else{cadastra(c,p)}
            }
            break;
        default:
            alert('algo deu errado!');
    }
    
}
*/
/*FIM DAS FUNCOES QUE VALIDA FOMULARIOS*/

/*FUNCOES DE CADASTRO*/

function cadastra(e,s = null)
{
    switch(e){
        case 'equipamento':
                $.ajax({
                url:'./app/sistema/ajax/cadastra.php',
                data:{
                    acao:e,
                    equipamento: $('#txtEqpmt').val(),
                    fabricante:$('#txtFab').val(),
                    modelo: $('#txtModelo').val(),
                    serie:$('#txtSerie').val(),
                    patrimonio:$('#txtPatrimonio').val(),
                    localidade:$('#txtLocalidade').val(),
                    so: $('#txtSo').val(),
                    keyso: $('#txtKeySo').val(),
                    office: $('#txtOffice').val(),
                    keyoffice:$('#txtKeyOffice').val(),
                    memoria: $('#txtMemoria').val(),
                    hd: $('#txtHd').val(),
                    tela: $('#txtTela').val(),
                    tipotela: $('#txtTipoTela').val(),
                    va: $('#txtVa').val(),
                    ip: $('#txtIp').val()
                },
                type:'POST',
                dataType:'HTML',
                    beforeSend:function(){
                   $('.form_load').fadeIn(500);
                    },
                    success: function (res){
                 console.log(res);
                    }
                });
            break;
        case 'software':
                if(s =='windows'){
                    software    = $('#txtWindows').val();
                    versao      = $('#txtVersaoWindows').val();
                    arquitetura = $('#txtArquiteturaSo').val();
                }
                else{
                    software    = $('#txtOffice').val();
                    versao      = $('#txtVersaoOffice').val();
                    arquitetura = $('#txtArquiteturaOffice').val();
                }
                if($.trim(software) != "" && $.trim(versao) != "" && $.trim(arquitetura) != ""){
                $.ajax({
                url:'./app/sistema/ajax/cadastra.php',
                data:{
                    acao:e,
                    tipo:s,
                    software:       software,
                    versao:         versao,
                    arquitetura:    arquitetura
                },
                type:'POST',
                dataType:'HTML',
                    beforeSend:function(){
                   $('.form_load').fadeIn(1000);
                    },
                    success: function (res){
                    $('.form_load').fadeOut(500);
                    $('.msg').slideDown(500).text(res);
                    }
                });
            }else{
                $('.msg').removeClass('alert-success');
                $('.msg').addClass('alert-warning').text('Todos os campos devem ser preenchidos!').slideDown(500);
            }
            break;
        default:
            dados=null;
            
    }
}

/*FIM DAS FUNCOES DE */