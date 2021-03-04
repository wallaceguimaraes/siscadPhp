<?php


include_once('conexao.php');
include_once('model/m_usuario.php');

/*
function setar_texto($id,$texto){
    print chr(2) . $id. chr(2) . $texto . chr(2);
}
*/
class usuario_dao {


function validaSenha($senha,$sessao){


		$custo = '08';
		$salt = 'Cf1f11ePArKlBJomM0F6aJ';
		// Gera um hash baseado em bcrypt
        $senha=crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
       // $senha=strtoupper($senha);

        $db = conexao::getConnection();

        
            $consulta=" 
                     SELECT COUNT(u.usuario_id)cont,u.* FROM usuario u where u.sessao='".$sessao."' and u.senha='".$senha."'";  
            
                   

                     $result = $db->query($consulta);
                       
                     if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                        
                        if($rows["cont"]>0){                        
                            return 1;
                          }else{
                          return 0;
                          }


                    }

                 


}







 function salvar(m_usuario $usu) {
//criptografar senha


$custo = '08';
$salt = 'Cf1f11ePArKlBJomM0F6aJ';
// Gera um hash baseado em bcrypt
$usu->set__senha(crypt($usu->get__senha(), '$2a$' . $custo . '$' . $salt . '$'));

        try {
            
            $db = conexao::getConnection();
            
            $stmt = $db->prepare("INSERT INTO usuario (usuario_nome, contato, email,login,senha,perfil_id) VALUES (?,?,?,?,?,?);");
            
//            print_r($db);
            
            $stmt->bindValue(1, $usu->get__nome(), PDO::PARAM_STR);
            $stmt->bindValue(2, $usu->get__contato(), PDO::PARAM_STR);
            $stmt->bindValue(3, $usu->get__email(), PDO::PARAM_STR);
            $stmt->bindValue(4, $usu->get__login(), PDO::PARAM_STR);
            $stmt->bindValue(5, $usu->get__senha(), PDO::PARAM_STR);
            $stmt->bindValue(6, $usu->get__perfil__id(), PDO::PARAM_INT);
            $stmt->execute();
            return 1;
            
        } catch (Throwable $ex) {
            return 0;
            $e = new Exception("Um erro ocorreu ao criar um usuario. <br>" . $ex->getMessage());
            throw $e;
        }
    }



    public static function atualizarDados(m_usuario $usuario) {

        $custo = '08';
        $salt = 'Cf1f11ePArKlBJomM0F6aJ';
        // Gera um hash baseado em bcrypt
        $usuario->set__senha(crypt($usuario->get__senha(), '$2a$' . $custo . '$' . $salt . '$'));
        
        try {
            $db = Conexao::getConnection();
            $stmt = $db->prepare("
            UPDATE usuario SET usuario_nome=:nome, contato=:contato, login=:login,
             senha=:senha,email=:email WHERE sessao=:sessao");
           
           
           
            $stmt->bindValue(":nome", $usuario->get__nome(), PDO::PARAM_STR);
            $stmt->bindValue(":contato", $usuario->get__contato(), PDO::PARAM_STR);
            $stmt->bindValue(":login", $usuario->get__login(), PDO::PARAM_STR);
            $stmt->bindValue(":senha", $usuario->get__senha(), PDO::PARAM_STR);
            $stmt->bindValue(":sessao", $usuario->get__sessao(), PDO::PARAM_STR);
  //          $stmt->bindValue(":perfil_id", $usuario->get__perfil__id(), PDO::PARAM_INT);
            $stmt->bindValue(":email", $usuario->get__email(), PDO::PARAM_STR);
//            $stmt->bindValue(":ativo", $usuario->get__ativo(), PDO::PARAM_STR);
            $stmt->execute();
       
       return 1;

        } catch (Throwable $ex) {
            $e = new Exception("Um erro ocorreu ao atualizar um usuario. <br>" . $ex->getMessage());
            throw $e;
        }
    }





    public static function atualizar(Usuario $dto) {
        try {
            $db = Conexao::getConnection();
            $stmt = $db->prepare("
            UPDATE usuario SET usuario_nome=:nome, contato=:contato, login=:login,
             senha=:senha,perfil_id=:perfil_id,email=:email, ativo=:ativo WHERE usuario_id=:usuario_id");
           
           
           
            $stmt->bindValue(":nome", $usuario->get__nome(), PDO::PARAM_STR);
            $stmt->bindValue(":contato", $usuario->get__contato(), PDO::PARAM_STR);
            $stmt->bindValue(":login", $usuario->get__login(), PDO::PARAM_STR);
            $stmt->bindValue(":senha", $usuario->get__senha(), PDO::PARAM_STR);
            $stmt->bindValue(":perfil_id", $usuario->get__perfil__id(), PDO::PARAM_INT);
            $stmt->bindValue(":email", $usuario->get__email(), PDO::PARAM_STR);
            $stmt->bindValue(":ativo", $usuario->get__ativo(), PDO::PARAM_STR);
            $stmt->execute();
       
       
        } catch (Throwable $ex) {
            $e = new Exception("Um erro ocorreu ao atualizar um usuario. <br>" . $ex->getMessage());
            throw $e;
        }
    }
    



    public static function excluir($id) {
        try {
            $db = Conexao::getConnection();
            $stmt = $db->prepare("
            UPDATE usuario SET ativo='NÃO' WHERE usuario_id=:usuario_id");
           
           
           
            $stmt->bindValue(":usuario_id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return 1;
       
        } catch (Throwable $ex) {
            $e = new Exception("Um erro ocorreu ao excluirr um usuario. <br>" . $ex->getMessage());
            throw $e;
        }
    }











/*
    static function Read($filtro, $orderby) {
        try {
            $db = Conexao::getConnection();
            $str = ("SELECT * FROM usuario");
            if ($filtro != "") {
                $str = $str . " WHERE " . $filtro;
            }
            if ($orderby != "") {
                $str = $str . " ORDER BY " . $orderby;
            }
            $stmt = $db->query($str);

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            $dtos = $stmt->fetchAll();
            return $dtos;
        } catch (Throwable $ex) {
            $e = new Exception("Um erro ocorreu ao obter dados do(s) usuario(s). <br>" . $ex->getMessage());
            throw $e;
        }
    }
    
*/

public static function listar_usuario($filtro) {
    $db = conexao::getConnection();

    if($filtro!==""){
        $consulta=" 
                 SELECT u.*,p.* FROM usuario u inner join perfil p on 
                 u.perfil_id=p.perfil_id where ".$filtro." order by u.usuario_nome asc";  
        
    }else{
    $consulta ="
             SELECT u.*,p.* FROM usuario u inner join perfil p on 
             u.perfil_id=p.perfil_id where u.ativo='SIM'";
    
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
                          
                          <th>Usuário</th>
                          <th>Perfil</th>
                          <th>E-mail</th>
                          <th>Contato</th>
                          <th style=\"text-align:center;\">Ação</th>
                          </thead>
                          </tr>
                        <tbody style=\"background-color:#f0fff7;\">";
                     
                       
               
                        while($rows=$result->fetch(PDO::FETCH_ASSOC)){
                            //print_r($rows);
                                          
                            //Aqui criamos o cabeçalho da tabela.
                            // A tag <tr> abre uma linha, enquanto a <td> abre uma célula.
                            $l.= "<tr><td align-items=\"center\">".$rows['usuario_nome']."</td>"
                                ."<td align-items=\"center\">".$rows['perfil']."</td>"
                                ."<td align-items=\"center\">".$rows['email']."</td>"
                                ."<td align-items=\"center\">".$rows['contato']."</td>"
                                ."<td style=\"width:12rem;\"align=\"center\">
                   
                                <img class=\"img-responsive img-rounded btn-excluir bg-custom-0\" title=\"Visualizar\" id=\"btVer\" onclick=\"selecionar(".$rows['usuario_id'].",'usuario.visualizar')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eye-40.png\"></img>
                                <img class=\"img-responsive img-rounded btn-excluir bg-custom-aviso\" title=\"Excluir\" id=\"btExcluir\" onclick=\"verificar('usuario.excluir','usuario',".$rows['usuario_id'].",'Deseja realmente excluir o usuário  \'".$rows['usuario_nome']."?')\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-eraser-64.png\"></img>
                                <img class=\"img-responsive img-rounded btn-editar bg-custom-5\" title=\"Editar\" id=\"btEditar\" onclick=\"selecionar(".$rows['usuario_id'].",'usuario.editar')\" name=\"btEditar\" style=\"width:1.65rem;height:1.65rem;\" src=\"../ico/icons8-pencil-48.png\"></img>
                                </td>"
                                
                                ."</tr>";  
                      
                            }
                        $l.= "</tbody>
                        </table>
                        </div>";


                return $l;
                        //setar_texto("tabela-resultado",$l);
                        
    }




    function selecionar($id,$ativo){

      
        $ativoBtn=""; 

        if($ativo=="disabled"){
          $ativoBtn="hidden";
        }else{
            $ativoBtn="";
        }

        $db_perfil = conexao::getConnection();
        $consulta_perfil=" 
                           SELECT p.*
                            FROM perfil p where p.ativo='SIM' order by perfil asc ";
        $result_perfil = $db_perfil->query($consulta_perfil);            

        $db = conexao::getConnection();						
		$consulta ="
                    SELECT COUNT(u.usuario_id) cont, u.*
            		FROM usuario u  
							WHERE u.usuario_id=".$id."";							
							$result = $db->query($consulta);
							$cont=0;
							$sessao=0;
							$valor;
                            $loopselect=" ";                            
                            
                              if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                $valor=$rows["usuario_nome"];                             
                             }
                                          while($rows_perfil=$result_perfil->fetch(PDO::FETCH_ASSOC)){
                                           if($rows_perfil['perfil_id']==$rows['perfil_id']){
                                             $loopselect.=  "<option value=".$rows_perfil['perfil_id']." selected > ".$rows_perfil['perfil']."</option>";
                                           }else{  
                                           $loopselect.= "<option value=".$rows_perfil['perfil_id'].">".$rows_perfil['perfil']."</option>" ;                             
                                           }  
                                           } 
                           $view= "
                           <form class=\"bg-custom-7\" id=\"principal\" style=\"height: 60rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%;\" >
                                    <input type=\"hidden\" id=\"usuario_id\" ></input>
                                           <div class=\"form-row\" style=\"padding-top:1rem;  justify-content: space-between; justify-items: space-between;\">
                                               <div class=\"form-group col-md-5\">
                                                 <label for=\"nome\">Nome<span style=\"color: red;\">*</span></label>
                                                 <input ".$ativo." type=\"text\" value=\"".$rows["usuario_nome"]."\" class=\"form-control\" id=\"nome\">
                                               </div>
                                              
                                               <div  class=\"form-group col-md-5\">
                                                       <label for=\"contato\">Contato</label>
                                                       <input ".$ativo." type=\"text\" value=\"".$rows["contato"]."\" class=\"form-control\" id=\"contato\" onkeypress=\"$(this).mask('(99) 9 9999-9999')\">
                                                   </div>                                               
                                              </div>
                                          
                                               <div class=\"form-row\"  style=\"justify-content: space-between; justify-items: space-between;\">
                             
                                               <div  class=\"form-group col-md-5\">
                                                   <label for=\"email\">Email<span style=\"color: red;\">*</span></label>
                                                   <input type=\"text\" ".$ativo." value=\"".$rows["email"]."\" class=\"form-control\" id=\"email\">
                                                 </div>
                        
                                              <div class=\"form-group col-md-5\">
                                                           <label for=\"login\">Login<span style=\"color: red;\">*</span></label>
                                                           <input type=\"text\" ".$ativo." value=\"".$rows["login"]."\" class=\"form-control\" id=\"login\">
                                                         </div>
                                             
                                               </div>
                                         <div hidden class=\"form-row\" style=\" padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                                         
                                         <div class=\"form-group col-md-5\">
                                                   <label for=\"senha\">Senha<span style=\"color: red;\">*</span></label>
                                                   <input type=\"password\" value=\"".$rows["senha"]."\" class=\"form-control\" id=\"senha\">
                                                 </div>
                        
                                                 <div  class=\"form-group col-md-5\">
                                                   <label for=\"r-senha\">Repetir senha<span style=\"color: red;\">*</span></label>
                                                   <input type=\"password\" class=\"form-control\" id=\"r-senha\">
                                                 </div>
                                       </div>
                                       <div class=\"form-row\" style=\" padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                                       <div class=\"col-md-5\">
                                                       <label for=\"perfil_id\">Perfil<span style=\"color: red;\">*</span></label>
                                                       <select ".$ativo." id=\"perfil_id\" class=\"form-control\">
                                                       <option></option>
                                                       ".$loopselect."                
                                                       </select>
                                                       </div>
                                                       <div style=\"margin-left:11.3rem;\" class=\"form-group col-md-2\">
                                                       <label for=\"ativo\">Ativo</label>
                                                       <select ".$ativo." id=\"ativo\" value=\"".$rows["ativo"]."\" class=\"form-control\">
                                                         <option value=\"SIM\">SIM</option>
                                                         <option value=\"NÃO\">NÃO</option>
                                                       </select>
                                                     </div>
                                                       <div class=\"form-group col\"  style=\" padding-top:2rem; text-align: right;\">
                                                 <button ".$ativoBtn." type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('usuario.salvar','usuario_id|nome|email|contato|login|senha|perfil_id',null,null,'perfil_id|nome|email|login|senha|r-senha')\" >Gravar</button>
                                             </div>  
                           
                                                   </div>
                           </form>
                           ";

                            return $view;

    }








 function selecionar2($sessao){

      
  

        $db_perfil = conexao::getConnection();
        $consulta_perfil=" 
                           SELECT p.*
                            FROM perfil p where p.ativo='SIM' order by perfil asc ";
        $result_perfil = $db_perfil->query($consulta_perfil);            

        $db = conexao::getConnection();						
		$consulta ="
                    SELECT COUNT(u.usuario_id) cont, u.*
            		FROM usuario u  
							WHERE u.sessao='".$sessao."'";							
							$result = $db->query($consulta);
							$cont=0;
							$sessao=0;
							$valor;
  
                          
                            $loopselect=" ";                            
                            
                              if($rows=$result->fetch(PDO::FETCH_ASSOC)){
                                $valor=$rows["usuario_nome"];                             
                             }
                                          while($rows_perfil=$result_perfil->fetch(PDO::FETCH_ASSOC)){
                                           if($rows_perfil['perfil_id']==$rows['perfil_id']){
                                             $loopselect =$rows_perfil['perfil'];
                                           
                                           }  
                                           } 
                           $view= "
                           <form class=\"bg-custom-7\" id=\"principal\" style=\"height: 60rem;  padding: 0.3rem; border-radius: 0.3rem; margin: 0%;\" >
                                    <input type=\"hidden\" id=\"usuario_id\" ></input>
                                           <div class=\"form-row\" style=\"padding-top:1rem;  justify-content: space-between; justify-items: space-between;\">
                                               <div class=\"form-group col-md-5\">
                                                 <label for=\"nome\">Nome<span style=\"color: red;\">*</span></label>
                                                 <input type=\"text\" value=\"".$rows["usuario_nome"]."\" class=\"form-control\" id=\"nome\">
                                               </div>
                                              
                                               <div  class=\"form-group col-md-5\">
                                                       <label for=\"contato\">Contato</label>
                                                       <input type=\"text\" value=\"".$rows["contato"]."\" class=\"form-control\" id=\"contato\" onkeypress=\"$(this).mask('(99) 9 9999-9999')\">
                                                   </div>                                               
                                              </div>
                                          
                                               <div class=\"form-row\"  style=\"justify-content: space-between; justify-items: space-between;\">
                             
                                               <div  class=\"form-group col-md-5\">
                                                   <label for=\"email\">Email<span style=\"color: red;\">*</span></label>
                                                   <input type=\"text\" value=\"".$rows["email"]."\" class=\"form-control\" id=\"email\">
                                                 </div>
                        
                                              <div class=\"form-group col-md-5\">
                                                           <label for=\"login\">Login<span style=\"color: red;\">*</span></label>
                                                           <input type=\"text\" value=\"".$rows["login"]."\" class=\"form-control\" id=\"login\">
                                                         </div>
                                             
                                               </div>
                                         <div class=\"form-row\" style=\" padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                                         
                                         <div class=\"form-group col-md-5\">
                                                   <label for=\"senha-atual\">Senha atual<span style=\"color: red;\">*</span></label>
                                                   <input type=\"password\" value=\"12154dfgdfgrhkja78\" class=\"form-control\" onblur=\"validaSenhaUsuario()\"  id=\"senha-atual\">
                                                   <div style=\"color:red;\" id=\"resposta\"></div>
                                                   
                                                   </div>
                        

                                                 <div  class=\"form-group col-md-5\">
                                                   <label for=\"senha\">Nova senha<span style=\"color: red;\">*</span></label>
                                                   <input type=\"password\" class=\"form-control\" id=\"senha\">
                                                 </div>
                                       </div>
                                       <div class=\"form-row\" style=\" padding-top:1rem; justify-content: space-between; justify-items: space-between;\">
                                       <div class=\"col-md-5\">
                                                       <label>Perfil: ".$loopselect."</label>
                                                       </div>
                                                       
                                                    <div id=\"botao\" class=\"form-\"  style=\" padding-top:0rem;  padding-right:1rem; text-align: right;\">
                                                       <button  style=\"display:none;\" type=\"button\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" id=\"btn-atualizar\" class=\"btn bg-custom-1 btn-gravar\" onclick=\"requisitar('usuario.atualizar','usuario_id|nome|email|contato|login|senha|perfil_id',null,null,'nome|email|login|senha')\" >Gravar</button>
                                                   </div>                           
                           
                                                   </div>
                           </form>

                        

                       ";

                            return $view;

    }












    static function delete(Usuario $dto){
       try {
        $db = Conexao::getConnection();
        $str = ("DELETE FROM usuario WHERE id=".$dto->getId());
        $stmt = $db->prepare($str);
        $stmt->execute();
        } catch (Throwable $ex) {
            $e = new Exception("Um erro ocorreu ao deletar dados do usuario. <br>" . $ex->getMessage());
            throw $e;
        }
    }
    
    

}