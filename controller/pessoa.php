<?php
    
    include_once("dao/pessoa_dao.php");
    include_once("dao/demanda_dao.php");

    //include_once("model/categoria.php");    
    include_once("model/m_pessoa.php"); 
    include_once("controller/historico.php"); 

    class pessoa{
 
        function setar_texto($id,$texto){
            print chr(2) . $id. chr(2) . $texto . chr(2);
        }

        function execute($acao){
  
                    switch ($acao){                  
                    case "pessoa.inicio":$this->          inicio();break;
                    case "pessoa.salvar":$this->           salvar();break;
                    case "pessoa.listar":$this->           listar();break;
                    case "pessoa.editar":$this->           editar();break;
                    case "pessoa.excluir":$this->          excluir();break;
                    case "pessoa.pesquisar":$this->        pesquisar();break;
                    case "pessoa.visualizar":$this->        visualizar();break;
                    case "pessoa.buscarParaDemanda":$this-> buscarParaDemanda();break;
                    case "pessoa.pesquisarParaDemanda":$this-> pesquisarParaDemanda();break;                                    
                    case "pessoa.validarDados":$this->validarDados();break;                                    
                    case "pessoa.validarRG":$this->validarRG();break;                                    

                }
                    }


                    function excluir(){

                        $pessoa_dao= new pessoa_dao();
                        $resultado=$pessoa_dao::excluir($_POST["id"]);


                            if($resultado > 0){

                                if($resultado===3){$resultado="EXCLUSÃO DA PESSOA";}
                               
    
    
    
                                $identificador="";
                                 if($_POST["id"]>0){
                                    $identificador=$_POST["id"];
                                 } 
    
    
    
    
                            $historico = new historico();
                            $historico->executar("historico.salvar",$_POST["sessao"],$resultado,$identificador);    
    






 
                         $filtro="";   
                         $lista=$pessoa_dao::listar_pessoa($filtro);
 
                         $msg = "Processo efetuado com sucesso!";    
                                                          
                          echo "view_pessoa.php|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar pessoa";
 
                         }else{
                             echo "Ocorreu algum erro !";
                         }
                    }


                    function editar(){
                        $pessoa_dao= new pessoa_dao();
                        $ativo="";
                        $resultado=$pessoa_dao::selecionar($_POST["id"],$ativo);
                        echo "Editar pessoa¨".$resultado;

                    }




                    function validarDados(){
                        
                        $pessoa_dao= new pessoa_dao();
                        $resultado=$pessoa_dao::validarCPF($_POST["cpf"]);

                        
                        
                        echo $resultado."|"."O cpf já foi gravado anteriormente!";

                    }


                    
                    function validarRG(){
                        
                        $pessoa_dao= new pessoa_dao();
                        $resultado=$pessoa_dao::validarRG($_POST["rg"]);
                        echo $resultado."|"."O rg já foi gravado anteriormente!";
                    }







                    function visualizar(){

                        //$categoria = new m_categoria();
                        $pessoa_dao= new pessoa_dao();
                        $ativo="disabled";
                        $resultado=$pessoa_dao::selecionar($_POST["id"],$ativo);
                        echo "Visualizar pessoa¨".$resultado;
                        //echo $resultado;

                    }



                    function salvar(){
                        
                        $pessoa = new m_pessoa();    
                        $pessoa->set__categoria__id($_POST["categoria-id"]);
                        $pessoa->set__nome($_POST["nome"]);
                        $pessoa->set__apelido($_POST["apelido"]);
                        $pessoa->set__dt__nasc($_POST["dt-nasc"]);
                        $pessoa->set__cpf($_POST["cpf"]);
                        $pessoa->set__como__chega($_POST["como-chega"]);
                        $pessoa->set__nome__mae($_POST["nome-mae"]);
                        $pessoa->set__rg($_POST["rg"]);
                        $pessoa->set__dt__exp($_POST["dt-exp"]);
                        $pessoa->set__nis__pis($_POST["nis-pis"]);
                        $pessoa->set__sus($_POST["sus"]);
                        $pessoa->set__titulo($_POST["eleitor"]);
                        $pessoa->set__endereco($_POST["endereco"]);
                        $pessoa->set__complemento($_POST["complemento"]);
                        $pessoa->set__municipio($_POST["municipio"]);
                        $pessoa->set__estado($_POST["estado"]);
                        $pessoa->set__cep($_POST["cep"]);
                        $pessoa->set__tel__1($_POST["tel1"]);
                        $pessoa->set__tel__2($_POST["tel2"]);
                        $pessoa->set__tel__fixo($_POST["fixo"]);
                       

                        if (isset($_FILES['files'])) {
                            //$arquivo=$_POST["arquivo"];
                            
                           // $caminho=str_replace('.. uploads/','', $arquivo);
                            
                           
                           if($_POST["arquivo"]!==""){
                           $dir ="./".$_POST["arquivo"];
                           // C:\xampp\htdocs\siscad\uploads
                           $valor = unlink($dir);
                            if($valor!==true){
                                return "Erro ao tentar atualizar a imagem!";
                            }
                        }

                            $errors = [];
                            $path = 'uploads/';
                            $extensions = ['jpg', 'jpeg', 'png', 'gif'];                        
                            $all_files = count($_FILES['files']['tmp_name']);                        
                            for ($i = 0; $i < $all_files; $i++) {
                                $file_name = $_FILES['files']['name'][$i];
                                $file_tmp = $_FILES['files']['tmp_name'][$i];
                                $file_type = $_FILES['files']['type'][$i];
                                $file_size = $_FILES['files']['size'][$i];                                               
                                $ext=explode('.',$file_name);
                                $new_name = $_POST["cpf"] . date("Y.m.d-H.i.s") .".". $ext[1]; //Definindo um novo nome para o arquivo
                                $file = $path . $new_name;
                                /*
                                if (!in_array($file_ext, $extensions)) {
                                    $errors[] = 'Extensão do arquivo não permitida: ' . $file_name . ' ' . $file_type;
                                    echo $errors;
                                    exit;
                                }
                                */
                                if ($file_size > 2097152) {
                                    $errors[] = 'O tamanho do arquivo excede o limite ' . $file_name . ' ' . $file_type;
                                    echo $errors;
                                    exit;
                                }
                    
                                if (empty($errors)) {                                        
                         
                                    $path="uploads/";
                                    $pessoa->set__foto($path."".$new_name);
                         
                                    move_uploaded_file($file_tmp, $file);
                        
                                    if($_POST["id"]>0){//Editando
                                        $pessoa->set__pessoa__id($_POST["id"]);
                                        $pessoa->set__ativo($_POST["ativo"]);
                                        $pessoa_dao = new pessoa_dao();
                                        $resultado=$pessoa_dao::atualizar($pessoa);
                                    }else{
                                        $pessoa_dao = new  pessoa_dao();
                                        $resultado =$pessoa_dao::salvar($pessoa);                 
                                    }
                                    
                        if($resultado > 0){

                            if($resultado===1){$resultado="CADASTRO DE PESSOA";}
                            if($resultado===2){$resultado="ATUALIZAÇÃO DA PESSOA";}



                            $identificador="";
                             if($_POST["id"]>0){
                                $identificador=$_POST["id"];
                             } 

                        $historico = new historico();
                        $historico->executar("historico.salvar",$_POST["sessao"],$resultado,$identificador);    

                                                                            
                                    $filtro="";
                                            
                                    $lista=$pessoa_dao::listar_pessoa($filtro);
                                    $msg = "Processo efetuado com sucesso!";    
                                    echo "view_pessoa.php|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar pessoa";                                    
                                    }else{
                                        echo "Ocorreu algum erro !";
                                    }                                    
                                }
                            }
                    
                            if ($errors) print_r($errors); exit;
                        }else{
                            $pessoa->set__foto("");
                        }


                        if($_POST["id"]>0){//Editando
                            $pessoa->set__pessoa__id($_POST["id"]);
                            $pessoa->set__ativo($_POST["ativo"]);
                            $pessoa_dao = new pessoa_dao();
                            $resultado=$pessoa_dao::atualizar($pessoa);
                        }else{
                            $pessoa_dao = new  pessoa_dao();
                            $resultado =$pessoa_dao::salvar($pessoa); 

                        }


                        if($resultado > 0){

                            if($resultado===1){$resultado="CADASTRO DE PESSOA";}
                            if($resultado===2){$resultado="ATUALIZAÇÃO DA PESSOA";}



                            $identificador="";
                             if($_POST["id"]>0){
                                $identificador=$_POST["id"];
                             } 




                        $historico = new historico();
                        $historico->executar("historico.salvar",$_POST["sessao"],$resultado,$identificador);    

                            
                        $filtro="";   
                        $lista=$pessoa_dao::listar_pessoa($filtro);
                        $msg = "Processo efetuado com sucesso!";                                        
                        echo "view_pessoa.php|"."tabela-resultado"."|".$msg."|".$lista."|Pesquisar pessoa";  
                                                 
                        }else{
                            echo "Ocorreu algum erro !";
                        }

                    }
                    
                    
                    function inicio(){
            
                       echo "view_pessoa.php|tela-cadastro|Cadastro de pessoa";
             
                    }



                    function listar(){


                        $pessoa_dao = new pessoa_dao();

                        $filtro="";
                        $lista=$pessoa_dao::listar_pessoa($filtro);

                        echo "view_pessoa.php|"."tabela-resultado"."|".$lista."|Pesquisar pessoa";

                    }



                    function pesquisar(){

                       
                        $pessoa_dao = new pessoa_dao();

                        $filtro                         =array();

                        if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        $filtro[]="p.ativo='".$_POST["ativo"]."'";
                        if($_POST["nome"]!==''){$filtro[]="p.nome like '%". strToUpper($_POST["nome"])."%'";}                
                       
                        if($_POST["cpf"]!==''){$filtro[]="p.cpf like '%". strToUpper($_POST["cpf"])."%'";}                
                       
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                       

                        $lista=$pessoa_dao::listar_pessoa($filtro);
                        echo "view_pessoa.php|"."tabela-resultado"."|".$lista."|Pesquisar pessoa";


                    }
                    






                    function pesquisarParaDemanda(){

                        $demanda_dao = new demanda_dao();

                        $filtro                         =array();

                        //if($_POST["ativo"]==='')$_POST["ativo"]='SIM';
                        $filtro[]="p.ativo='SIM'";
                        if($_POST["nome"]!==''){$filtro[]="p.nome like '%". strToUpper($_POST["nome"])."%'";}                
                        if($_POST["rg"]!==''){$filtro[]="p.rg like '%". strToUpper($_POST["rg"])."%'";}                
                       
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                       

                        $lista=$demanda_dao::listar_pessoa($filtro);
                        echo "view_pessoa.php|"."tabela-resultado-2"."|".$lista."|Selecionar pessoa";


                    }






                    function buscarParaDemanda(){

                        $pessoa = new m_pessoa();    
                        $pessoa->set__nome($_POST["nome"]);
                        $pessoa->set__rg($_POST["rg"]);
                        //$pessoa->set__ativo($_POST["ativo"]);
                        $demanda_dao = new demanda_dao();
    
                        $filtro                         =array();
    
                        $_POST["ativo"]='SIM';
                        $filtro[]="p.ativo='".$_POST["ativo"]."'";
                        if($_POST["nome"]!==''){$filtro[]="p.nome like '%". strToUpper($_POST["nome"])."%'";}                
                        if($_POST["rg"]!==''){$filtro[]="p.rg like '%". strToUpper($_POST["rg"])."%'";}                
                        if(count($filtro)>0){
                            $filtro=implode(" AND ",$filtro);
                        }
                       
    
                        $lista=$demanda_dao::listar_pessoa($filtro);
                        echo "view_pessoa.php|"."tabela-resultado-2"."|".$lista."|Selecionar pessoa";
    
    
                    }
                    









                }
              




            




    

  




    

    /*
    $sessao=date("YmdHis") . "-" . $row["usuario_id"];
        $sql="UPDATE user SET sessao='$sessao' WHERE id=". $row["usuario_id"];
        
        explode(".",$texto)
    */





