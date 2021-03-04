<?php


include_once('conexao.php');
include_once('model/m_perfil.php');


/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class perfil_dao {

 function salvar(m_perfil $perfil) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("INSERT INTO `perfil` (`perfil`,`descricao`) VALUES (?,?);");
             
            $stmt->bindValue(1, $perfil->get__perfil(), PDO::PARAM_STR);
            $stmt->bindValue(2, $perfil->get__descricao(), PDO::PARAM_STR);
            $stmt->execute();
            
            
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar um perfil. <br>" . $ex->getMessage());
            throw $e;
        }
    }



    function atualizar(m_perfil $perfil) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("  
                                UPDATE 
                                  perfil SET perfil=:perfil, descricao=:desc, ativo=:ativo where perfil_id=:perfil_id");
             
            $stmt->bindValue(":perfil", $perfil->get__perfil(), PDO::PARAM_STR);
            $stmt->bindValue(":desc", $perfil->get__descricao(), PDO::PARAM_STR);
            $stmt->bindValue(":ativo", $perfil->get__ativo(), PDO::PARAM_STR);
            $stmt->bindValue(":perfil_id", $perfil->get__perfil__id(), PDO::PARAM_INT);
            $stmt->execute();
            
            
    
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar um perfil. <br>" . $ex->getMessage());
            throw $e;
        }
    }



    function excluir(int $id) {
        try {            
            $db = conexao::getConnection();            
            $stmt = $db->prepare("  
                                UPDATE 
                                  perfil SET ativo='NÃO' where perfil_id=?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao excluir o perfil. <br>" . $ex->getMessage());
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
                    SELECT COUNT(p.perfil_id) cont, p.*,
                    case 
                    when length(p.descricao) > 70 then concat( left(p.descricao,70),'...')
                    else p.descricao
                    end as desc_70c
							FROM perfil p  
							WHERE p.perfil_id=".$id."";
							
							$result = $db->query($consulta);
							//$result = $rows->fetchAll();
							$cont=0;
							$sessao=0;
							$valor;
							if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                               $valor=$rows["perfil"]."|".$rows["desc_70c"]."|".$rows["ativo"];  
                            }
                           $view= "<form class=\"bg-custom-form\" style=\"height: 29rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%;\" >
                            <input type=\"hidden\" id=\"perfil_id\"  value=\"".$rows["perfil_id"]."\">
                                   <div class=\"form-row\" style=\" justify-content: center; justify-items: center;\">
                                       <div class=\"form-group col-md-6\">
                                         <label for=\"perfil\">Perfil<span style=\"color:red;\">*</span></label>
                                         <input ".$ativo." type=\"text\" value=\"".$rows["perfil"]."\" class=\"form-control\" id=\"perfil\">
                                       </div>                               
                                       <div class=\"form-group col-md-2\">
                                         <label for=\"ativo\">Ativo</label>
                                         <select ".$ativo." id=\"ativo\" value=\"".$rows["ativo"]."\" class=\"form-control\">
                                           <option value=\"SIM\">SIM</option>
                                           <option value=\"NÃO\">NÃO</option>
                                         </select>
                                       </div>
                                  
                                     </div>
                                     <div class=\"form-row\" style=\" justify-content: center; justify-items: center;\">
                                       <div class=\"form-group col-md-8\">
                                           <label for=\"desc\">Descrição</label>
                                           <textarea ".$ativo." class=\"form-control\" id=\"desc\" rows=\"3\">".$rows["descricao"]."</textarea>
                                         </div>               
                                     </div>
                                     <div class=\"form-row\">
                                       <div class=\"form-group col\" style=\"text-align: center;\">
                                         <button ".$ativoBtn." type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('perfil.salvar','perfil|desc|ativo',".$rows["perfil_id"].")\" >Gravar</button>
                                     </div>  
                                     </div>";


                            return $view;


//                          return $valor;

    }








    public static function listar_perfil($filtro) {
        $db = conexao::getConnection();
    
                            
    
        if($filtro!==""){
            $consulta=" 
                     SELECT p.*,
                     case  
                     when length(p.descricao) > 70 then concat( left(p.descricao,70),'...')
                     else p.descricao
                     end as desc_70c FROM perfil p where ".$filtro." order by perfil asc";  
            
        }else{
        $consulta ="
                    SELECT p.*,
                    case
                    when length(p.descricao) > 70 then concat( left(p.descricao,70),'...')
                    else p.descricao
                    end as desc_70c
                    FROM perfil p where p.ativo='SIM' order by perfil asc ";
        }

    

                            $result = $db->query($consulta);
                            
                            $l="
                            <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                            <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                        </nav>  
                            
                            
                            <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >
                            <table class=\"table table-striped table-responsive-md table-responsive-sm table-responsive-lg\" >
                            <thead class=\"bg-custom-15\" >
                            <tr>
                              
                              <th>Perfil</th>
                              <th>Descrição</th>
                              <th>Ativo</th>
                              <th style=\"text-align:center;\">Ação</th>
                              </thead>
                              </tr>
                            <tbody style=\"background-color:#f0fff7;\">";
                         
                           
                   
                            while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                //print_r($rows);
                                              
                                //Aqui criamos o cabeçalho da tabela.
                                // A tag <tr> abre uma linha, enquanto a <td> abre uma célula.
                                $l.= "<tr><td align-items=\"center\">".$rows['perfil']."</td>"
                                    ."<td align-items=\"center\">".$rows['desc_70c']."</td>"
                                    ."<td align-items=\"center\">".$rows['ativo']."</td>"
                                    ."<td style=\"width:12rem;\"align=\"center\">
                                    <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$rows['perfil_id'].",'perfil.visualizar')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                    <img class=\"img-responsive img-rounded btn-excluir bg-custom-aviso\" title=\"Excluir\" id=\"btExcluir\" onclick=\"verificar('perfil.excluir','perfil',".$rows['perfil_id'].",'Deseja realmente excluir o perfil  \'".$rows['perfil']." ?')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eraser-64.png\"></img>
                                    <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Editar\" id=\"btEditar\" onclick=\"selecionar(".$rows['perfil_id'].",'perfil.editar')\" name=\"btEditar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-pencil-48.png\"></img>
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