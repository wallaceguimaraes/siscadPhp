<?php
    include_once("dao/categoria_dao.php");
    
    //include_once("model/categoria.php");    
    include_once("model/m_categoria.php"); 

    class categoria{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

        function execute($acao){
  
                    switch ($acao){                  
                    case "categoria.inicio":$this->          inicio();break;
                    case "categoria.salvar":$this->           salvar();break;
                    case "categoria.listar":$this->           listar();break;
                    case "categoria.editar":$this->           editar();break;
                    case "categoria.excluir":$this->          excluir();break;
                    case "categoria.pesquisar":$this->        pesquisar();break;
                    case "categoria.visualizar":$this->       visualizar();break;
                                        
                        }
                    }




                    function excluir(){

                        //$categoria = new m_categoria();
                      


                        $categoria_dao= new categoria_dao();
                        $resultado=$categoria_dao::excluir($_POST["id"]);

                        if($resultado===1){
                            // echo "Processo efetuado com sucesso!";
 
                         $filtro="";   
                         $lista=$categoria_dao::listar_categoria($filtro);
 
 
                         $msg = "Processo efetuado com sucesso!";    
                             
                             
                             
                             
                          echo "view_categoria.html|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar categorias";
 
                         }else{
                             echo "Ocorreu algum erro !";
                         }




                    }




                    function editar(){

                        //$categoria = new m_categoria();
                        $categoria_dao= new categoria_dao();
                        $ativo="";
                        $resultado=$categoria_dao::selecionar($_POST["id"],$ativo);
                        echo "Editar categoria¨".$resultado;
                        //echo $resultado;

                    }



                    function visualizar(){

                        //$categoria = new m_categoria();
                        $categoria_dao= new categoria_dao();
                        $ativo="disabled";
                        $resultado=$categoria_dao::selecionar($_POST["id"],$ativo);
                        echo "Visualizar categoria¨".$resultado;
                        //echo $resultado;

                    }





                    function salvar(){
                        $categoria = new m_categoria();    
                        $categoria->set__categoria($_POST["categoria"]);
                   
                        if($_POST["id"]>0){
                            $categoria->set__categoria__id($_POST["id"]);
                            $categoria->set__ativo($_POST["ativo"]);
                            $categoria_dao = new categoria_dao();
                            $resultado=$categoria_dao::atualizar($categoria);                            
                        }else{
                            $categoria_dao = new categoria_dao();
                            $resultado =$categoria_dao::salvar($categoria);                 
                        }
                        if($resultado===1){
                        $filtro="";   
                        $lista=$categoria_dao::listar_categoria($filtro);
                        $msg = "Processo efetuado com sucesso!";        
                         echo "view_categoria.html|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar categorias";
                        }else{
                            echo "Ocorreu algum erro !";
                        }
                    }
                                        
                    function inicio(){
            
                       echo "view_categoria.html|tela-cadastro|Cadastro de categoria";
             
                    }



                    function listar(){


                        $categoria_dao = new categoria_dao();

                        $filtro="";
                        $lista=$categoria_dao::listar_categoria($filtro);

                        echo "view_categoria.html|"."tabela-resultado"."|".$lista."|Pesquisar categorias";

                    }



                    function pesquisar(){

                        $categoria = new m_categoria();    
                        $categoria->set__categoria($_POST["categoria"]);
                        $categoria->set__ativo($_POST["ativo"]);

                        $categoria_dao = new categoria_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        $filtro[]="c.ativo='".$_POST["ativo"]."'";
                        if($_POST["categoria"]!==''){$filtro[]="c.categoria like '%". strToUpper($_POST["categoria"])."%'";}                
                
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                        $lista=$categoria_dao::listar_categoria($filtro);
                        echo "view_categoria.html|"."tabela-resultado"."|".$lista."|Pesquisar categorias";


                    }




                }
              




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





