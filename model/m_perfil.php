<?php
/**
 * Description of Usuario
 *
 */
class m_perfil{
   
    private $perfil_id;
    private $perfil;
    private $descricao;    
    private $ativo;


    function get__perfil__id() {
        return $this->perfil_id;
    }

    function set__perfil__id($perfil_id) {
        $this->perfil_id = $perfil_id;
    }


    function get__perfil() {
        return $this->perfil;
    }

    function set__perfil($perfil) {
        $this->perfil =strtoupper($perfil);
    
    }

    function get__descricao() {
        return $this->descricao;
    }

    function set__descricao($descricao) {
        $this->descricao = $descricao;
    }

    function get__ativo(){
        return $this->ativo;
    }

    function set__ativo($ativo){
        $this->ativo = strtoupper($ativo);

    }

}

