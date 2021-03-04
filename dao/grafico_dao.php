<?php


include_once('conexao.php');
//include_once('model/m_categoria.php');


/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class grafico_dao {


  public static function listar_pessoa_demanda() {
    $db = conexao::getConnection();
    
        $consulta=" 
                 
        SELECT DISTINCT(pessoa_id),nome,telefone1,telefone2,status
FROM 
(SELECT DISTINCT p.pessoa_id,p.nome,p.telefone1,p.telefone2,d.demanda,d.status,d.data_cadastro cadastro
FROM pessoa p inner join 
demanda d on p.pessoa_id=d.pessoa_id where p.ativo='SIM' AND d.`status`='ANDAMENTO'
ORDER BY d.data_cadastro asc) AS cont
        
        
        ";  
        

   // var_dump($consulta);
   // exit;

                        $result = $db->query($consulta);
                        
                        $l="
                        <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                        <h5><div id=\"titulo-acao\">Demandas em andamento</div></h5>              
                    </nav>  
                        
                        
                        <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:auto;\" > 
                        <table class=\"table table-striped\" >
                        <thead class=\"bg-custom-15\" >
                        <tr>
                          
                          <th>Nome</th>
                          <th>Contato 1</th>
                          <th>Contato 2</th>
                          <th>Situação</th>
                          <th align=right; style=\"text-align:center; width:3rem;\">Ação</th>
                          </thead>
                          </tr>
                        <tbody style=\"background-color:#f0fff7;\">";
                     
                       
               
                        while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                            //print_r($rows);
                                          
                            //Aqui criamos o cabeçalho da tabela.
                            // A tag <tr> abre uma linha, enquanto a <td> abre uma célula.
                            $l.= "<tr><td align-items=\"center\">".$rows['nome']."</td>"
                                ."<td align-items=\"center\">".$rows['telefone1']."</td>"
                                ."<td align-items=\"center\">".$rows['telefone2']."</td>"
                                ."<td align-items=\"center\">".$rows['status']."</td>"
                                ."<td align=\"center\">
                               
                                <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Selecionar\" id=\"btSelecionar\" onclick=\"selecionar(".$rows['pessoa_id'].",'demanda.editar')\" name=\"btSelecionar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-checkmark-48.png\"></img></td>"                          
                                ."</tr>";  
                      
                            }
                        $l.= "</tbody>
                        </table>
                        </div>";

                
                        return $l;
    }











     public static function preenche() {
        $db = conexao::getConnection();
    
                            
        $consulta="
        
   
SELECT COUNT(p.pessoa_id)pessoas,
case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p WHERE p.ativo='NÃO')>0)
  then (SELECT COUNT(p.pessoa_id)pes FROM pessoa p WHERE p.ativo='NÃO' )
  ELSE '0'
  END AS inativo,
case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p WHERE p.ativo='SIM')>0)
  then (SELECT COUNT(p.pessoa_id)pes FROM pessoa p WHERE p.ativo='SIM' )
  ELSE '0'
  END AS ativo,
case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
 WHERE d.status='CONCLUÍDA')>0)
  then 
  (
    SELECT COUNT(*) from ( select distinct(p.pessoa_id) FROM pessoa p INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
 WHERE d.status='CONCLUÍDA') AS contador
   )
   
  ELSE '0'
  END AS demanda_concluida,
case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
 WHERE d.status='CANCELADA')>0)
  then ( 
 SELECT COUNT(*) from ( select distinct(p.pessoa_id) FROM pessoa p INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
 WHERE d.status='CANCELADA') AS contador
 )
  ELSE '0'
  END AS demanda_cancelada,
case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
 WHERE d.status='ANDAMENTO')>0)
  then (
 SELECT COUNT(*) from ( select distinct(p.pessoa_id) FROM pessoa p INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
 WHERE d.status='ANDAMENTO') AS contador		   
 )
  ELSE '0'
  END AS demanda_andamento	  
                  FROM pessoa p     
        ";
    

    
                            $result = $db->query($consulta);
                            
                   $totalPessoas=0;
                   $ativas=0;
                   $inativas=0;
                   $concluidas=0;
                   $canceladas=0;
                   $andamento=0;

                    

                            if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                $totalPessoas=$rows["pessoas"];
                                $ativas=$rows["ativo"];
                                $inativas=$rows["inativo"];
                                $concluidas=$rows["demanda_concluida"];
                                $canceladas=$rows["demanda_cancelada"];
                                $andamento=$rows["demanda_andamento"];

                            }



                            $db = conexao::getConnection();
    
                            
                            $consulta="
    
                     
                            SELECT COUNT(d.demanda_id)cont,

                            case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
                                INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                                 WHERE d.status='CONCLUÍDA')>0)
                                  then ( SELECT COUNT(p.pessoa_id)con FROM pessoa p
                                INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                                 WHERE d.status='CONCLUÍDA')
                                  ELSE '0'
                                  END AS demanda_concluida,
                              case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
                                INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                                 WHERE d.status='CANCELADA')>0)
                                  then ( SELECT COUNT(p.pessoa_id)con FROM pessoa p
                                INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                                 WHERE d.status='CANCELADA')
                                  ELSE '0'
                                  END AS demanda_cancelada,
                              case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
                                INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                                 WHERE d.status='ANDAMENTO')>0)
                                  then ( SELECT COUNT(p.pessoa_id)con FROM pessoa p
                                INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                                 WHERE d.status='ANDAMENTO')
                                  ELSE '0'
                                  END AS demanda_andamento,
                                  case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
                            INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                             WHERE d.status='REPROVADA')>0)
                              then (
                             SELECT COUNT(*) from ( select distinct(p.pessoa_id) FROM pessoa p INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                             WHERE d.status='REPROVADA') AS contador		   
                             )
                              ELSE '0'
                              END AS demanda_reprovada,
                              case when ((SELECT COUNT(p.pessoa_id)con FROM pessoa p
                            INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                             WHERE d.status='ABERTO')>0)
                              then (
                             SELECT COUNT(*) from ( select distinct(p.pessoa_id) FROM pessoa p INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id		
                             WHERE d.status='ABERTO') AS contador		   
                             )
                              ELSE '0'
                              END AS demanda_aberto	  
                              FROM pessoa p INNER JOIN demanda d ON d.pessoa_id=p.pessoa_id 
                                

                          ";


                            $cont=0;
                            $d_concluidas=0;
                            $d_canceladas=0;
                            $d_andamento=0;
                            $d_reprovadas=0;
                            $d_aberto=0;

                            $result = $db->query($consulta);

                            if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                $cont=$rows["cont"];
                                $d_concluidas=$rows["demanda_concluida"];
                                $d_canceladas=$rows["demanda_cancelada"];
                               $d_andamento=$rows["demanda_andamento"];
                               $d_reprovadas=$rows["demanda_reprovada"];
                               $d_aberto=$rows["demanda_aberto"];
                            
                              }

                           // $tabela=$this::listar_pessoa_demanda();

                            return $totalPessoas."|".$ativas."|".$inativas."|".$concluidas."|".$canceladas."|".$andamento."|".$cont."|".$d_concluidas."|".$d_canceladas."|".$d_andamento."|".$d_reprovadas."|".$d_aberto;
        }
    
     




      }