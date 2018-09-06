/* by Leandro Pereira*/

 //carregando modulo visualization
      google.load("visualization", "1", {packages:["corechart"]});


$( ".tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.fail(function() {
          ui.panel.html(
            "<div class='alert alert-danger' role='alert'>Erro ao incluir arquivo, por favor contato o desenvolvedor " +
            "resolveremos o quanto antes o problema.</div>" );
        });
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
               $('.j_Aviso').fadeIn(1000).html(res);
           }else{
               setTimeout(function(){
                   location.href='http://localhost/syslab/index.php?ref=home';
               },1000)
           }
          }
      });
}
