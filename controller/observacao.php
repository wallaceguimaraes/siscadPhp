<?php
    
    include_once("dao/observacao_dao.php");
    include_once("dao/demanda_dao.php");
    include_once("controller/historico.php"); 
    //include_once("model/demanda.php");    
    include_once("model/m_observacao.php"); 

    class observacao{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

       


        function execute($acao){
           
                    switch ($acao){                  


                    case "observacao.iniciar":$id="";        $this->iniciar($id,"","");break;
                    case "observacao.salvar":$this->           salvar();break;
                    case "observacao.listar":$this->           listar();break;
                    case "observacao.editar":$this->           editar();break;
                    case "observacao.excluir":$this->          excluir();break;
                    case "observacao.pesquisar":$this->        pesquisar();break;
                    case "observacao.visualizar":$this->        visualizar();break;
                                        
                        }
                    }

                                  
                    function excluir(){
                    
                        $observacao_dao= new observacao_dao();
                        $resultado=$observacao_dao::excluir($_POST["id"]);
                        if($resultado>0){
                            // echo "Processo efetuado com sucesso!";
                            if($resultado===1){$resultado="EXCLUSÃO DA OBSERVAÇÃO";}
                            
                            $identificador="";
                         if($_POST["id"]>0){
                            $identificador=$_POST["id"];
                         }       
                         
                        

                            
                        $historico = new historico();
                        $historico->executar("historico.salvar",$_POST["sessao__"],$resultado,$identificador);    

                            
                        $filtro="and o.demanda_id=".$_POST["aux_id"]."";

                        $this->iniciar($filtro,"");

 /*                        
                         $lista=$observacao_dao::listar_observacao($filtro,"");
   
                         $msg = "Processo efetuado com sucesso!";    
                          echo "view_observacao.html|"."lista"."|".$msg."|".$lista."|Observações"."|"."Observações"."|"."Observações";
 */
                         }else{
                             echo "Ocorreu algum erro !";
                         }

                    }


/*

                    function editar(){

                        //$demanda = new m_demanda();
                        $demanda_dao= new demanda_dao();
                        $resultado=$demanda_dao::selecionar($_POST["id"]);
                        //echo "view_demanda.html|"."tela-cadastro".$resultado."Cadastrar demanda";

                        echo "Cadastrar demanda¨".$resultado."¨identificacao";

                    }

                    */

                    function visualizar(){

                        //$demanda = new m_demanda();
                        
                        $observacao_dao= new observacao_dao();
   
                        $ativo="disabled";

                       

                        $resultado=$observacao_dao::selecionar2($_POST["id"],$ativo,$_POST["estado"]);
                        

                        //echo "view_demanda.html|"."tela-cadastro".$resultado."Cadastrar demanda";


                        echo "Visualizar Observacao¨".$resultado."¨identificacao";
                    }



                    function salvar(){




                        $observacao = new m_observacao();    
                        $observacao->set__demanda__id($_POST["demanda_id"]);
                        $observacao->set__observacao($_POST["observacao"]);

                        if($_POST["id"]>0){
                            $observacao->set__demanda__id($_POST["id"]);
                            
                            $observacao_dao = new observacao_dao();
                            $resultado=$demanda_dao::atualizar($demanda);                            
                        }else{
                            $observacao_dao = new observacao_dao();
                            $resultado =$observacao_dao::salvar($observacao);                 
                        }
                       

                        if($resultado>0){
                       
                            if($resultado===1){$resultado="CADASTRO DA OBSERVAÇÃO";}
                            if($resultado===2){$resultado="ATUALIZAÇÃO DA OBSERVAÇÃO";}
                            $identificador="";
                         if($_POST["id"]>0){
                            $identificador=$_POST["id"];
                         }       
                         
                            
                        $historico = new historico();
                        $historico->executar("historico.salvar",$_POST["sessao"],$resultado,$identificador);    

                     


                        $filtro="and o.demanda_id=".$observacao->get__demanda__id()."";

                     
                       
                       
                        $lista=$observacao_dao::listar_observacao($filtro,$_POST["demanda_id"],2,$_POST["estado"]);
                        $msg = "Processo efetuado com sucesso!";        
                         echo "view_observacao.html|"."lista"."|".$msg."|".$lista."|Observações"."|"."Observações"."|"."Observações";
                        
                        }else{
                            echo "Ocorreu algum erro !";
                        }
                    }
    

                    function iniciar($id,$pesquisa,$estado){

                     


                        $observacao_dao = new observacao_dao();
                        $filtro="";
                        if($id==="")
                        $filtro="and d.demanda_id=".$_POST["id"];
                        else{
                            $filtro=$id;
                        }

                     
                        if($pesquisa==="pesquisar"){
                            $flag=2;
                        }else{
                            $flag=1;
                        }

                        if(isset($estado)|$estado!==""){
                          $estado=$_POST["estado"];
                        }

                        if(isset($_POST["estado"])){
                            $estado=$_POST["estado"];
                        }


                    

                        $lista=$observacao_dao::listar_observacao($filtro,"",$flag,$estado);
                   

                        //echo "view_observacao.php|"."inicial"."|".$lista."|Observações";
                        
                        if($pesquisa!==""){

                       
                            echo "view_observacao.html|"."inicial"."|Nada|".$lista."|Observações|"."Observações";
                     }else{
                            echo "view_observacao.html¨"."inicial"."¨".$lista."¨Observações¨"."Processo efetuado com sucesso!";
                        }
                        //echo "view_demanda.html|tela-cadastro|Cadastro de demanda";
             
                    }


                    function pesquisar(){
                        $observacao_dao = new observacao_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        //$filtro[]="d.ativo='".$_POST["ativo"]."'";
                        if($_POST["demanda_id"]!==''){$filtro[]="and o.demanda_id=".$_POST["demanda_id"]."";}                
                        if($_POST["observacao"]!==''){$filtro[]="o.observacao like '%". strToUpper($_POST["observacao"])."%'";}                
                        if($_POST["cadastro-obs"]!==''){
                            
                            $data=str_replace("/", "-", $_POST["cadastro-obs"]);
                            $data=date( "Y-m-d", strtotime($data));
                            $filtro[]="o.data_cadastro like '%".$data."%'";}                                  
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }    
                    


                        $pesquisa="pesquisar";
                        $this->iniciar($filtro,$pesquisa,$_POST["estado"]);



                    }


                }
              




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





