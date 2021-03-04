<?php
/**
 * Description of Usuario
 *
 */
class m_relatorioDemanda{
   
    private $pessoa;
    private $data;      
    private $status;


    function get__pessoa() {
        return $this->pessoa;
    }

    function set__pessoa($pessoa) {
        $this->pessoa = $pessoa;
    }


    function get__data() {
        return $this->data;
    }

    function set__data($data) {
        $this->data = $data;
    
    }

    function get__status(){
        return $this->status;
    }

    function set__status($status){
        $this->status = strtoupper($status);

    }

}

