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
   })
      
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
