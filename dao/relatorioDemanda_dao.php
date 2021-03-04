<?php


include_once('conexao.php');
include_once('model/m_relatorioDemanda.php');


/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class relatorioDemanda_dao {



  /*  
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


*/





    public static function listar_relatorio($filtro) {
        $db = conexao::getConnection();
    
                           
        if($filtro!==""){
            $consulta=" 
            SELECT *,
            case
            when length(d.demanda) > 45 then concat( left(d.demanda,45),'...')
            else d.demanda
            end as dem_70c,
         DATE_FORMAT(data_cadastro,'%d/%m/%Y') AS 'cadastro'
               FROM demanda d inner join pessoa p on p.pessoa_id=d.pessoa_id
              WHERE        
            ".$filtro." order by data_cadastro desc";  
            
        }else{
        $consulta ="
        SELECT *,
        case 
        when length(d.demanda) > 45 then concat( left(d.demanda,45),'...')
        else d.demanda
        end as dem_70c,
        DATE_FORMAT(data_cadastro,'%d/%m/%Y') AS 'cadastro'
              FROM demanda d inner join pessoa p on p.pessoa_id=d.pessoa_id
             WHERE        
             p.ativo='SIM' order by data_cadastro desc";  
           
        }


                            $result = $db->query($consulta);
                            
                            $l="
                            <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                            <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                        </nav>  
                            
                            
                            <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >  
                            <form action=\"https://scevf.000webhostapp.com/view/view_relatorio.php\" method=\"POST\" target=\"_blank\">  
                            <table rules=\"none\" class=\"tabela table table-striped table-responsive-md table-responsive-sm table-responsive-lg\" >
                            <thead class=\"bg-custom-15\" >
                            <tr>
                              
                              <th>Pessoa</th>
                              <th>Demanda</th>
                              <th>Data</th>
                              <th>Situação</th>
                              <th style=\"width:3rem; text-align:center;\">Ação</th>
                              </thead>
                              </tr>
                              <tbody style=\"background-color:#f0fff7;\">";
                         
                        
                            while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                $l.= "<tr><td align-items=\"center\">".$rows['nome']."</td>"
                                    ."<td align-items=\"center\">".$rows['dem_70c']."</td>"
                                    ."<td align-items=\"center\">".$rows['cadastro']."</td>"
                                    ."<td align-items=\"center\">".$rows['status']."</td>"
                                    ."<td style=\"width:5rem; \" align=\"center\">
                                     <button class=\"btn-excluir bg-custom-0\" name=\"demanda_id\" style=\"border:none;\" value=\"".$rows['demanda_id']."\" type=\"submit\"><img class=\"img-responsive img-rounded \" title=\"Gerar PDF\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-print-64.png\"></img></button>
                                    
                                     </td>"
                                    ."</tr>";  
                          
                                }
                            $l.= "</tbody>
                            </table>
                            </form>
                            </div>";
    
                    
                            //setar_texto("tabela-resultado",$l);
                            
                            return $l;
        }
    

   

}