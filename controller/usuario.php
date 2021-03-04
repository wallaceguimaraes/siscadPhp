<?php
    
    include_once("dao/usuario_dao.php");
    //include_once("model/categoria.php");    
    include_once("model/m_usuario.php"); 
    include_once("controller/historico.php"); 

    class usuario{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

        function execute($acao){
  
                    switch ($acao){                  
                    case "usuario.inicio":$this->          inicio();break;
                    case "usuario.salvar":$this->           salvar();break;
                    case "usuario.atualizar":$this->        atualizar();break;
                    case "usuario.listar":$this->           listar();break;
                    case "usuario.editar":$this->           editar();break;
                    case "usuario.excluir":$this->          excluir();break;
                    case "usuario.pesquisar":$this->        pesquisar();break;
                    case "usuario.visualizar":$this->       visualizar();break;
                    case "usuario.atualizarUsuario":$this-> atualizarUsuario();break;
                    case "usuario.validaSenha":$this-> validaSenha();break;
                                        
                        }
                    }


                    function validaSenha(){

                        $usuario_Dao = new usuario_dao();
                       

                        $resultado =$usuario_Dao::validaSenha($_POST["senha"],$_POST["sessao"]);  
                         

                            echo $resultado;               
                     

                        

                    }



                    function excluir(){

                        $usuario_dao= new usuario_dao();
                        $resultado=$usuario_dao::excluir($_POST["id"]);


                        if($resultado>0){
                      
                      
                      
                         $filtro="";   
                         $lista=$usuario_dao::listar_usuario($filtro);
 
                         $msg = "Processo efetuado com sucesso!";    
                                                          
                          echo "view_categoria.html|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar usuário";
 
                         }else{
                             echo "Ocorreu algum erro !";
                         }
                    }


                    function editar(){

                        //$categoria = new m_categoria();

                        $usuario_dao= new usuario_dao();
                        $ativo="";
                        $resultado=$usuario_dao::selecionar($_POST["id"],$ativo);
                        echo "Editar usuário¨".$resultado;

                    }


                    function atualizarUsuario(){

                        $usuario_dao= new usuario_dao();
                        $ativo="";
                        $resultado=$usuario_dao::selecionar2($_POST["sessao__"]);
                        echo "Atualizar dados do seu usuário¨".$resultado;

                    }



                    function visualizar(){

                        //$categoria = new m_categoria();
                        $usuario_dao= new usuario_dao();
                        $ativo="disabled";
                        $resultado=$usuario_dao::selecionar($_POST["id"],$ativo);
                        echo "Visualizar usuário¨".$resultado;
                        //echo $resultado;

                    }






                    function atualizar(){
                        
                        $usuario = new m_usuario();    
                        //$usuario->set__perfil__id($_POST["perfil_id"]);
                        $usuario->set__nome($_POST["nome"]);
                        $usuario->set__contato($_POST["contato"]);
                        $usuario->set__email($_POST["email"]);
                        $usuario->set__login($_POST["login"]);
                        $usuario->set__senha($_POST["senha"]);
                        $usuario->set__sessao($_POST["sessao"]);

                            $usuario_dao = new usuario_dao();
                            $resultado=$usuario_dao::atualizarDados($usuario);
                        
                            if($resultado > 0){

                                if($resultado===1){$resultado="ATUALIZAÇÃO DE USUÁRIO";}
    
                                $identificador="";
                                 if($_POST["id"]>0){
                                    $identificador=$_POST["id"];
                                 } 
    
                            $historico = new historico();
                            $historico->executar("historico.salvar",$_POST["sessao"],$resultado,$identificador);    
    
                        $filtro=$_POST["sessao"];   
                        $lista=$usuario_dao::selecionar2($filtro);
                        $msg = "Processo efetuado com sucesso!";                                        
                        echo "view_usuario.php|"."tabela-resultado"."|".$msg."|".$lista."|Atualizar dados do seu usuário";                                    
                        }else{
                            echo "Ocorreu algum erro !";
                        }

                    }






                    function salvar(){
                        
                        $usuario = new m_usuario();    
                        $usuario->set__perfil__id($_POST["perfil_id"]);
                        $usuario->set__nome($_POST["nome"]);
                        $usuario->set__contato($_POST["contato"]);
                        $usuario->set__email($_POST["email"]);
                        $usuario->set__login($_POST["login"]);
                        $usuario->set__senha($_POST["r-senha"]);
                        //$usuario->set__sessao($_POST["sessao"])

                        if($_POST["id"]>0){//Editando
                            $usuario->set__usuario__id($_POST["id"]);
                            $usuario->set__ativo($_POST["ativo"]);
                            $usuario_dao = new usuario_dao();
                            $resultado=$usuario_dao::atualizar($usuario);
                        }else{
                            $usuario_dao = new  usuario_dao();
                            $resultado =$usuario_dao::salvar($usuario);                 
                        }
                        
                        
                        if($resultado===1){
                        $filtro="";   
                        $lista=$usuario_dao::listar_usuario($filtro);
                        $msg = "Processo efetuado com sucesso!";                                        
                        echo "view_usuario.php|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar usuário";                                    
                        }else{
                            echo "Ocorreu algum erro !";
                        }

                    }
                    
                    
                    function inicio(){
            
                       echo "view_usuario.php|tela-cadastro|Cadastro de usuário";
             
                    }



                    function listar(){


                        $usuario_dao = new usuario_dao();

                        $filtro="";
                        $lista=$usuario_dao::listar_usuario($filtro);

                        echo "view_usuario.php|"."tabela-resultado"."|".$lista."|Pesquisar usuários";

                    }



                    function pesquisar(){

                        $usuario = new m_usuario();    
                        $usuario->set__nome($_POST["nome"]);
                        $usuario->set__email($_POST["cpf"]);
                        $usuario->set__ativo($_POST["ativo"]);
                        $usuario_dao = new usuario_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        $filtro[]="u.ativo='".$_POST["ativo"]."'";
                        if($_POST["nome"]!==''){$filtro[]="u.usuario_nome like '%". strToUpper($_POST["nome"])."%'";}                
                        if($_POST["email"]!==''){$filtro[]="u.email like '%". strToUpper($_POST["email"])."%'";}                
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                       

                        $lista=$usuario_dao::listar_usuario($filtro);
                        echo "view_usuario.php|"."tabela-resultado"."|".$lista."|Pesquisar usuário";
                    }
                    
                }
              




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





