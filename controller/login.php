    <?php
    
    include_once("dao/login_dao.php");
    include_once("model/m_usuario.php");    


    class login{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }




        function execute($acao){
           switch ($acao){
                    case "login.valida_login":$this->    valida_login(); break;
                    case "login.inicio":$this->          inicio();break;
                    case "login.log-off":$this->          sair();break;
                                         
                        }
                    }


                    function valida_login(){

                        $usuario = new m_usuario();
                        $usuario->set__login($_POST["login"]);
                        $usuario->set__senha($_POST["senha"]); 

                   
                        $loginDao = new login_dao();

                        $resultado =$loginDao::valida_login($usuario);  
                        echo $resultado;               

                    }
                    
                    
                    function inicio(){

                        
                        echo "index.php|login";


 
 
                    }


                    function sair(){

                        


                       session_start();
                        
                       if(isset($_SESSION['sessao'])){
                        session_destroy();
                    //    echo "../login.html";
                        
                        $newURL="login.html";

                        header('Location: '.$newURL);

                    
                       }


                       
 
 
                    }




                }
              




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





