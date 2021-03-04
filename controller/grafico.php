<?php
    include_once("dao/grafico_dao.php");
    
    //include_once("model/m_categoria.php"); 

    class grafico{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

        function execute($acao){
  

                    switch ($acao){                  
                    case "grafico.preenche":$this->          preenche();break;
                    case "grafico.inicio":$this->            inicio();break;
                                        
                        }
                    }




                    function preenche(){
                        
                        $grafico_dao= new grafico_dao();

                        
                         $tabela=$grafico_dao::listar_pessoa_demanda();
                         $lista=$grafico_dao::preenche();
               
                        echo $lista."|".$tabela;
                       // echo $lista;
                  
                    }
















                                        
                    function inicio(){
            







                       echo "view_grafico.html|grafico|Seja bem vindo!";
             
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





