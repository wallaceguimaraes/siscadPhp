<?php


include_once('conexao.php');
include_once('model/m_demanda.php');


/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class solicitacaodemanda_dao {



    function atualizar($id, $status) {

        try {
            
            $db = conexao::getConnection();            
            if($status==="REPROVADA"){
              $stmt = $db->prepare("
              UPDATE 
                demanda SET status=:status
                where demanda_id=:demanda_id");
            }else{

              $status="ANDAMENTO";
              $stmt = $db->prepare("
              
              UPDATE 
                demanda SET status=:status
                where demanda_id=:demanda_id");


            }

             
            $stmt->bindValue(":demanda_id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":status", $status, PDO::PARAM_STR);
                                  
                                  
                                
                           $stmt->execute();
            if($status==="REPROVADA"){
              return 3;
            }else{
              return 4;
            }
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao atualizar a demanda. <br>" . $ex->getMessage());
            throw $e;
        }
    }
/*
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

*/

    function selecionar($id,$id2){                           
    
        $db = conexao::getConnection();
        
        $consulta="";
        if($id2!==""){

          $consulta ="
          SELECT COUNT(d.demanda_id) cont, d.*,
          date_format(`dt_cadastro`,'%d/%m/%Y') as `cadastro_format`,
          date_format(`dt_atualiza`,'%d/%m/%Y') as `atualiza_format`
    FROM demanda d 
    WHERE d.demanda_id=".$id." and d.status='ABERTO'";
    

        }else{
          $consulta ="
          SELECT COUNT(p.pessoa_id) cont, p.*,
          date_format(`dt_nasc`,'%d/%m/%Y') as `nasc_format`,
          date_format(`dt_exp`,'%d/%m/%Y') as `exp_format`,
          date_format(`dt_cadastro`,'%d/%m/%Y') as `cadastro_format`,
          date_format(`dt_atualiza`,'%d/%m/%Y') as `atualiza_format`
    FROM pessoa p  
    WHERE p.pessoa_id=".$id."";
    

        }
        

							$result = $db->query($consulta);
							
							$cont=0;
							$sessao=0;
							$valor;
							if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                               $valor=$rows["ativo"];                             
                            }

                            $identificacao="";  


                            if($id2===""){

                            $identificacao= "
                            <form class=\"bg-custom-72\" id=\"principal\" style=\"height: 18rem;  padding: 0.3rem;  border-radius: 0.3rem; margin: 0%; margin-bottom:0.5rem;\" >
                            <input type=\"hidden\" id=\"pessoa_id\" value=\"".$rows["pessoa_id"]."\"></input>
                                   <div class=\"form-row\" style=\"padding-top:1rem; \">
                                   <div id=\"imagem\" class=\"form-group col-md-3 img-center\" style=\"height:15.5rem; width:14rem;\">                             
                                   <img src=\"../".$rows["foto"]."\"  width=\"100%\" height=\"100%\" onerror=\"this.src='../uploads/semimagem.jpeg';\" class=\"img-responsive img-rounded \">
                                   </div>    
                                   
                                   
                                      <div class=\"form-group col-md-4\" >
                                         <label for=\"nome\">Nome completo</label>
                                         <input disabled type=\"text\" value=\"".$rows["nome"]."\" class=\"form-control\" id=\"nome\">
                                      
                                         <div class=\"form-group col-md-15\" style=\"padding-top:1rem;\" >
                                         <label for=\"dt-nasc\">Nascimento</label>
                                         <input disabled type=\"text\" value=\"".$rows["nasc_format"]."\" class=\"form-control\" id=\"dt-nasc\">
                                         </div>
  
                                         <div class=\"form-group col-md-15\" style=\"padding-top:0.2rem;\" >
                                         <label for=\"contato\">Contato</label>
                                         <input disabled type=\"text\" value=\"".$rows["telefone1"]."\" class=\"form-control\" id=\"contato\">
                                         </div>
                                      
                          

                                         </div>
                                      
                                       <div  class=\"form-group col-md-3\">
                                               <label for=\"cpf\">CPF</label>
                                               <input disabled type=\"text\" value=\"".$rows["cpf"]."\" class=\"form-control\" id=\"cpf\">
                                      
                                      
                                               <div class=\"form-group col-md-15\" style=\"padding-top:1rem;\">
                                                 <label for=\"rg\">RG</label>
                                                 <input disabled type=\"text\" value=\"".$rows["rg"]."\" class=\"form-control\" id=\"rg\">
                                               </div>                                                           
                                               </div> 
                    
                         </div>
                           </form> ";

                            }

                          $view="
                        
                       <div class=\"bg-custom-73\" style=\" border:1px solid green; height:17rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%; justify-content: center; justify-items: center;\">
                     
                   
                     
                     
                         
                  
                                    <div class=\"form-row\">
                                      <div class=\"form-group col\" style=\"text-align: center;\">
                                        <button hidden type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('demanda.salvar','pessoa_id|demanda',null,null,'demanda')\">Gravar</button>
                                    </div>  
                                    </div>
                                  
                </div>
                            ";

                            if($id2===""){
                              return $view."¨".$identificacao;  
                            }
                            return $view;


//                          return $valor;

    }














    function selecionar2($id,$ativo){
      
      $ativoBtn=""; 

        if($ativo=="disabled"){
          $ativoBtn="hidden";
        }else{
            $ativoBtn="";
        }

    
      $db = conexao::getConnection();
      

        $consulta ="
        SELECT COUNT(d.demanda_id) cont, d.*,
        date_format(`data_cadastro`,'%d/%m/%Y') as `cadastro_format`,
        date_format(`data_atualiza`,'%d/%m/%Y') as `atualiza_format`
  FROM demanda d  
  WHERE d.demanda_id=".$id." and d.status='ABERTO'";

            $result = $db->query($consulta);
            
            $cont=0;
            $sessao=0;
            $valor="";

                        
                     if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                             $valor=$rows["demanda"]."|".$rows["ativo"];                             
                          }

   
                        $view="
                      
                     <div class=\"bg-custom-73\" style=\" border:1px solid green; height:17rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%; justify-content: center; justify-items: center;\">
                   
                     <div class=\"form-row\">
                     <div class=\"form-group col-md-11\" style=\" margin-left:3rem; padding-right:3rem;\">
                         <span style=\"margin-top:1rem;\" for=\"demanda\">Demanda<span style=\"color: red;\">*</span>
                         </span>

                         <textarea ".$ativo." class=\"form-control\" id=\"demanda\" rows=\"3\">".$rows["demanda"]."</textarea>
                         <label style=\"margin-top:1rem;\">SITUAÇÃO: ".$rows["status"]."</label>

                         </div>               
                       
                   </div>
                   
                   <div class=\"form-row\" style=\"justify-content:space-between;\">
                   <div class=\"form-group col-md-3\" style=\"text-align: center;\">
                    <label>Cadastro: ".$rows["cadastro_format"]."</label> 
                 </div> 
                 <div class=\"form-group col-md-3\" style=\"text-align: center;\">
                    <label>Última atualização: ".$rows["atualiza_format"]."</label> 
                 </div>  
                 </div>
                       
                
                                  <div class=\"form-row\">
                                    <div class=\"form-group col\" style=\"text-align: center;\">
                                      <button ".$ativoBtn." type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('demanda.salvar','pessoa_id|demanda',".$rows["demanda_id"].",null,'demanda')\">Gravar</button>
                                  </div>  
                                  </div>
                                
              </div>
                          ";

                          return $view;


//                          return $valor;

  }













    public static function listar_pessoa($filtro) {
        $db = conexao::getConnection();
    

        if($filtro!==""){
            $consulta=" 
                     SELECT distinct(p.cpf)p.* FROM pessoa p inner join demanda d on d.pessoa_id
                     =p.pessoa_id where ".$filtro." and p.ativo='SIM' order by p.nome asc";  
            
        }else{
        $consulta ="
                    SELECT distinct(p.cpf), p.*
                    FROM pessoa p inner join demanda d on d.pessoa_id
                    =p.pessoa_id where p.ativo='SIM' and d.status='ABERTO' order by p.nome asc ";
        }

    

                            $result = $db->query($consulta);
                            
                            $l="
                            <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                            <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                        </nav>  
                            
                            
                            <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:auto;\" > 
                            <table class=\"table table-striped \" >
                            <thead class=\"bg-custom-15\" >
                            <tr>
                              
                              <th>Nome</th>
                              <th>RG</th>
                              <th style=\" width:12rem;\">Contato</th>
                              <th align=right; style=\"text-align:center; width:3rem;\">Ação</th>
                              </thead>
                              </tr>
                            <tbody style=\"background-color:#f0fff7;\">";
                         
                           
                   
                            while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                //print_r($rows);
                                              
                                //Aqui criamos o cabeçalho da tabela.
                                // A tag <tr> abre uma linha, enquanto a <td> abre uma célula.
                                $l.= "<tr><td align-items=\"center\">".$rows['nome']."</td>"
                                    ."<td align-items=\"center\">".$rows['rg']."</td>"
                                    ."<td align-items=\"center\">".$rows['telefone1']."</td>"
                                    ."<td style=\"width:12rem;\"align=\"center\">
                                   
                                    <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Selecionar\" id=\"btSelecionar\" onclick=\"selecionar(".$rows['pessoa_id'].",'solicitacaodemanda.editar')\" name=\"btSelecionar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-checkmark-48.png\"></img></td>"                          
                                    ."</tr>";  
                          
                                }
                            $l.= "</tbody>
                            </table>
                            </div>";
    
                    
                            //setar_texto("tabela-resultado",$l);
                            



                            return $l;
        }
    

 
        public static function listar_demanda($filtro,$id) {
          $db = conexao::getConnection();
      
          
          if($filtro!==""){
              $consulta=" 
                       SELECT d.*,
                       date_format(`data_cadastro`,'%d/%m/%Y') as `cadastro`,
                       case 
                       when length(d.demanda) > 70 then concat( left(d.demanda,70),'...')
                       else d.demanda
                       end as dem_70c
                       FROM demanda d where ".$filtro." and d.ativo='SIM' and d.status='ABERTO' order by d.data_cadastro desc";  
              
          }else{
          $consulta ="
                      SELECT d.*
                      FROM demanda d where d.ativo='SIM' and d.status='ABERTO' order by d.data_cadastro desc ";
          }
        


          $tamanho=strlen($filtro);
          $pessoa_id="";
  
          if($tamanho>20){
            $pessoa_id=$id;            
          }
                 
          $id = strstr($filtro, '=');
          
          if($tamanho<20){
            $filtro=explode("=", $filtro);
            $pessoa_id=$filtro[1];
        
          }
                              $result = $db->query($consulta);
                              
                              $l="
                              <input hidden type=\"text\" id=\"pessoa_id\" value=".$pessoa_id." />
                              <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                              <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                              </nav>  
                                 
                              <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >  
                              <table class=\"table table-striped table-responsive-sm table-responsive-md table-responsive-lg \" >
                              <thead class=\"bg-custom-15\" >
                              <tr>
                                
                                <th style=\"width:50%;\">Demanda</th>
                                <th style=\"width:10%;\">Data</th>
                                <th style=\"width:10%;\">Situação</th>
                                <th align=right; style=\"text-align:center; width:3rem;\">Ação</th>
                                </thead>
                                </tr>
                              <tbody style=\"background-color:#f0fff7;\">";

                              $btnCancel="";
                              $btnFinish="";
                              $btnObs="";
                              $btnVer="";
                              $btnEditar="";  
                              while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                //if($rows['status']==="CANCELADA"){$btnCancel="hidden"; $btnEditar="hidden"; $btnFinish="hidden";}  
                                //if($rows['status']==="CONCLUÍDA"){$btnCancel="hidden"; $btnEditar="hidden"; $btnFinish="hidden";}  
                                //if($rows['status']==="ANDAMENTO"){$btnCancel=""; $btnEditar=""; $btnFinish="";$btnObs="";}  

                                  $l.= "<tr><td align-items=\"center\">".$rows['dem_70c']."</td>"
                                      ."<td align-items=\"center\">".$rows['cadastro']."</td>"
                                      ."<td align-items=\"center\">".$rows['status']."</td>"
                                      ."<td style=\"width:12rem;\"align=\"center\">        
                                      <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Aprovar demanda\" id=\"btEditar\" onclick=\"selecionar(".$rows['demanda_id'].",'solicitacaodemanda.aprovar',null,'pessoa_id','naoMuda')\" name=\"btEditar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-task-completed-48.png\"></img>                          
                                      <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$rows['demanda_id'].",'demanda.visualizar',null,null,'pessoa_id')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                      <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Reprovar demanda\" id=\"btEditar\"  onclick=\"selecionar(".$rows['demanda_id'].",'solicitacaodemanda.reprovar',null,'pessoa_id','naoMuda')\" name=\"btEditar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-cancel-48.png\"></img>
                                      
                                      
                                      "
                                      ."</tr>";  
                            
                                  }
                              $l.= "</tbody>
                              </table>
                              </div>";
      
                      
                              //setar_texto("tabela-resultado",$l);
                              


                              return $l;
          }
   




}