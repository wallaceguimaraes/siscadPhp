<?php
    
    include_once("dao/perfil_arquivo_dao.php");
    //include_once("model/perfil.php");    
    include_once("model/m_perfil_arquivo.php"); 

    class perfil_arquivo{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }


        function execute($acao){

            switch ($acao){                  
                    case "perfil_arquivo.inicio":$this->          inicio();break;
  //                  case "perfil.salvar":$this->           salvar();break;
                    case "perfil_arquivo.atualizar":$this->        atualizar();break;
                    case "perfil_arquivo.editar":$this->           editar();break;
    //                case "perfil.excluir":$this->          excluir();break;
     //               case "perfil.pesquisar":$this->        pesquisar();break;
                                        
                        }
                    }



/*
                    function excluir(){

                        //$perfil = new m_perfil();

                        $perfil_dao= new perfil_dao();
                        $resultado=$perfil_dao::excluir($_POST["id"]);

                        if($resultado===1){
                            // echo "Processo efetuado com sucesso!";
 
                         $filtro="";   
                         $lista=$perfil_dao::listar_perfil($filtro);
 
 
                         $msg = "Processo efetuado com sucesso!";    
                                                          
                          echo "view_perfil.html|"."tabela-resultado"."|".$msg."|".$lista;
                         }else{
                             echo "Ocorreu algum erro !";
                         }
                    }

*/



function atualizar(){

    //$perfil = new m_perfil();

    $perfil_arquivo_dao= new perfil_arquivo_dao();
    $resultado=$perfil_arquivo_dao::atualizar($_POST["perfil_id"],$_POST["arquivo_id"]);
    
  if($resultado===1){

    $resultado=$perfil_arquivo_dao::selecionar($_POST["perfil_id"]);

      
  }
echo $resultado;

}


                    function editar(){
                        //$perfil = new m_perfil();
                        $perfil_arquivo_dao= new perfil_arquivo_dao();
                        $resultado=$perfil_arquivo_dao::selecionar($_POST["id"]);                        
                        echo "Ajustar permissões do perfil¨".$resultado;
                    }

                    /*
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
                           // echo "Processo efetuado com sucesso!";


                        $filtro="";   
                        $lista=$perfil_dao::listar_perfil($filtro);


                        $msg = "Processo efetuado com sucesso!";    
                            
                            
                            
                            
                         echo "view_perfil.html|"."tabela-resultado"."|".$msg."|".$lista;

                        }else{
                            echo "Ocorreu algum erro !";
                        }


                    }
                    
                    */
                    function inicio(){
            
                       echo "view_perfil_arquivo.php|tela-cadastro|Montar perfil";
             
                    }


/*
                    function listar(){


                        $perfil_dao = new perfil_dao();

                        $filtro="";
                        $lista=$perfil_dao::listar_perfil($filtro);

                        echo "view_perfil.html|"."tabela-resultado"."|".$lista;

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
                        echo "view_perfil.html|"."tabela-resultado"."|".$lista;


                    }


*/

                }
              




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





