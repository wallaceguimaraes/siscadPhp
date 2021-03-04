<?php


include_once('conexao.php');
include_once('model/m_pessoa.php');
include_once('model/m_historico.php');
include_once("dao/historico_dao.php");

/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class pessoa_dao {


function validarCPF($cpf){
  $db = conexao::getConnection();
  $consulta=" 
                     SELECT COUNT(p.pessoa_id)cont,p.*
                      FROM pessoa p where p.cpf='".$cpf."'";
  $result = $db->query($consulta);   


	if($rows=$result->fetch(PDO::FETCH_ASSOC)){
    $valor=$rows["nome"];                             
  
  }
if($rows["cont"]>0){

  return 1;
}else{
return 0;
}


}


function validarRg($rg){
  $db = conexao::getConnection();
  $consulta=" 
                     SELECT COUNT(p.pessoa_id)cont,p.*
                      FROM pessoa p where p.rg='".$rg."'";
  $result = $db->query($consulta);   


	if($rows=$result->fetch(PDO::FETCH_ASSOC)){
    $valor=$rows["nome"];                             
  
  }
if($rows["cont"]>0){

  return 1;
}else{
return 0;
}


}




 function salvar(m_pessoa $pessoa) {

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("INSERT INTO pessoa (
                categoria_id,nome,apelido,dt_nasc,cpf,
                como_chega,nome_mae,rg,dt_exp,nis_pis,sus,titulo,endereco,complemento,
                municipio,estado,cep,telefone1,telefone2,telefone_fixo,foto) 
                VALUES (:categoria_id,:nome,:apelido,:nasc,:cpf,:chega,:mae,:rg,
                :exp,:nis,:sus,:titulo,:end,:complemento,:municipio,:estado,:cep,:tel1,:tel2,:telfixo,:foto);");
             
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
             $stmt->bindValue(":foto", $pessoa->get__foto(), PDO::PARAM_STR);
             //$stmt->bindValue(22, $pessoa->get__ativo(), PDO::PARAM_STR);
             //$stmt->bindValue(":pessoa_id", $pessoa->get__pessoa__id(), PDO::PARAM_STR);


             $stmt->execute();

           
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar um pessoa. <br>" . $ex->getMessage());
            throw $e;
        }
    }






    

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
            
            
    
            return 2;
            
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
            
            
    
            return 3;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao excluir o pessoa. <br>" . $ex->getMessage());
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


      $db_cat = conexao::getConnection();
      $consulta_cat=" 
                         SELECT c.*
                          FROM categoria c where c.ativo='SIM' order by categoria asc ";
      $result_cat = $db_cat->query($consulta_cat);          
     


      $consultaEstado="
      SELECT e.*
      FROM estado e order by estado asc ";
      $db2 = conexao::getConnection();
    
                        $result_estado=$db2->query($consultaEstado);


     /*
      $arrayCategoria = array();
      while($rows_cat=$result_cat->fetch(PDO::FETCH_ASSOC)){
       $arrayCategoria[$rows_cat["categoria_id"]]=$rows_cat["categoria"];
        }
 */

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
              $loopselect=" ";
              $loopselect2=" ";                            
 /*
              foreach ($arrayCategoria as $id => $valor) {
                              if($id==$rows['categoria_id']){
                                $loopselect.=  "<option value=".$id." selected > ".$valor."</option>";
                              }else{  
                              $loopselect.= "<option value=".$id.">".$valor."</option>" ;                             
                              }                              
                          }
   */                       
               while($rows_cat=$result_cat->fetch(PDO::FETCH_ASSOC)){
                if($rows_cat['categoria_id']==$rows['categoria_id']){
                  $loopselect.=  "<option value=".$rows_cat['categoria_id']." selected > ".$rows_cat['categoria']."</option>";
                }else{  
                $loopselect.= "<option value=".$rows_cat['categoria_id'].">".$rows_cat['categoria']."</option>" ;                             
                }  
                } 
 
                while($rows_estado=$result_estado->fetch(PDO::FETCH_ASSOC)){
                  if($rows_estado['estado_id']==$rows['estado']){
                    $loopselect2.=  "<option value=".$rows_estado['estado_id']." selected > ".$rows_estado['estado']."</option>";
                  }else{  
                  $loopselect2.= "<option value=".$rows_estado['estado_id'].">".$rows_estado['estado']."</option>" ;                             
                  }  
                  } 


                          $view="
                           
                           <form class=\"bg-custom-7\" id=\"principal\" style=\"height: 68rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%;\" >
                           <input type=\"hidden\" id=\"pessoa_id\" value=\"".$rows["pessoa_id"]."\"></input>
                                  <div class=\"form-row\" style=\"padding-top:1rem;  justify-content: space-between;\">
                                  <div id=\"imagem\" class=\"form-group col-md-4 img-center\" style=\" height:18rem; width:20rem;\" >                             
                                  <img src=\"../".$rows["foto"]."\"  width=\"100%;\" height=\"100%;\" onerror=\"this.src='../uploads/semimagem.jpeg';\" class=\"img-responsive img-rounded \">
                                  </div>    
                                  
                                  
                                     <div class=\"form-group col-md-4\">
                                        <label for=\"nome\">Nome completo<span style=\"color: red;\">*</span></label>
                                        <input ".$ativo." type=\"text\" value=\"".$rows["nome"]."\" class=\"form-control\" id=\"nome\">
                                     
                                        <div class=\"form-group col-md-15\" style=\"padding-top:2rem;\" >
                                        <label for=\"nome-mae\">Nome da mãe</label>
                                        <input ".$ativo." type=\"text\" value=\"".$rows["nome_mae"]."\" class=\"form-control\" id=\"nome-mae\">
                                      </div>

                                      <div style=\"padding-top:2rem;\" class=\"form-group col-md-15\">
                                      <label for=\"dt-nasc\">Nascimento<span style=\"color: red;\">*</span></label>
                                      <input ".$ativo." type=\"text\" value=\"".$rows["nasc_format"]."\" class=\"form-control\" id=\"dt-nasc\" onkeypress=\"$(this).mask('99/99/9999')\" >
                                      </div>     
                                        </div>
                                     
                                      <div  class=\"form-group col-md-3\">
                                              <label for=\"cpf\">CPF<span style=\"color: red;\">*</span></label>
                                              <input ".$ativo." disabled type=\"text\" value=\"".$rows["cpf"]."\" class=\"form-control\" id=\"cpf\" onkeypress=\"$(this).mask('999.999.999-99')\">
                                     
                                     
                                              <div class=\"form-group col-md-15\" style=\"padding-top:2rem;\">
                                                <label for=\"apelido\">Apelido</label>
                                                <input ".$ativo." type=\"text\" value=\"".$rows["apelido"]."\" class=\"form-control\" id=\"apelido\">
                                              </div>
                        
                                              <div class=\"form-group col-md-15\"  style=\"padding-top:2rem;\">
                                              <label for=\"eleitor\">Título<span style=\"color: red;\">*</span></label>
                                              <input ".$ativo." type=\"text\" value=\"".$rows["titulo"]."\" class=\"form-control\" id=\"eleitor\">
                                            </div>
                                    
                                           
                                              

                                              </div> 
                                     
                                      
                                      
                                         
                  
                                      </div>
                              
                                <div class=\"form-row\" style=\" padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                  
                                <div class=\"form-group col-md-4\">
                                              <label for=\"nis-pis\">NIS/PIS<span style=\"color: red;\">*</span></label>
                                              <input ".$ativo." type=\"text\" value=\"".$rows["nis_pis"]."\" class=\"form-control\" id=\"nis-pis\">
                                            </div>
                  
                  
                                      <div class=\"form-group col-md-3\">
                                          <label for=\"rg\">RG<span style=\"color: red;\">*</span></label>
                                          <input ".$ativo." disabled type=\"text\" value=\"".$rows["rg"]."\" class=\"form-control\" id=\"rg\">
                                      </div>
                                          <div class=\"form-group col-md-2\">
                                              <label for=\"dt-exp\">Data expedição<span style=\"color: red;\">*</span></label>
                                              <input ".$ativo." type=\"text\" value=\"".$rows["exp_format"]."\" class=\"form-control\" id=\"dt-exp\"  onkeypress=\"$(this).mask('99/99/9999')\">
                                            </div>
                             
                  
                                </div>
                  
                                <div class=\"form-row\" style=\" padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                  
                                           <div class=\"form-group col-md-4\">
                                              <label for=\"sus\">Cartão SUS<span style=\"color: red;\">*</span></label>
                                              <input ".$ativo." type=\"text\" value=\"".$rows["sus"]."\"class=\"form-control\" id=\"sus\">
                                            </div>
                                           

                  
                              </div>
                  
                  
                  
                  
                  
                              <div class=\"form-row\" style=\" padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                                    <div class=\"form-group col-md-8\">
                                      <label for=\"como-chega\">Como chegou até nós?<span style=\"color: red;\">*</span></label>
                                      <input ".$ativo." type=\"text\" value=\"".$rows["como_chega"]."\" class=\"form-control\" id=\"como-chega\">                 
                                    </div>                
                  
                                            <div class=\"col-md-3\">
                                              <label for=\"categoria-id\">Categoria<span style=\"color: red;\">*</span></label>
                                              <select ".$ativo." id=\"categoria-id\" class=\"form-control\">
                                              <option></option>

                                              ".$loopselect."

                                          
                        
                                              </select>
                                              </div>
                                          </div>
                  
                            <div class=\"form-row\" style=\"padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                  
                              <div class=\"form-group col-md-7\">
                                  <label for=\"endereco\">Endereço<span style=\"color: red;\">*</span></label>
                                  <input ".$ativo." type=\"text\" value=\"".$rows["endereco"]."\" class=\"form-control\" id=\"endereco\">
                        </div>
                      
                        <div class=\"form-group col-md-3\">
                              <label for=\"municipio\">Município<span style=\"color: red;\">*</span></label>
                              <input ".$ativo." type=\"text\" value=\"".$rows["municipio"]."\" class=\"form-control\" id=\"municipio\">
                          </div>
                  
                          <div class=\"col-md-2\">
                                  <label for=\"estado\">Estado<span style=\"color: red;\">*</span></label>
                                  <select ".$ativo." id=\"estado\" class=\"form-control\">
                                    <option value=\"\" ></option>
                                    ".$loopselect2."
                                  </select>
                                </div>
                        </div>
                  
                  
                        <div class=\"form-row\" style=\"padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                        <div class=\"form-group col-md-7\">
                          <label for=\"complemento\">Complemento</label>
                          <input ".$ativo." type=\"text\" value=\"".$rows["complemento"]."\" class=\"form-control\" id=\"complemento\">        
                        </div>
                                                        
                                <div class=\"form-group col-md-2\">
                                  <label for=\"cep\">CEP</label>
                                  <input ".$ativo." type=\"text\" value=\"".$rows["cep"]."\" class=\"form-control\" id=\"cep\" onkeypress=\"$(this).mask('99999-999')\">
                              </div>
                      
                  
                              </div>
                  
                  
                              <div class=\"form-row\" style=\" justify-content: center; justify-items: center;\">
                  
                                <div class=\"form-group col-md-4\">
                                    <label for=\"tel1\">Telefone 1<span style=\"color: red;\">*</span></label>
                                    <input ".$ativo." type=\"text\" value=\"".$rows["telefone1"]."\" class=\"form-control\" id=\"tel1\" onkeypress=\"$(this).mask('(99) 9 9999-9999')\">
                                </div>
                        
                                      <div class=\"form-group col-md-4\">
                                        <label for=\"tel2\">Telefone 2</label>
                                        <input ".$ativo." type=\"text\" value=\"".$rows["telefone2"]."\" class=\"form-control\" id=\"tel2\" onkeypress=\"$(this).mask('(99) 9 9999-9999')\">
                                    </div>
                            
                        
                                    <div class=\"form-group col-md-4\">
                                      <label for=\"fixo\">Telefone fixo</label>
                                      <input ".$ativo." type=\"text\" value=\"".$rows["telefone_fixo"]."\" class=\"form-control\" id=\"fixo\" onkeypress=\"$(this).mask('(99) 9999-9999')\">
                                  </div>
                  
                                    </div>
                        
                  
                      
                                    <div class=\"form-row\" style=\" justify-content: space-between; justify-items: space-between;\">                             
                                    <div  class=\"form-group col-md-8\">
                                      <label ".$ativoBtn." for=\"foto\">Foto</label>
                                      <input ".$ativoBtn."  type=\"file\" class=\"form-control-file\" value=\"../".$rows["foto"]."\" style=\"border-radius:0.5rem 0.5rem;\" id=\"file\" name=\"file\">

                                      <input  hidden id=\"imag\" value=\"".$rows["foto"]."\"  />   
                                      <input  hidden id=\"arquivo\" value=\"".$rows["foto"]."\"  />   
                                      </div>
                                      <div  style=\"padding-top:0.5rem;\" class=\"form-group col-md-2\">
                                      <label for=\"dt-exp\">Data do cadastro</label>
                                      <label>".$rows["cadastro_format"]."</label>
                                    </div>
                                    <div style=\"padding-top:0.5rem;\" class=\"form-group col-md-2\">
                                    <label for=\"dt-cad\">Última atualização</label>
                                    <label>".$rows["atualiza_format"]."</label>
                                  </div>


                                    </div>
                                    <div class=\"form-row\">
                                      <div class=\"form-group col\" style=\"text-align: center;\">
                                        <button ".$ativoBtn." type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('pessoa.salvar','pessoa_id|categoria-id|nome|apelido|dt-nasc|cpf|como-chega|nome-mae|rg|dt-exp|nis-pis|sus|eleitor|endereco|complemento|municipio|estado|cep|tel1|tel2|fixo|ativo',".$rows["pessoa_id"].",'files','nome|cpf|dt-nasc|eleitor|nis-pis|rg|dt-exp|sus|como-chega|categoria-id|endereco|municipio|estado|tel1','arquivo')\" >Gravar</button>
                                    </div>  
                                    </div>
                                  
                
                            </form>";


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
                              <th>CPF</th>
                              <th style=\"width:12rem;\">Contato</th>
                              <th align=right; style=\"text-align:center; width:8rem;\">Ação</th>
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
                                    ."<td style=\"width:8rem;\"align=\"center\">
                                    <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$rows['pessoa_id'].",'pessoa.visualizar')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                    <img class=\"img-responsive img-rounded btn-excluir bg-custom-aviso\" title=\"Excluir\" id=\"btExcluir\" onclick=\"verificar('pessoa.excluir','nome',".$rows['pessoa_id'].",'Deseja realmente excluir a pessoa  \'".$rows['nome']." \' ?')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eraser-64.png\"></img>
                                    <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Editar\" id=\"btEditar\" onclick=\"selecionar(".$rows['pessoa_id'].",'pessoa.editar')\" name=\"btEditar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-pencil-48.png\"></img>
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