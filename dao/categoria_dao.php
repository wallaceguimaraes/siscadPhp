<?php


include_once('conexao.php');
include_once('model/m_categoria.php');


/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class categoria_dao {

 function salvar(m_categoria $categoria) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("INSERT INTO `categoria` (`categoria`) VALUES (?);");
             
            $stmt->bindValue(1, $categoria->get__categoria(), PDO::PARAM_STR);
            $stmt->execute();
            
            
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar uma categoria. <br>" . $ex->getMessage());
            throw $e;
        }
    }



    function atualizar(m_categoria $categoria) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("  
                                UPDATE 
                                  categoria SET categoria=?, ativo=? where categoria_id=?");
             
            $stmt->bindValue(1, $categoria->get__categoria(), PDO::PARAM_STR);
            $stmt->bindValue(2, $categoria->get__ativo(), PDO::PARAM_STR);
            $stmt->bindValue(3, $categoria->get__categoria__id(), PDO::PARAM_INT);
            $stmt->execute();
            
            
    
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar uma categoria. <br>" . $ex->getMessage());
            throw $e;
        }
    }



    function excluir(int $id) {
      

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("  
                                UPDATE 
                                  categoria SET ativo='NÃO' where categoria_id=?");
             
            
            
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            
    
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao excluir a categoria. <br>" . $ex->getMessage());
            throw $e;
        }
    }




    function selecionar($id,$ativo){

       $ativoBtn=""; 

      if($ativo=="disabled"){
        $ativoBtn="hidden";
      }else{
          $ativoBtn="";
      }

        $db = conexao::getConnection();						
		$consulta ="
                    SELECT COUNT(c.categoria_id) cont, c.*                
							FROM categoria c  
							WHERE c.categoria_id=".$id."";
							
							$result = $db->query($consulta);
							//$result = $rows->fetchAll();
							$cont=0;
							$sessao=0;
							$valor;
							if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                               $valor=$rows["categoria"]."|".$rows["ativo"];  
                            }

                           $view= "<form class=\"bg-custom-form\" style=\"height: 29rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%;\" >
                            <input type=\"hidden\" id=\"categoria_id\"  value=\"".$rows["categoria_id"]."\">
                                   <div class=\"form-row\" style=\" justify-content: center; justify-items: center;\">
                                       <div class=\"form-group col-md-6\">
                                         <label for=\"categoria\">Categoria<span style=\"color: red;\">*</span></label>
                                         <input ".$ativo." type=\"text\" value=\"".$rows["categoria"]."\" class=\"form-control\" id=\"categoria\">
                                       </div>                               
                                       <div class=\"form-group col-md-2\">
                                         <label for=\"ativo\">Ativo</label>
                                         <select ".$ativo." id=\"ativo\" value=\"".$rows["ativo"]."\" class=\"form-control\">
                                           <option value=\"SIM\">SIM</option>
                                           <option value=\"NÃO\">NÃO</option>
                                         </select>
                                       </div>
                                  
                                     </div>
                                  
                                     <div class=\"form-row\">
                                       <div class=\"form-group col\" style=\"text-align: center;\">
                                         <button ".$ativoBtn." type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('categoria.salvar','categoria|ativo',".$rows["categoria_id"].")\" >Gravar</button>
                                     </div>  
                                     </div>";


                            return $view;


//                          return $valor;

    }








    public static function listar_categoria($filtro) {
        $db = conexao::getConnection();
    
                            
    
        if($filtro!==""){
            $consulta=" 
                     SELECT c.*
                         FROM categoria c where ".$filtro." order by categoria asc";  
            
        }else{
        $consulta ="
                    SELECT c.*
                    
                    FROM categoria c where c.ativo='SIM' order by categoria asc ";
        }

    
        

                            $result = $db->query($consulta);
                            
                            $l="
                            <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                            <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                        </nav>  
                            
                            
                            <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:auto;\" >  
                            <table class=\"table table-striped \" >
                            
                            <thead class=\"bg-custom-15\">
                            <tr>
                              
                              <th>Categoria</th>
                              <th>Ativo</th>
                              <th style=\"text-align:center;\">Ação</th>
                              </thead>
                              </tr>
                              <tbody style=\"background-color:#f0fff7;\">";
                                                    
                   
                            while($rows=$result->fetch(PDO::FETCH_ASSOC)){


                                $l.= "<tr><td align-items=\"center\">".$rows['categoria']."</td>"                                
                                ."<td align-items=\"center\">".$rows['ativo']."</td>"
                                ."<td style=\"width:7rem;\"align=\"center\">
                                <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$rows['categoria_id'].",'categoria.visualizar')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                <img class=\"img-responsive img-rounded btn-excluir bg-custom-aviso\" title=\"Excluir\" id=\"btExcluir\" onclick=\"verificar('categoria.excluir','categoria',".$rows['categoria_id'].",'Deseja realmente excluir a categoria  \'".$rows['categoria']." \' ?')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eraser-64.png\"></img>
                                <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Editar\" id=\"btEditar\" onclick=\"selecionar(".$rows['categoria_id'].",'categoria.editar')\" name=\"btEditar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-pencil-48.png\"></img>                            
                                </td>"
                                ."</tr>";  
                      
                            }

                                
                            $l.= "</tbody>
                            </table>
                            </div>";
    
                    
                            //setar_texto("tabela-resultado",$l);
                            
                            return $l;
        }
    

   

}