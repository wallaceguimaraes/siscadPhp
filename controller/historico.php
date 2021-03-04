<?php
    
    include_once("dao/historico_dao.php");
    //include_once("model/categoria.php");    
    include_once("model/m_historico.php"); 

    class historico{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }



        function execute($acao){
  


            switch ($acao){                  

            case "historico.nada":$this->          inicio();break;
            case "historico.inicio":$this->           inicio();break;
            case "historico.pesquisar":$this->        pesquisar();break;
                }
            }



        function executar($acao,$sessao,$resultado,$id){
  
                    switch ($acao){                  
                    case "historico.salvar":$this->           salvar($sessao,$resultado,$id);break;
                                   
                        }
                    }


                    function salvar($sessao,$acao,$identificador){
                        $db = conexao::getConnection();
                        $db2 = conexao::getConnection();
                        $id=0;
                

                        if($identificador===""){
                            $sql="select last_insert_id() as id from dual";
                            $result = $db->query($sql);          
                        
                        if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                         $id=(int)$rows["id"];          
                         
                        }
                       }else{
                           $id=$identificador;
                       }
                
                        $sql2="select * from usuario where sessao='".$sessao."'";
                        $result2 = $db2->query($sql2);
                
                   
                        if($row=$result2->fetch(PDO::FETCH_ASSOC)){
                          $usuario_id=(int)$row["usuario_id"];                             
                         }
                
                        $historico_dao = new historico_dao();
                        $historico = new m_historico();

                   
                        $filtro=explode(" ", $acao);
                        //=$filtro[2]; 
                        $classe=$this->retiraAcentos(utf8_decode($filtro[2]));
                        $historico->set__acao($acao);                        
                        //$historico->set__.$classe.__id($id);
                        eval('$historico->set__'.strtolower($classe).'__id('.$id.');');//instancia a classe

                        $historico->set__usuario__id($usuario_id);
                        $historico_dao->salvar($historico);
                
                
                      }
                

                      function retiraAcentos($string){
                        $acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
                        $sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
                        $string = strtr($string, utf8_decode($acentos), $sem_acentos);
                        $string = str_replace(" ","-",$string);
                        return utf8_decode($string);
                     }







                     function inicio(){


                        $historico_dao = new historico_dao();
                        $filtro="";
                        $lista=$historico_dao::listar_historico($filtro);
                        echo "view_historico.html|"."tabela-resultado"."|".$lista."|Histórico";
                    }

                    
                

                    function pesquisar(){

                     
                        
                        $historico_dao = new historico_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';

                        
                        if($_POST["usuario"]!==''){$filtro[]="u.usuario_nome like '%". strToUpper($_POST["usuario"])."%'";}                
                        
                        if($_POST["data"]!==''){
                            $data=str_replace("/", "-", $_POST["data"]);
                            $data=date( "Y-m-d", strtotime($data));
                            $filtro[]="h.data like '%".$data."%'";}                
                        
                       
                        

                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }else{
                            $filtro="";
                        }
                      

                        $lista=$historico_dao::listar_historico($filtro);
                        echo "view_historico.html|"."tabela-resultado"."|".$lista."|Histórico";


                    }



















                    }





                           
                    


                
              


            

    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





