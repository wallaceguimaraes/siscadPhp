

function requisitar(acao){
           

  
    $.ajax({
      //url: "dao/LoginDao.php",
      url: "index.php",
      type: 'POST',
      beforeSend: function(){
        $("#resposta").css("display","none");
        $("#loader").show("fast");
       },
      data: {
          login: $('#login').val(),
          senha: $('#senha').val(),
          acao: acao      },     
       success: function(data){              
       // resultado = data.split(",");
        //alert(data);
        console.log(data)

        if(data!=0){
          $("#resposta").css("display","none");        

          tela=data.split("|");
       
         sessionStorage.setItem('variaveis',tela[1]);
          window.location = tela[0];

        }else{
          $("#resposta").show("fast");        
          $("#loader").hide("fast");

        $('#resposta').html("Login ou senha incorretos!");
        setTimeout(function() {
          $('#resposta').fadeOut('fast');
       }, 2000);
              
        }
      },
      error: function(error){
        alert(error);
          $('#load').html("Página nao encontrada!");
      }
    });
    

}










$(document).ready(function () {
  $("#loader").hide();

  $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
  });
});






function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}



/*
function valida_usuario(){


  
  var usuario = {
    'login': $('#login').val(),
    'senha': $('#senha').val()
  }

  let chamada = 'valida__usuario';

  let acao = JSON.stringify(chamada);

  var dados = JSON.stringify(usuario);

  $.ajax({
    url: "controller/loginController.php",
    type: "POST",
    assync: false,
    data: {data: dados,
           acao: acao },
    beforeSend: function () {
      //Aqui adicionas o loader
      document.getElementById("loader").style.display='block';
      sleep(400); 
    },
    dataType: "html"

}).done(function(resposta){
  
window.location.href("../view/menuPrincipal.html");

}).fail(function(jqXHR, textStatus ) {
    console.log("Requisicao falhou!: " + textStatus);

    //alert("Erro".textStatus);
}).always(function() {
    console.log("completou");
    document.getElementById("loader").style.display="none";
  

 
});
}

*/



























function valida_login(){

  let login = $('#login').val();
    let senha = $('#senha').val();
    let acao = "valida_usuario";
  

  $.ajax({
    url : "../controller/LoginController.php",
    type : 'post',
    data : {
         login : login,
         senha :senha,
         acao: acao
    },
    beforeSend : function(){
         $("#mensagem").html("ENVIANDO...");
    }
})
.done(function(msg){
    $("#mensagem").html(msg);
})
.fail(function(jqXHR, textStatus, msg){
    alert(msg);
});

}