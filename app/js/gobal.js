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
               $('.j_Aviso').addClass('alert alert-warning').text(res).slideDown(800);
           }else{
               setTimeout(function(){
                   location.href='http://localhost/syslab/index.php?ref=home';
               },1000)
           }
          }
      });
}/*FIM LOGIN*/

/*PEGA OS MODELOS DE EQUIPAMENTO CONFORME O FABRICANTE ESCOLHIDO*/     
function getModelos(fab)
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
}/*FIM GETMODELOS*/  

/*MOSTRA E OCUPA CAMPOS OPCIONAIS NO CADASTRO DE EQUIPAMENTO*/
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
}/*FIM SETCADEQUIPAMENTO*/

/*mascaras de campos*/
$(function() {
        $.mask.definitions['~'] = "[+-]";
        $(".m_key").mask("99999-99999-99999-99999-99999");
        $("#txtIp").mask("999.999.999.999");
        $("#txtContatoUser").mask("(99)9999-9999");
        $("#txtCelularUser").mask("(99)99999-9999");
    });
    
/*fim das mascaras de campos*/

/*FUNÇÕES QUE VALIDA FORMULARIOS*/
$(document).ready(function(){
    $('#searchos').hide();
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
    
    
    /*CADASTRO DE EQUIPAMENTO*/
    $('#cad-equip').validate({
            rules:{
                equipamento :{required:true},
                fabricante  :{required:true},
                modelo      :{required:true},
                serie       :{required:true,minlength:5},
                patrimonio  :{required:true,minlength:6,maxlength:7},
                localidade  :{required:true}
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
    

    /*PESQUISA PATRIMONIO*/
    $('#formSearch').validate({
        onfocusout: false,
        onkeyup: false,
        rules:{
            busca: {
                    required: true,
                    minlength: 6,
                    maxlength:7,
                    onkeyup:false
                }
                },
            messages: {busca:"Patrimonio Inválido"},
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
    });/*FIM DA PESQUISA DE os*/

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
    $('#cadastra-status').validate({
       rules:{
           nomeStatus    :{required:true},
           corStatus    :{required:true}
       },
       submitHandler: function(){
            cadastra('./app/sistema/ajax/cadastra.php','#cadastra-status');
        }
    });
/*CADASTRA STATUS*/

/*FIM DO CADASTRO DE STATUS*/
});/*fim do document ready*/

/*FIM DAS FUNCOES QUE VALIDA FOMULARIOS*/

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
            /*var formAll = $('main form *');
            formAll.val('');*/
            $('.form_load').fadeOut(500);
             modal(res);
            }
        });
    return false;
}/*fim cadastra()*/

/*FIM DAS FUNCOES DE */
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
           Fechar: function() {
            $( this ).dialog( "close" );
        }
      }
    });
}

function modal(html)
{
    $("#dialog").html(html);
    $("#dialog").dialog({
        width       : "auto",
        heigth      : "auto",
        modal       : true,
        minHeight   : 180,
        show    :{effect: "fold",duration:1000},
        hide    : {effect: "fold",duration:1000},
        close: function( event, ui ) {window.location.reload(true);}
        /*
        buttons: {
          "Fechar": function() {
            $( this ).dialog( "close" );
          }
    }*/
    });
}


