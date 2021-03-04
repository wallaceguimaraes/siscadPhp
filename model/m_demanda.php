<?php
/**
 * Description of Usuario
 *
 */
class m_demanda{
   
    private $demanda_id;
    private $pessoa_id;
    private $demanda;      
    private $data;
    private $status;
    private $ativo;


    function get__demanda__id() {
        return $this->demanda_id;
    }

    function set__demanda__id($demanda_id) {
        $this->demanda_id = $demanda_id;
    }


    function get__pessoa__id() {
        return $this->pessoa_id;
    }

    function set__pessoa__id($pessoa_id) {
        $this->pessoa_id = $pessoa_id;
    }


    function get__demanda() {
        return $this->demanda;
    }

    function set__demanda($demanda) {
        $this->demanda = $demanda;
    
    }


    function get__data() {
        return $this->data;
    }

    function set__data($data) {
        $this->data = $data;
    
    }


    function get__status() {
        return $this->status;
    }

    function set__status($status) {
        $this->status = $status;
    
    }



    function get__ativo(){
        return $this->ativo;
    }

    function set__ativo($ativo){
        $this->ativo = strtoupper($ativo);

    }

}

