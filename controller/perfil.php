<?php
    
    include_once("dao/perfil_dao.php");
    //include_once("model/perfil.php");    
    include_once("model/m_perfil.php"); 

    class perfil{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

        function execute($acao){
  
                    switch ($acao){                  
                    case "perfil.inicio":$this->          inicio();break;
                    case "perfil.salvar":$this->           salvar();break;
                    case "perfil.listar":$this->           listar();break;
                    case "perfil.editar":$this->           editar();break;
                    case "perfil.excluir":$this->          excluir();break;
                    case "perfil.pesquisar":$this->        pesquisar();break;
                    case "perfil.visualizar":$this->        visualizar();break;
                                        
                        }
                    }




                    function excluir(){

                        //$perfil = new m_perfil();

                        $perfil_dao= new perfil_dao();
                        
                        $resultado=$perfil_dao::excluir($_POST["id"]);
                        if($resultado===1){
                            // echo "Processo efetuado com sucesso!";
                         $filtro="";   
                         $lista=$perfil_dao::listar_perfil($filtro);
 
 
                         $msg = "Processo efetuado com sucesso!";    
                             
                             
                             
                             
                          echo "view_perfil.html|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar perfil";
 
                         }else{
                             echo "Ocorreu algum erro !";
                         }




                    }




                    function editar(){

                        //$perfil = new m_perfil();

                        $perfil_dao= new perfil_dao();
                        $ativo="";
                        $resultado=$perfil_dao::selecionar($_POST["id"],$ativo);
                        echo "Editar perfil¨".$resultado;


                    }




                    function visualizar(){

                        //$categoria = new m_categoria();
                        $perfil_dao= new perfil_dao();
                        $ativo="disabled";
                        $resultado=$perfil_dao::selecionar($_POST["id"],$ativo);
                        echo "Visualizar perfil¨".$resultado;
                        //echo $resultado;

                    }



                    function salvar(){
                        $perfil = new m_perfil();    
                        $perfil->set__perfil($_POST["perfil"]);
                        $perfil->set__descricao($_POST["desc"]);
                        if($_POST["id"]>0){
                            $perfil->set__perfil__id($_POST["id"]);
                            $perfil->set__ativo($_POST["ativo"]);
                            $perfil_dao = new perfil_dao();
                            $resultado=$perfil_dao::atualizar($perfil);
                            
                        }else{
                                                 
                            $perfil_dao = new perfil_dao();
                            $resultado =$perfil_dao::salvar($perfil);                 
                        }
                        if($resultado===1){
                        $filtro="";   
                        $lista=$perfil_dao::listar_perfil($filtro);
                        $msg = "Processo efetuado com sucesso!";                                
                        echo "view_perfil.html|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar perfil";
                        }else{
                            echo "Ocorreu algum erro !";
                        }
                    }
                    
                    function inicio(){
                       echo "view_perfil.html|tela-cadastro|Cadastro de perfil";             
                    }

                    function listar(){
                        $perfil_dao = new perfil_dao();
                        $filtro="";
                        $lista=$perfil_dao::listar_perfil($filtro);
                        echo "view_perfil.html|"."tabela-resultado"."|".$lista."|Pesquisar perfil";
                    }

                    function pesquisar(){

                        $perfil = new m_perfil();    
                        $perfil->set__perfil($_POST["perfil"]);
                        $perfil->set__ativo($_POST["ativo"]);
                        $perfil_dao = new perfil_dao();
                        $filtro                         =array();
                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        $filtro[]="p.ativo='".$_POST["ativo"]."'";
                        if($_POST["perfil"]!==''){$filtro[]="p.perfil like '%". strToUpper($_POST["perfil"])."%'";}                
                
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                        $lista=$perfil_dao::listar_perfil($filtro);
                        echo "view_perfil.html|"."tabela-resultado"."|".$lista."|Pesquisar perfil";
                    }
                }
              




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





