<?php
/**
 * Description of Usuario
 *
 */
class m_perfil_arquivo{
   
    private $perfil_id;
    private $arquivo_id;
    

    function get__perfil__id() {
        return $this->perfil_id;
    }

    function set__perfil__id($perfil_id) {
        $this->perfil_id = $perfil_id;
    }


    function get__arquivo_id() {
        return $this->arquivo_id;
    }

    function set__arquivo__id($arquivo_id) {
        $this->arquivo_id = $arquivo_id;
    
    }
    

}

