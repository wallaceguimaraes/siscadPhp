<?php
/**
 * Description of Usuario
 *
 */
class m_observacao{
   
    private $observacao_id;
    private $demanda_id;
    private $observacao;      
    private $data_cadastro;
    private $data_atualiza;
    


    function get__observacao__id() {
        return $this->observacao_id;
    }

    function set__observacao__id($observacao_id) {
        $this->observacao_id = $observacao_id;
    }


    function get__demanda__id() {
        return $this->demanda_id;
    }

    function set__demanda__id($demanda_id) {
        $this->demanda_id = $demanda_id;
    }


    function get__observacao() {
        return $this->observacao;
    }

    function set__observacao($observacao) {
        $this->observacao = $observacao;
    
    }


    function get__data__cadastro() {
        return $this->data_cadastro;
    }

    function set__data__cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    
    }


    function get__data__atualiza() {
        return $this->data_atualiza;
    }

    function set__data__atualiza($data_atualiza) {
        $this->data_atualiza = $data_atualiza;
    
    }

}

