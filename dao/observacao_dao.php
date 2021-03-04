<?php


include_once('conexao.php');
include_once('model/m_observacao.php');


/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class observacao_dao {


    
 function salvar(m_observacao $observacao) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("INSERT INTO observacao (
                demanda_id,observacao) 
                VALUES (:demanda_id,:observacao);");
             
             $stmt->bindValue(":demanda_id", $observacao->get__demanda__id(), PDO::PARAM_INT);
             $stmt->bindValue(":observacao", $observacao->get__observacao(), PDO::PARAM_STR);
             
             $stmt->execute();

            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao salvar a observacao. <br>" . $ex->getMessage());
            throw $e;
        }
    }


    
/*
    function atualizar(m_pessoa $pessoa) {

        try {
            
            $db = conexao::getConnection();
            
            
            if($pessoa->get__foto()===""){

              $stmt = $db->prepare("

              UPDATE 
                pessoa SET categoria_id=:categoria_id, nome=:nome,apelido=:apelido,dt_nasc=:nasc,
                cpf=:cpf, como_chega=:chega, nome_mae=:mae,rg=:rg,dt_exp=:exp,nis_pis=:nis,
                sus=:sus,titulo=:titulo,endereco=:end,complemento=:complemento,municipio=:municipio,estado=:estado,
                cep=:cep,telefone1=:tel1,telefone2=:tel2,telefone_fixo=:telfixo
                where pessoa_id=:pessoa_id");



            }else{

              $stmt = $db->prepare("

              UPDATE 
                pessoa SET categoria_id=:categoria_id, nome=:nome,apelido=:apelido,dt_nasc=:nasc,
                cpf=:cpf, como_chega=:chega, nome_mae=:mae,rg=:rg,dt_exp=:exp,nis_pis=:nis,
                sus=:sus,titulo=:titulo,endereco=:end,complemento=:complemento,municipio=:municipio,estado=:estado,
                cep=:cep,telefone1=:tel1,telefone2=:tel2,telefone_fixo=:telfixo,foto=:foto
                where pessoa_id=:pessoa_id");




            }

             
                                  $stmt->bindValue(":categoria_id", $pessoa->get__categoria__id(), PDO::PARAM_INT);
                                  $stmt->bindValue(":nome", $pessoa->get__nome(), PDO::PARAM_STR);
                                  $stmt->bindValue(":apelido", $pessoa->get__apelido(), PDO::PARAM_STR);
                                  $stmt->bindValue(":nasc",date("Y-d-m H:i:s", strtotime($pessoa->get__dt__nasc())), PDO::PARAM_STR);
                                  $stmt->bindValue(":cpf", $pessoa->get__cpf(), PDO::PARAM_STR);
                                  $stmt->bindValue(":chega", $pessoa->get__como__chega(), PDO::PARAM_STR);
                                  $stmt->bindValue(":mae", $pessoa->get__nome__mae(), PDO::PARAM_STR);
                                  $stmt->bindValue(":rg", $pessoa->get__rg(), PDO::PARAM_STR);
                                  $stmt->bindValue(":exp", date("Y-d-m H:i:s", strtotime($pessoa->get__dt__exp())), PDO::PARAM_STR);
                                  $stmt->bindValue(":nis", $pessoa->get__nis__pis(), PDO::PARAM_STR);
                                  $stmt->bindValue(":sus", $pessoa->get__sus(), PDO::PARAM_STR);
                                  $stmt->bindValue(":titulo", $pessoa->get__titulo(), PDO::PARAM_STR);
                                  $stmt->bindValue(":end", $pessoa->get__endereco(), PDO::PARAM_STR);
                                  $stmt->bindValue(":complemento", $pessoa->get__complemento(), PDO::PARAM_STR);
                                  $stmt->bindValue(":municipio", $pessoa->get__municipio(), PDO::PARAM_STR);
                                  $stmt->bindValue(":estado", $pessoa->get__estado(), PDO::PARAM_STR);
                                  $stmt->bindValue(":cep", $pessoa->get__cep(), PDO::PARAM_STR);
                                  $stmt->bindValue(":tel1", $pessoa->get__tel__1(), PDO::PARAM_STR);
                                  $stmt->bindValue(":tel2", $pessoa->get__tel__2(), PDO::PARAM_STR);
                                  $stmt->bindValue(":telfixo", $pessoa->get__tel__fixo(), PDO::PARAM_STR);
                                 
                                 
                                  if($pessoa->get__foto()===""){

                                  }else{
                                    $stmt->bindValue(":foto", $pessoa->get__foto(), PDO::PARAM_STR);
                                  }
                                 
                                  
                                  //$stmt->bindValue(22, $pessoa->get__ativo(), PDO::PARAM_STR);
                                  $stmt->bindValue(":pessoa_id", $pessoa->get__pessoa__id(), PDO::PARAM_STR);
  
                           $stmt->execute();
            
            
    
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar um pessoa. <br>" . $ex->getMessage());
            throw $e;
        }
    }
*/
    function excluir(int $id) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("  
                               UPDATE observacao set ativo='NÃO'
                               where observacao_id=?");
             
                        
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
                    SELECT COUNT(p.pessoa_id) cont, p.*,
                    date_format(`dt_nasc`,'%d/%m/%Y') as `nasc_format`,
                    date_format(`dt_exp`,'%d/%m/%Y') as `exp_format`,
                    date_format(`dt_cadastro`,'%d/%m/%Y') as `cadastro_format`,
                    date_format(`dt_atualiza`,'%d/%m/%Y') as `atualiza_format`
							FROM pessoa p  
							WHERE p.pessoa_id=".$id."";
							
							$result = $db->query($consulta);
							
							$cont=0;
							$sessao=0;
							$valor;
							if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                               $valor=$rows["nome"]."|".$rows["ativo"];                             
                            }


                            $identificacao= "
                            <form class=\"bg-custom-72\" id=\"principal\" style=\"height: 21rem;  padding: 0.3rem;  border-radius: 0.3rem; margin: 0%; margin-bottom:0.5rem;\" >
                            <input type=\"hidden\" id=\"pessoa_id\" value=\"".$rows["pessoa_id"]."\"></input>
                                   <div class=\"form-row\" style=\"padding-top:1rem; \">
                                   <div id=\"imagem\" class=\"form-group col-md-4 img-center\" style=\"height:15.5rem; width:15rem;\">                             
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



                          $view="
                        
                       <div class=\"bg-custom-73\" style=\" border:1px solid green; height:17rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%; justify-content: center; justify-items: center;\">
                     
                       <div class=\"form-row\">
                       <div class=\"form-group col-md-11\" style=\"margin-left:3rem; padding-right:3rem;\">
                           <label style=\"margin-top:1rem; \" for=\"demanda\">Demanda<span style=\"color: red;\">*</span></label>
                           <textarea class=\"form-control\" id=\"demanda\" rows=\"3\"></textarea>
                         </div>               
                     
                     </div>
                     
                     
                         
                  
                                    <div class=\"form-row\">
                                      <div class=\"form-group col\" style=\"text-align: center;\">
                                        <button type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('demanda.salvar','pessoa_id|demanda',null,null,'demanda')\">Gravar</button>
                                    </div>  
                                    </div>
                                  
                </div>
                            ";


                            return $view."¨".$identificacao;


//                          return $valor;

    }





    function selecionar2($id,$ativo,$status){


    $estado="";
      if($status==="CONCLUÍDA"|$status==="CANCELADA"|$status==="REPROVADA"){
        $estado="hidden";
      }

      $ativoBtn=""; 

        if($ativo=="disabled"){
          $ativoBtn="hidden";
        }else{
            $ativoBtn="";
        }

    
      $db = conexao::getConnection();
      

        $consulta ="
        SELECT o.observacao,
              d.demanda_id,
              d.status,
              d.demanda,
              d.data_cadastro,
        date_format(o.data_cadastro,'%d/%m/%Y') as `cadastro`,
        date_format(d.data_cadastro,'%d/%m/%Y') as `cadastro_demanda`,
        concat( left(d.demanda,70),'...')dem_70c,
        concat( left(o.observacao,70),'...')obs_70c,
        DATE_FORMAT(o.data_atualiza,'%d/%m/%Y') as `atualiza`
  FROM observacao o inner join demanda d on o.demanda_id=d.demanda_id 
  WHERE o.observacao_id=".$id."";

            $result = $db->query($consulta);
            
            $cont=0;
            $sessao=0;
            $valor="";

                        
                     if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                             $valor=$rows["observacao"];
                          }

                          $consult ="
                          SELECT o.*,
                          date_format(o.data_cadastro,'%d/%m/%Y') as `cadastro`,                      
                          concat( left(o.observacao,70),'...')obs_70c,
                          DATE_FORMAT(o.data_atualiza,'%d/%m/%Y') as `atualiza`
                    FROM observacao o 
                    WHERE o.demanda_id=".$rows["demanda_id"]." and o.ativo='SIM' order by data_cadastro desc";

                    $resulta = $db->query($consult);

                          $view="
                          <div id=\"demanda__\" >
                          <input hidden type=\"text\" id=\"demanda_id\" value=".$rows["demanda_id"]." />
                          <div class=\"form-row\" style=\"padding: 0.3rem;  justify-content: space-between; justify-items: space-between;\">
                                     <div class=\"form-group col-md-8\">
                          
                          <label>Demanda: ".$rows["dem_70c"]."</label>
                                     </div>
                            <div class=\"form-group col-md-2\">
                                     <label>Cadastro: ".$rows["cadastro_demanda"]."</label>
                                     </div>
                          </div>
                          <div id=\"cadastro-pesquisa\">
                          <form id=\"principal\" class=\"bg-custom-73\" style=\"padding: 0.3rem; border-radius: 0.3rem; margin: 0%;\" >
                                 <div class=\"form-row\" style=\"padding-top:1rem;  justify-content: space-between; justify-items: space-between;\">
                                     <div class=\"form-group col-md-8\">
                                       <label for=\"observacao\">Observação<span style=\"color: red;\">*</span></label>
                                       <textarea ".$ativo." rows=\"6\" type=\"text\" class=\"form-control\" id=\"observacao\">".$rows["observacao"]."</textarea>                               
                                    </div>
                                                                  
                                    <div id=\"texbox-button\" class=\"form-group col-md-2 textbox-button\" style=\"text-align: left; margin-right:8rem; padding-top:2rem;\">
                                    <button ".$ativoBtn." type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('observacao.salvar','demanda_id|observacao',null,null,'observacao')\" >Gravar</button>
                                    </div>              

                                </div>
                                <div class=\"form-row\" style=\"\">
                                <div id=\"texbox-input\" class=\"form-group col-md-2 \" style=\"\" >
                                <label for=\"cadastro\">Cadastro</label>
                                <input type=\"text\" class=\"form-control\" onkeypress=\"$(this).mask('99/99/9999')\" id=\"cadastro-obs\"> 
                               </div>
                            
                               <div class=\"form-group col-md-1\" style=\"padding-right:25rem; text-align: left;\">                                        
                               <img class=\"img-responsive img-rounded btn-gravar bg-custom-2\" title=\"Pesquisar\" id=\"btPesquisar\" onclick=\"requisitar('observacao.pesquisar','demanda_id|observacao|cadastro-obs',null,null,null,null,'naoMuda','".$rows['status']."')\"  name=\"btPesquisar\" style=\" width:1.65rem;height:1.65rem; justify-content: center; justify-items: center; margin-top: 1.93rem; height: 2.2rem;\" src=\"../ico/icons8-search-48.png\"></img>                                                                            
                              </div>                                                
                            
                   
                           
                               </div>
                                

                           

                           </form>                                           
                          </div> 
                         

                          <div id=\"lista\">
                          <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                          <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                          </nav>  
                             
                          <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >  
                          <table class=\"table table-striped table-responsive-sm table-responsive-md table-responsive-lg \" >
                          <thead class=\"bg-custom-15\" >
                          <tr>
                            
                            <th style=\"width:60%;\">Observação</th>
                            <th style=\"width:5%;\">Cadastro</th>
                            <th style=\"width:5%;\">Atualização</th>
                            <th align=right; style=\"text-align:center; width:3rem;\">Ação</th>
                            </thead>
                            </tr>
                          <tbody style=\"background-color:#f0fff7;\">";
                       
                          while($row=$resulta->fetch(PDO::FETCH_ASSOC)){                              
                              $view.=  "<tr><td align-items=\"center\">".$row["obs_70c"]."</td>"
                                      ."<td align-items=\"center\">".$row["cadastro"]."</td>"
                                      ."<td align-items=\"center\">".$row["atualiza"]."</td>"
                                      ."<td style=\"width:12rem;\"align=\"center\">                                     
                                      <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$row['observacao_id'].",'observacao.visualizar',null,'demanda_id','naoMuda','".$status."')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                      <img ".$estado." class=\"img-responsive img-rounded btn-excluir bg-custom-aviso\" data-toggle=\"modal\" data-target=\"exampleModalCenterPerg\" title=\"Excluir\" id=\"btExcluir\" onclick=\"onclick=\"selecionar(".$row['observacao_id'].",'observacao.excluir',null,'demanda_id','naoMuda')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eraser-64.png\"></img></td>"
                                      ."</tr>";
                             
                                 }
                          
                            
                          $view.= "</tbody>
                          </table>
                          </div>
                          </div>";




                          return $view;


//                          return $valor;

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

    
       // var_dump($consulta);
       // exit;

                            $result = $db->query($consulta);
                            
                            $l="
                            <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                            <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                        </nav>  
                            
                            
                            <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" > 
                            <table class=\"table table-striped table-responsive-md table-responsive-sm table-responsive-lg\" >
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
                                   
                                    <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Selecionar\" id=\"btSelecionar\" onclick=\"selecionar(".$rows['pessoa_id'].",'demanda.editar')\" name=\"btSelecionar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-checkmark-48.png\"></img>"
                                                              
                                    ."</tr>";  
                          
                                }
                            $l.= "</tbody>
                            </table>
                            </div>";
    
                    
                            //setar_texto("tabela-resultado",$l);
                            
                            return $l;
        }
    

 
        public static function listar_observacao($filtro,$id,$flag,$status) {
          $db = conexao::getConnection();
          $db2= conexao::getConnection();

          $estado="";
          if($status==="CONCLUÍDA"|$status==="CANCELADA"|$status==="REPROVADA"){
           
            $estado="hidden";
          }

          $dem="";
          $cadast="";

          if($flag!==2){

            $consulta2="
            SELECT DISTINCT(d.demanda_id),DATE_FORMAT(d.data_cadastro,'%d/%m/%Y') AS 'cadastro_demanda',
            concat( left(d.demanda,70),'...')dem from demanda d
            where d.ativo ='SIM' ".$filtro."";
         
            $dados = $db2->query($consulta2);
            if($linha=$dados->fetch(PDO::FETCH_ASSOC)){
            $dem=$linha["dem"];
            $cadast=$linha["cadastro_demanda"];
            }

          }


         if($filtro!==""){

          

              $consulta=" 
              SELECT o.observacao,
                     o.observacao_id,
                     d.status,
                     d.demanda,
                     d.data_cadastro,                     
              case 
       when length(d.demanda) > 70 then concat( left(d.demanda,70),'...')
       ELSE d.demanda
       end as dem_70c,							        
       DATE_FORMAT(o.data_cadastro,'%d/%m/%Y') AS 'cadastro',
       DATE_FORMAT(o.data_atualiza,'%d/%m/%Y') AS 'atualiza',
              DATE_FORMAT(d.data_cadastro,'%d/%m/%Y') AS 'cadastro_demanda',
       d.demanda,
       case 
       when length(o.observacao) > 70 then concat( left(o.observacao,70),'...')
       else o.observacao
       end as obs_70c
       FROM observacao o inner join demanda d on o.demanda_id=d.demanda_id WHERE o.ativo='SIM' ".$filtro." ORDER BY o.data_cadastro desc";
          }else{
          $consulta ="
                      SELECT o.*
                      FROM observacao o order by o.data_cadastro desc ";
          }

        


          $tamanho=strlen($filtro);
          $demanda_id="";
  
          if($tamanho>20){
            $demanda_id=$id;  
            if($id===""){

              $filtro=explode("=", $filtro);
              $string= $filtro[1];
              $arr=explode(" ",$string);
              $demanda_id=$arr[0];
              $id=$demanda_id;
            } 

          }
  


          
          if($tamanho<20){
            $filtro=explode("=", $filtro);

            $demanda_id=(int)$filtro[1];
         
  
          }
    

$l="";


                              $result = $db->query($consulta);
                              $resulta = $db->query($consulta);
                              $resultado = $db->query($consulta);

                              if($rows=$result->fetch(PDO::FETCH_ASSOC)){

                                }

                                if($flag===2){

                              $l="<nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                              <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                              </nav>  
                                 
                              <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >  
                              <table class=\"table table-striped table-responsive-sm table-responsive-md table-responsive-lg \" >
                              <thead class=\"bg-custom-15\" >
                              <tr>
                                
                                <th style=\"width:50%;\">Observação</th>
                                <th style=\"width:10%;\">Cadastro</th>
                                <th style=\"width:10%;\">Atualização</th>
                                <th align=right; style=\"text-align:center; width:3rem;\">Ação</th>
                                </thead>
                                </tr>
                              <tbody style=\"background-color:#f0fff7;\">";
                           
                              while($row=$resulta->fetch(PDO::FETCH_ASSOC)){                              
                                  $l.=  "<tr><td align-items=\"center\">".$row["obs_70c"]."</td>"
                                          ."<td align-items=\"center\">".$row["cadastro"]."</td>"
                                          ."<td align-items=\"center\">".$row["atualiza"]."</td>"
                                          ."<td style=\"width:12rem;\"align=\"center\">                                     

                                          <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$row['observacao_id'].",'observacao.visualizar',null,'demanda_id','naoMuda','".$status."')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                          <img $estado class=\"img-responsive img-rounded btn-excluir bg-custom-aviso\" title=\"Excluir\" id=\"btExcluir\" onclick=\"selecionar(".$rows['observacao_id'].",'observacao.excluir',null,'demanda_id','naoMuda')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eraser-64.png\"></img></td>"
                                          ."</tr>";
                                 
                                     }
                              
                                
                              $l.= "</tbody>
                              </table>
                              </div>";



                                }
                              
                                else{
                                 $l="
                              <div id=\"demanda__\" >
                              <input hidden type=\"text\" id=\"demanda_id\" value=".$demanda_id." />
                              <div class=\"form-row\" style=\"padding: 0.3rem;  justify-content: space-between; justify-items: space-between;\">
                                         <div class=\"form-group col-md-8\">
                              
                              <label>Demanda: ".$dem."</label>
                                         </div>
                                <div class=\"form-group col-md-2\">
                                         <label>Cadastro: ".$cadast."</label>
                                         </div>
                              </div>
                              <div id=\"cadastro-pesquisa\">
                              <form id=\"principal\" class=\"bg-custom-73\" style=\"padding: 0.3rem; border-radius: 0.3rem; margin: 0%;\" >
                                     <div class=\"form-row\" style=\"padding-top:1rem;  justify-content: space-between; justify-items: space-between;\">
                                         <div class=\"form-group col-md-8\">
                                           <label for=\"observacao\">Observação<span style=\"color: red;\">*</span></label>
                                           <textarea rows=\"6\" type=\"text\" class=\"form-control\" id=\"observacao\"></textarea>                               
                                        </div>
                                                                      
                                        <div id=\"texbox-button\" class=\"form-group col-md-2 textbox-button\" style=\"text-align: left; margin-right:8rem; padding-top:2rem;\">
                                        <button ".$estado."  type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('observacao.salvar','demanda_id|observacao',null,null,'observacao',null,'naoMuda','".$rows['status']."')\" >Gravar</button>
                                        </div>              

                                    </div>
                                    <div class=\"form-row\" style=\"\">
                                    <div id=\"texbox-input\" class=\"form-group col-md-2 \" style=\"\" >
                                    <label for=\"cadastro\">Cadastro</label>
                                    <input type=\"text\" class=\"form-control\"  id=\"cadastro-obs\" onkeypress=\"$(this).mask('99/99/9999')\"> 
                                   </div>
                                
                                   <div class=\"form-group col-md-1\" style=\" padding-right:25rem; text-align: left;\">                                        
                                   <img class=\"img-responsive img-rounded btn-gravar bg-custom-2\" title=\"Pesquisar\" id=\"btPesquisar\" onclick=\"requisitar('observacao.pesquisar','demanda_id|observacao|cadastro-obs',null,null,null,null,'naoMuda','".$rows['status']."')\"  name=\"btPesquisar\" style=\" width:1.65rem;height:1.65rem; justify-content: center; justify-items: center; margin-top: 1.93rem; height: 2.2rem;\" src=\"../ico/icons8-search-48.png\"></img>                                                                            
                                  </div>                                                
                                
                       
                               
                                   </div>
                                    

                               

                               </form>                                           
                              </div> 
                             

                              <div id=\"lista\">
                              <nav class=\"navbar navbar-expand-lg navbar-light bg-custom-2\" style=\"background-color:#b328dd; color: #fff;\">
                              <h5><div id=\"titulo-acao\">Listagem</div></h5>              
                              </nav>  
                                 
                              <div  style=\"max-height:28rem; border-radius: 0.3rem;overflow-y:auto; overflow-x:hidden;\" >  
                              <table class=\"table table-striped table-responsive-sm table-responsive-md table-responsive-lg \" >
                              <thead class=\"bg-custom-15\" >
                              <tr>
                                
                                <th style=\"width:60%;\">Observação</th>
                                <th style=\"width:5%;\">Cadastro</th>
                                <th style=\"width:5%;\">Atualização</th>
                                <th align=right; style=\"text-align:center; width:3rem;\">Ação</th>
                                </thead>
                                </tr>
                              <tbody style=\"background-color:#f0fff7;\">";
                           
                              while($row=$resultado->fetch(PDO::FETCH_ASSOC)){                              
                                  $l.=  "<tr><td align-items=\"center\">".$row["obs_70c"]."</td>"
                                          ."<td align-items=\"center\">".$row["cadastro"]."</td>"
                                          ."<td align-items=\"center\">".$row["atualiza"]."</td>"
                                          ."<td style=\"width:12rem;\"align=\"center\">                                     
                                          <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$row['observacao_id'].",'observacao.visualizar',null,'demanda_id','naoMuda','".$status."')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                          
                                          <img $estado class=\"img-responsive img-rounded btn-excluir bg-custom-aviso\" data-toggle=\"modal\" data-target=\"exampleModalCenterPerg\" title=\"Excluir\" id=\"btExcluir\" onclick=\"selecionar(".$rows['observacao_id'].",'observacao.excluir',null,'demanda_id','naoMuda')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eraser-64.png\"></img></td>"
                                          ."</tr>";
                                 
                                     }
                              
                                
                              $l.= "</tbody>
                              </table>
                              </div>
                              </div>";
                                    }                                    
                          
                      
                              //setar_texto("tabela-resultado",$l);

                              return $l;
          }
   




}