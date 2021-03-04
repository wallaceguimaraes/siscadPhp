<?php
	include_once("model/m_usuario.php");
	require_once("conexao.php");			

class login_dao{


	function valida_login(m_usuario $usuario){
		                     

		$cont;		

		$login=$usuario->get__login();
		
		$custo = '08';
		$salt = 'Cf1f11ePArKlBJomM0F6aJ';
		// Gera um hash baseado em bcrypt
		$senha=crypt($usuario->get__senha(), '$2a$' . $custo . '$' . $salt . '$');
		
        //$senha=$usuario->get__senha();

		$db = conexao::getConnection();						
		$consulta ="
					SELECT COUNT(u.usuario_id) cont,u.*,
					        p.perfil 
							FROM usuario u inner join perfil p on u.perfil_id=p.perfil_id 
							WHERE u.login= '$login' 
							and u.senha ='$senha' and u.ativo = 'SIM'";
							
							$result = $db->query($consulta);
							//$result = $rows->fetchAll();
							$cont=0;
							$sessao=0;
							$identifica="";

							if($rows=$result->fetch(PDO::FETCH_ASSOC)){}
							if($rows["cont"]==="0"){ echo 0;
								}else{
									$identifica="<label style=\" margin-left:0.5rem; padding-top:1rem; font-weight:bold; color:white;\">Perfil: ".$rows['perfil']."</label><p>
									<label style=\"margin-left:0.5rem; font-weight:bold; color:white;\" >Usuário: ".$rows['login']."</label>";
									
									$Sessao=date("YmdHis") . "-" .$rows['usuario_id'];
									$sql="UPDATE usuario SET sessao='$Sessao' WHERE usuario_id=". $rows['usuario_id'];
									$db->query($sql);
									
									$qry = "
									SELECT a.arquivo,a.arquivo_id,
														b.grupo_arquivo,
														b.grupo_arquivo_id,
														a.info,
														concat(LEFT(a.arquivo,INSTR(lower(a.arquivo),'.php')-1),'.inicio') AS inicio
													FROM
														arquivo a,
														grupo_arquivo b,
														perfil_arquivo c,
														usuario d
													WHERE
														c.arquivo_id=a.arquivo_id
														AND b.grupo_arquivo_id=a.grupo_arquivo_id
														AND c.perfil_id=d.perfil_id
														AND a.ativo='SIM'
														AND d.sessao='$Sessao'
													ORDER BY
														a.grupo_arquivo_id,
														a.info ASC";
														$db2= conexao::getConnection();
												$resul=$db2->query($qry);					
												$id_grupo = 0;
												$id_arquivo=0;
											
												$menu="
												
												<ul class=\"list-unstyled components\"> <li><ul>
												";
												while($rows=$resul->fetch(PDO::FETCH_ASSOC)){
												if($id_grupo!==$rows["grupo_arquivo_id"])
												{   
													$menu.="</ul></li>";
													$id_grupo=$rows["grupo_arquivo_id"];
												
													$menu.="<li class=\"active\"><a href=\"#homeSubmenu".$rows["grupo_arquivo_id"]."\" id=\"#homeSubmenu".$rows["grupo_arquivo_id"]."\" data-toggle=\"collapse\" aria-expanded=\"false\" class=\"dropdown-toggle collapsed\">".$rows["grupo_arquivo"]."</a>
													<ul class=\"collapse list-unstyled\" id=\"homeSubmenu".$rows["grupo_arquivo_id"]."\">";															

														$id_grupo=$rows["grupo_arquivo_id"];
												}
												
	     													if($rows["arquivo_id"]!==$id_arquivo){																
																$menu.="<li>
																<a href=\"#\" onclick=\"requisitar('".$rows["inicio"]."')\">".$rows["info"]."</a>
															</li>";
															$id_arquivo=$rows["arquivo_id"];																																										
															}																								
												}

												//session_start();
												$_SESSION['sessao']=$Sessao;


												echo "view/index.php|".$Sessao."%".$identifica."%".$menu;
											}	

												
						}																								

		}
