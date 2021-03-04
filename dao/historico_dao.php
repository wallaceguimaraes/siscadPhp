<?php
include_once('conexao.php');
include_once('model/m_historico.php');


class historico_dao {

 function salvar(m_historico $historico) {


if( $historico->get__pessoa__id()===null){$historico->set__pessoa__id("");}
if( $historico->get__demanda__id()===null){$historico->set__demanda__id("");}
if( $historico->get__observacao__id()===null){$historico->set__observacao__id("");}

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("
                       INSERT INTO historico (pessoa_id,usuario_id,demanda_id,observacao_id,acao) values (:pessoa_id,:usuario_id,:demanda_id,:observacao_id,:acao);");
             
            $stmt->bindValue(":pessoa_id", $historico->get__pessoa__id(), PDO::PARAM_INT);
            $stmt->bindValue(":usuario_id", $historico->get__usuario__id(), PDO::PARAM_INT);
            $stmt->bindValue(":demanda_id", $historico->get__demanda__id(), PDO::PARAM_INT);
            $stmt->bindValue(":observacao_id", $historico->get__observacao__id(), PDO::PARAM_INT);
            $stmt->bindValue(":acao", $historico->get__acao(), PDO::PARAM_STR);

            $stmt->execute();
            
            
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu no historico. <br>" . $ex->getMessage());
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








    public static function listar_historico($filtro) {
        $db = conexao::getConnection();
        
        
        $consulta="";
                        
        if($filtro!==""){
            $consulta=" 
            SELECT h.*,

            case
              when (h.pessoa_id) > 0
                 then (SELECT p.nome
                 FROM pessoa p WHERE p.pessoa_id=h.pessoa_id)
              when(h.demanda_id) > 0	 
                then (SELECT p.nome
                 FROM pessoa p INNER JOIN demanda d ON p.pessoa_id=d.pessoa_id WHERE d.demanda_id=h.demanda_id)
              when(h.observacao_id) > 0	 
                then (SELECT p.nome
                 FROM pessoa p INNER JOIN demanda d ON p.pessoa_id=d.pessoa_id INNER JOIN observacao o ON o.demanda_id=d.demanda_id WHERE o.observacao_id=h.observacao_id)
               ELSE ''
                        end as pessoa,
        u.usuario_nome,
           case
              when (h.demanda_id) > 0
                 then (SELECT concat( LEFT(d.demanda,20),'...')
                 FROM demanda d WHERE d.demanda_id=h.demanda_id)
             when (h.observacao_id) > 0
                 then (SELECT concat( LEFT(d.demanda,20),'...')
                 FROM observacao o INNER JOIN demanda d ON d.demanda_id=o.demanda_id WHERE o.observacao_id=h.observacao_id)
               ELSE ''
                        end as demanda,	
            date_format(`data`,'%d/%m/%Y %H:%i') AS 'cadastro',
            case
              when (h.observacao_id) > 0
                 then (SELECT concat( LEFT(o.observacao,20),'...')
                 FROM observacao o WHERE o.observacao_id=h.observacao_id)
               ELSE ''
                        end as observacao
                FROM historico h INNER JOIN usuario u ON u.usuario_id=h.usuario_id
                where ".$filtro."
                          order by data desc
         ";  
            
        }else{
        $consulta="                    
        SELECT h.*,

           case
					   when (h.pessoa_id) > 0
						    then (SELECT p.nome
							  FROM pessoa p WHERE p.pessoa_id=h.pessoa_id)
						 when(h.demanda_id) > 0	 
							 then (SELECT p.nome
							  FROM pessoa p INNER JOIN demanda d ON p.pessoa_id=d.pessoa_id WHERE d.demanda_id=h.demanda_id)
						 when(h.observacao_id) > 0	 
							 then (SELECT p.nome
							  FROM pessoa p INNER JOIN demanda d ON p.pessoa_id=d.pessoa_id INNER JOIN observacao o ON o.demanda_id=d.demanda_id WHERE o.observacao_id=h.observacao_id)
							ELSE ''
                       end as pessoa,
       u.usuario_nome,
      	  case
					   when (h.demanda_id) > 0
						    then (SELECT concat( LEFT(d.demanda,20),'...')
							  FROM demanda d WHERE d.demanda_id=h.demanda_id)
						when (h.observacao_id) > 0
						    then (SELECT concat( LEFT(d.demanda,20),'...')
							  FROM observacao o INNER JOIN demanda d ON d.demanda_id=o.demanda_id WHERE o.observacao_id=h.observacao_id)
							ELSE ''
                       end as demanda,	
           date_format(`data`,'%d/%m/%Y %H:%i') AS 'cadastro',
           case
					   when (h.observacao_id) > 0
						    then (SELECT concat( LEFT(o.observacao,20),'...')
							  FROM observacao o WHERE o.observacao_id=h.observacao_id)
							ELSE ''
                       end as observacao
               FROM historico h INNER JOIN usuario u ON u.usuario_id=h.usuario_id
												 order by data desc
        ";
        }
     


                            $result = $db->query($consulta);
                            
                            $l="
                            <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                            <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                        </nav>  
                            
                            
                            <div class=\"tabela\" style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >  
                            <table class=\"table table-striped table-responsive-md table-responsive-sm table-responsive-lg\" >
                            <thead class=\"bg-custom-15\" >
                            <tr>
                              
                              <th>Usuário</th>
                              <th>Data</th>
                              <th>Ação</th>
                              <th>Pessoa</th>
                              <th>Demanda</th>
                              <th>Observação</th>
                              
                              </thead>
                              </tr>
                              <tbody style=\"background-color:#f0fff7;\">";
                         
                           
                   
                            while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                //print_r($rows);
                               
                                //Aqui criamos o cabeçalho da tabela.
                                // A tag <tr> abre uma linha, enquanto a <td> abre uma célula.
                                $l.= "<tr><td align-items=\"center\">".$rows['usuario_nome']."</td>"
                                ."<td align-items=\"center\">".$rows['cadastro']."</td>"
                                ."<td align-items=\"center\">".$rows['acao']."</td>"
                                ."<td align-items=\"center\">".$rows['pessoa']."</td>"
                                    ."<td align-items=\"center\">".$rows['demanda']."</td>"
                                    ."<td align-items=\"center\">".$rows['observacao']."</td>
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