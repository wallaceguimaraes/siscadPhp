<?php
/**
 * Description of Usuario
 *
 */
class m_categoria{
   
    private $categoria_id;
    private $categoria;      
    private $ativo;


    function get__categoria__id() {
        return $this->categoria_id;
    }

    function set__categoria__id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }


    function get__categoria() {
        return $this->categoria;
    }

    function set__categoria($categoria) {
        $this->categoria = $categoria;
    
    }

    function get__ativo(){
        return $this->ativo;
    }

    function set__ativo($ativo){
        $this->ativo = strtoupper($ativo);

    }

}

