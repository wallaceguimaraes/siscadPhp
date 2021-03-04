<?php


include_once('conexao.php');
include_once('model/m_perfil_arquivo.php');


/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class perfil_arquivo_dao {

    /*
 function salvar(m_perfil_arquivo $perfil_arquivo) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("INSERT INTO pessoa (
                categoria_id,nome,apelido,dt_nasc,dt_cadastro,dt_atualiza,cpf,
                como_chega,nome_mae,rg,dt_exp,nis_pis,sus,titulo,endereco,complemento,
                municipio,estado,cep,telefone1,telefone2,telefone_fixo,foto) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
             
            $stmt->bindValue(1, $pessoa->get__categoria__id(), PDO::PARAM_INT);
            $stmt->bindValue(2, $pessoa->get__nome(), PDO::PARAM_STR);
            $stmt->bindValue(3, $pessoa->get__apelido(), PDO::PARAM_STR);
            $stmt->bindValue(4, $pessoa->get__dt__nasc(), PDO::PARAM_STR);
            $stmt->bindValue(5, $pessoa->get__dt__cadastro(), PDO::PARAM_STR);
            $stmt->bindValue(6, $pessoa->get__dt__atualiza(), PDO::PARAM_STR);
            $stmt->bindValue(7, $pessoa->get__cpf(), PDO::PARAM_STR);
            $stmt->bindValue(8, $pessoa->get__como__chega(), PDO::PARAM_STR);
            $stmt->bindValue(9, $pessoa->get__nome__mae(), PDO::PARAM_STR);
            $stmt->bindValue(10, $pessoa->get__rg(), PDO::PARAM_STR);
            $stmt->bindValue(11, $pessoa->get__dt__exp(), PDO::PARAM_STR);
            $stmt->bindValue(12, $pessoa->get__nis__pis(), PDO::PARAM_STR);
            $stmt->bindValue(13, $pessoa->get__sus(), PDO::PARAM_STR);
            $stmt->bindValue(14, $pessoa->get__titulo(), PDO::PARAM_STR);
            $stmt->bindValue(15, $pessoa->get__endereco(), PDO::PARAM_STR);
            $stmt->bindValue(16, $pessoa->get__complemento(), PDO::PARAM_STR);
            $stmt->bindValue(17, $pessoa->get__municipio(), PDO::PARAM_STR);
            $stmt->bindValue(18, $pessoa->get__estado(), PDO::PARAM_STR);
            $stmt->bindValue(19, $pessoa->get__cep(), PDO::PARAM_STR);
            $stmt->bindValue(20, $pessoa->get__tel__1(), PDO::PARAM_STR);
            $stmt->bindValue(21, $pessoa->get__tel__2(), PDO::PARAM_STR);
            $stmt->bindValue(22, $pessoa->get__tel__fixo(), PDO::PARAM_STR);
            $stmt->bindValue(23, $pessoa->get__foto(), PDO::PARAM_STR);


            $stmt->execute();
            //":date"=>date("Y-m-d H:i:s", strtotime($date)), PDO::PARAM_STR));
            
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar um pessoa. <br>" . $ex->getMessage());
            throw $e;
        }
    }


    */

    function atualizar($perfil_id,$arquivo_id) {
        try {            

            $db = conexao::getConnection();						
		    $consulta ="
            SELECT * FROM perfil_arquivo where perfil_id=$perfil_id and arquivo_id=$arquivo_id" ;
			$result = $db->query($consulta);
    
			if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                            
                $stmt = $db->prepare("delete from perfil_arquivo where perfil_id=$perfil_id and arquivo_id=$arquivo_id");
                }else{
                    $stmt = $db->prepare("INSERT INTO perfil_arquivo (arquivo_id,perfil_id) values ($arquivo_id,$perfil_id)");
                }
                $stmt->execute();
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar um pessoa. <br>" . $ex->getMessage());
            throw $e;
        }
    }

    function excluir(int $id) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("  
                                UPDATE 
                                  pessoa SET ativo='NÃO' where pessoa_id=?");
             
                        
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            
    
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao excluir o pessoa. <br>" . $ex->getMessage());
            throw $e;
        }
    }



    function selecionar($id){                           
   

        $db = conexao::getConnection();						
		    $consulta ="
            SELECT a.arquivo_id, a.info, a.descricao, 
            (SELECT 'checked' FROM perfil_arquivo aa 
              WHERE aa.arquivo_id=a.arquivo_id 
              AND aa.perfil_id='$id') checked 
         FROM arquivo a
         WHERE a.ativo='SIM' 
         ORDER BY a.arquivo
                  " ;

							$result = $db->query($consulta);
							
							if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                               $valor=$rows["info"];                             
                            }
              $loopchecked=" ";                            
                /*        
               while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                if($rows['categoria_id']==$rows['categoria_id']){
                  $loopselect.=  "<option value=".$rows_cat['categoria_id']." selected > ".$rows_cat['categoria']."</option>";
                }else{  
                $loopselect.= "<option value=".$rows_cat['categoria_id'].">".$rows_cat['categoria']."</option>" ;                             
                }  
                } 
*/

                while($rows=$result->fetch(PDO::FETCH_ASSOC)){                               
                   
                $loopchecked.= "
                <p></p>
                <tr>
                    <td align=\"center\"><input type=\"checkbox\" value=\"S\"  data-toggle=\"modal\"  data-target=\"#exampleModalCenter\"  ".$rows["checked"]." onclick=\"selecionar( null,'perfil_arquivo.atualizar','perfil.".$rows['arquivo_id']."')\"></td>  
                    <td>".$rows['info']."</td>
                    <td>".$rows['descricao']."</td> 
                  </tr>";
  
                }


 
                          $view="
          
                          <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:auto;\" > 
                          <table class=\"table table-striped table-responsive-md \" >
                                   <thead class=\"bg-custom-15\" >
                                   <tr>
                                   <th><img style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-checkmark-48.png\"></img></th>  
                                   <th>Nome</th>
                                     <th>Descrição</th>
                                     </thead>
                                     </tr>
                                   <tbody style=\"background-color:#f0fff7;\">
                                
                                   ".$loopchecked."

                             </tbody>
                             </table>
                            ";



                            return $view;

    }








    public static function listar_pessoa($filtro) {
        $db = conexao::getConnection();
    

        if($filtro!==""){
            $consulta=" 
                     SELECT p.* FROM pessoa p where ".$filtro." order by p.nome asc";  
            
        }else{
        $consulta ="
                    SELECT p.*
                    FROM pessoa p where p.ativo='SIM' order by p.nome asc ";
        }

    

                            $result = $db->query($consulta);
                            
                            $l="
                            <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                            <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                        </nav>  
                            
                            
                            <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >  <table class=\"table table-striped\" >
                            <thead class=\"bg-custom-15\" >
                            <tr>
                              
                              <th>Nome</th>
                              <th>CPF</th>
                              <th>Contato</th>
                              <th align=right; style=\"text-align:center; width:22rem;\">Ação</th>
                              </thead>
                              </tr>
                            <tbody style=\"background-color:#f0fff7;\">";
                         
                           
                   
                            while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                //print_r($rows);
                                              
                                //Aqui criamos o cabeçalho da tabela.
                                // A tag <tr> abre uma linha, enquanto a <td> abre uma célula.
                                $l.= "<tr><td align-items=\"center\">".$rows['nome']."</td>"
                                    ."<td align-items=\"center\">".$rows['cpf']."</td>"
                                    ."<td align-items=\"center\">".$rows['telefone1']."</td>"
                                    ."<td style=\"width:12rem;\"align=\"center\">
                                    <button type=\"button\" id=\"btNovaDemanda\" onclick=\"navegar('demanda.listar','pessoa',".$rows['pessoa_id'].")\" class=\"btn btn-demanda bg-custom-demanda\">+ Demanda</button>
                                    <button type=\"button\" id=\"btExcluir\" onclick=\"verificar('pessoa.excluir','pessoa',".$rows['pessoa_id'].")\" class=\"btn btn-excluir bg-custom-4\" >Excluir</button>
                                    <button class=\"btn btn-editar bg-custom-5\" id=\"btEditar\" onclick=\"selecionar(".$rows['pessoa_id'].",'pessoa.editar','pessoa%desc%ativo')\" name=\"btEditar\" type=\"button\"\" >Editar</button></td>"
                                    ."</tr>";  
                          
                                }
                            $l.= "</tbody>
                            </table>
                            </div>";
    
                    
                            //setar_texto("tabela-resultado",$l);
                            
                            return $l;
        }
    

   

}