<?php
    
    include_once("dao/solicitacaodemanda_dao.php");
    include_once("dao/pessoa_dao.php");

    include_once("controller/historico.php"); 
    //include_once("model/m_demanda.php"); 

    class solicitacaodemanda{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

       


        function execute($acao){
  
            
                    switch ($acao){                  
                    case "solicitacaodemanda.inicio":$this->          inicio();break;
                    case "demanda.inicio2":$this->          inicio2();break;
                    case "demanda.salvar":$this->           salvar();break;
                    case "solicitacaodemanda.listar":$this->           listar();break;
                    case "solicitacaodemanda.editar":$this->           editar();break;
                    case "demanda.editar2":$this->           editar2();break;
                    case "demanda.excluir":$this->          excluir();break;
                    case "demanda.visualizar":$this->          visualizar();break;
                    case "solicitacaodemanda.pesquisarParaDemanda":$this-> pesquisarParaDemanda();break;
                    case "solicitacaodemanda.pesquisar":$this->        pesquisar();break;
                    case "solicitacaodemanda.reprovar":$this->        alterarStatus("REPROVADA");break;
                    case "solicitacaodemanda.aprovar":$this->        alterarStatus("ANDAMENTO");break;

                    
                        }
                    }









                    function pesquisarParaDemanda(){

                        $solicitacao = new solicitacaodemanda_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        $filtro[]="p.ativo='SIM'";
                        $filtro[]="d.status='ABERTO'";
                        if($_POST["nome"]!==''){$filtro[]="p.nome like '%". strToUpper($_POST["nome"])."%'";}                
                        if($_POST["rg"]!==''){$filtro[]="p.rg like '%". strToUpper($_POST["rg"])."%'";}                
                       
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                       

                        $lista=$solicitacao::listar_pessoa($filtro);
                        echo "view_solicitacaoDemanda.html|"."tabela-resultado-2"."|".$lista."|Selecionar pessoa com demanda pendente";


                    }




                    function excluir(){

                        //$demanda = new m_demanda();

                        $demanda_dao= new demanda_dao();
                        $resultado=$demanda_dao::excluir($_POST["id"]);

                        if($resultado===1){
                            // echo "Processo efetuado com sucesso!";
 
                         $filtro="";   
                         $lista=$demanda_dao::listar_demanda($filtro);
 
 
                         $msg = "Processo efetuado com sucesso!";    
                             
                             
                             
                             
                          echo "view_solicitacaoDemanda.html|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar demanda pendente";
 
                         }else{
                             echo "Ocorreu algum erro !";
                         }




                    }




                    function editar(){

                        //$demanda = new m_demanda();
                    
                        $solicitacao= new solicitacaodemanda_dao();
                        if(!isset($_POST["aux_id"])){
                            $_POST["aux_id"]="";
                        }

                        if($_POST["aux_id"]!==""){
                            $resultado=$solicitacao::selecionar($_POST["id"],$_POST["aux_id"]);
                        }else{
                            $resultado=$solicitacao::selecionar($_POST["id"],"");
                        }

                        //echo "view_solicitacaoDemanda.html|"."tela-cadastro".$resultado."Cadastrar demanda";

                        if($_POST["aux_id"]!==""){
                        echo "Editar demanda¨".$resultado."¨identificacao";
                        }else{    
                        echo "Dados pessoais¨".$resultado."¨identificacao";
                        }
                    }




                    function editar2(){

                        //$demanda = new m_demanda();
                        


                        $demanda_dao= new demanda_dao();
   
                        $ativo="";
                        $resultado=$demanda_dao::selecionar2($_POST["id"],$ativo);
                        

                        //echo "view_solicitacaoDemanda.html|"."tela-cadastro".$resultado."Cadastrar demanda";


                        echo "Editar demanda¨".$resultado."¨identificacao";
                    }


                    function visualizar(){

                        //$demanda = new m_demanda();
                        
                        $demanda_dao= new demanda_dao();
   
                        $ativo="disabled";
                        $resultado=$demanda_dao::selecionar2($_POST["id"],$ativo);
                        

                        //echo "view_solicitacaoDemanda.html|"."tela-cadastro".$resultado."Cadastrar demanda";


                        echo "Visualizar demanda¨".$resultado."¨identificacao";
                    }





                    function salvar(){
                        $demanda = new m_demanda();    
                        $demanda->set__pessoa__id($_POST["pessoa_id"]);
                        $demanda->set__demanda($_POST["demanda"]);
                   
                        if($_POST["id"]>0){
                            $demanda->set__demanda__id($_POST["id"]);
                            //$demanda->set__ativo($_POST["ativo"]);
                            $demanda_dao = new demanda_dao();
                            $resultado=$demanda_dao::atualizar($demanda);                            
                        }else{
                            $demanda_dao = new demanda_dao();
                            $resultado =$demanda_dao::salvar($demanda);                 
                        }
                        if($resultado>0){
                       
                            if($resultado===1){$resultado="CADASTRO DA DEMANDA";}
                            if($resultado===2){$resultado="ATUALIZAÇÃO DA DEMANDA";}

                            $identificador="";
                         if($_POST["id"]>0){
                            $identificador=$_POST["id"];
                         }       
                         
                            
                        $historico = new historico();
                        $historico->executar("historico.salvar",$_POST["sessao"],$resultado,$identificador);    

                            




                       
                        $filtro="d.pessoa_id=".$_POST["pessoa_id"]."";
                       
                        


                        $lista=$demanda_dao::listar_demanda($filtro,"");
                        $msg = "Processo efetuado com sucesso!";        
                         echo "view_solicitacaoDemanda.html|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar demanda";
                        }else{
                            echo "Ocorreu algum erro !";
                        }
                    }

                    

                    function alterarStatus($status){
                        //$demanda = new m_demanda();    
                       // $demanda->set__pessoa__id($_POST["pessoa_id"]);
                       // $demanda->set__demanda($_POST["demanda"]);
                   
                        if($_POST["id"]>0){
                          //  $demanda->set__demanda__id($_POST["id"]);
                           // $demanda->set__status($status);



                            $solicitacao = new solicitacaodemanda_dao();
                            $resultado=$solicitacao::atualizar($_POST["id"],$status);                            
                        }
                            if($resultado>0){
                       
                                if($resultado===3){$resultado="REPROVAÇÃO DA DEMANDA";}
                                if($resultado===4){$resultado="APROVAÇÃO DA DEMANDA";}
    
                                $identificador="";
                             if($_POST["id"]>0){
                                $identificador=$_POST["id"];
                             }       
                             
                                
                            $historico = new historico();
                            $historico->executar("historico.salvar",$_POST["sessao__"],$resultado,$identificador);    
    


                        $filtro="d.pessoa_id=".$_POST["aux_id"]."";
                       
                        
                        $lista=$solicitacao::listar_demanda($filtro,"");
                        $msg = "Processo efetuado com sucesso!";        
                         echo "view_solicitacaoDemanda.html¨"."tabela-resultado"."¨".$msg."¨".$lista."¨Pesquisar demanda"."¨"."Pesquisar demanda";
                        }else{
                            echo "Ocorreu algum erro !";
                        }
                    }










                    function inicio(){
            


                        $solicitacao = new solicitacaodemanda_dao();
                        $filtro="";
                        $lista=$solicitacao::listar_pessoa($filtro);
                        echo "view_solicitacaoDemanda.html|"."tabela-resultado-2"."|".$lista."|Selecionar pessoa com demanda pendente";


                        //echo "view_solicitacaoDemanda.html|tela-cadastro|Cadastro de demanda";
             
                    }



                    function listar(){


                        $solicitacao = new solicitacaodemanda_dao();

                        $filtro="d.pessoa_id=".$_POST["pessoa_id"]."";
                        $id="";
                        $lista=$solicitacao::listar_demanda($filtro,$id);

                        echo "view_solicitacaoDemanda.html|"."tabela-resultado"."|".$lista."|Pesquisar demanda pendente";

                    }



                    function pesquisar(){
                        /*
                        $demanda = new m_demanda();    
                        $demanda->set__demanda($_POST["demanda"]);
                        $demanda->set__ativo($_POST["ativo"]);

                        */
                        $solicitacao = new solicitacaodemanda_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        //$filtro[]="d.ativo='".$_POST["ativo"]."'";
                        if($_POST["pessoa_id"]!==''){$filtro[]="d.pessoa_id =".$_POST["pessoa_id"]."";}                
                        if($_POST["demanda"]!==''){$filtro[]="d.demanda like '%". strToUpper($_POST["demanda"])."%'";}                
                        
                        
                        if($_POST["data"]!==''){
                            $data=str_replace("/", "-", $_POST["data"]);
                            $data=date( "Y-m-d", strtotime($data));

                            $filtro[]="d.data_cadastro like '%".$data."%'";}  
                            $filtro[]="d.status='ABERTO'";
                            
                        if($_POST["status"]!==''){
                            $filtro[]="d.status like '%". strToUpper($_POST["status"])."%'";}                
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                        $id="";
                        if($_POST["pessoa_id"]!==''){
                            $id=$_POST["pessoa_id"];
                        }

                        $lista=$solicitacao::listar_demanda($filtro,$id);
                        echo "view_solicitacaoDemanda.html|"."tabela-resultado"."|".$lista."|Pesquisar demanda pendente";
                    }


                }
              




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





