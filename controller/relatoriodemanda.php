<?php    

include_once("dao/relatorioDemanda_dao.php");
    
//include_once("model/categoria.php");    
include_once("model/m_relatorioDemanda.php"); 


    
    class relatoriodemanda{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

        function execute($acao){
  
                    switch ($acao){                  
                    case "relatoriodemanda.inicio":$this->          listar();break;
                    case "relatoriodemanda.pesquisar":$this->       pesquisar();break;
                    
                        }
                    }





    
                    function visualizar(){

                        //$categoria = new m_categoria();
                        $categoria_dao= new categoria_dao();
                        $ativo="disabled";
                        $resultado=$categoria_dao::selecionar($_POST["id"],$ativo);
                        echo "Visualizar categoria¨".$resultado;
                        //echo $resultado;

                    }



                    function listar(){


                        $relatorio_dao = new relatorioDemanda_dao();

                        $filtro="";
                        $lista=$relatorio_dao::listar_relatorio($filtro);

                        echo "moduloRelatorio.html|"."tabela-resultado"."|".$lista."|Relatório de demanda";

                    }


                    function pesquisar(){



                        $relatorioDemanda_dao = new relatorioDemanda_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        //$filtro[]="d.ativo='".$_POST["ativo"]."'";
                        if($_POST["pessoa"]!==''){$filtro[]="p.pessoa like '%".$_POST["pessoa"]."%'";}                
                        if($_POST["demanda"]!==''){$filtro[]="d.demanda like '%". strToUpper($_POST["demanda"])."%'";}                
                        if($_POST["data-demanda-relatorio"]!==''){
                            $data=str_replace("/", "-", $_POST["data-demanda-relatorio"]);
                            $data=date( "Y-m-d", strtotime($data));

                            $filtro[]="d.data_cadastro like '%".$data."%'";}                
                        if($_POST["status"]!==''){
                            $filtro[]="d.status like '%". strToUpper($_POST["status"])."%'";}                
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                        $id="";



                        //$filtro="";
                        $lista=$relatorioDemanda_dao::listar_relatorio($filtro);

                        echo "moduloRelatorio.html|"."tabela-resultado"."|".$lista."|Relatório de demanda";

                       

                    }




                }
              




    

