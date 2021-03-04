<?php
/**
 * Description of Usuario
 *
 */
class m_usuario {
    private $usuario_id;
    private $perfil_id;
    private $nome;
    private $contato;
    private $email;
    private $login;
    private $senha;
    private $sessao;
    private $ativo;


    function get__usuario__id() {
        return $this->usuario_id;
    }

    function set__usuario__id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }


    function get__perfil__id() {
        return $this->perfil_id;
    }

    function set__perfil__id($perfil_id) {
        $this->perfil_id = $perfil_id;
    }



    function get__nome() {
        return $this->nome;
    }

    function set__nome($nome) {
        $this->nome = $nome;
        
    }

    function get__contato() {
        return $this->contato;
    }

    function set__contato($contato) {
        $this->contato = $contato;
    }



    function get__email() {
        return $this->email;
    }

    function set__email($email) {
        $this->email = $email;
    }

    
    function get__login() {
        return $this->login;
    }

    function set__login($login) {
        $this->login = $login;
    }

    function get__senha() {
        return $this->senha;
    }

    function set__senha($senha) {
        $this->senha =$senha;
    }


    function get__sessao(){
        return $this->sessao;
    }

    function set__sessao($sessao){
        $this->sessao = $sessao;

    }
    

    function get__ativo(){
        return $this->ativo;
    }

    function set__ativo($ativo){
        $this->ativo = strtoupper($ativo);

    }

}

