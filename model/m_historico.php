<?php
/**
 * Description of Usuario
 *
 */
class m_historico{
   
    private $historico_id;
    private $pessoa_id;      
    private $usuario_id;
    private $demanda_id;
    private $observacao_id;
    private $acao;
    private $data;

    function get__historico__id() {
        return $this->historico_id;
    }

    function set__historico__id($historico_id) {
        $this->historico_id = $historico_id;
    }


    function get__pessoa__id(){
        return $this->pessoa_id;
    }

    function set__pessoa__id($pessoa_id){
        $this->pessoa_id = $pessoa_id;

    }


    function get__usuario__id(){
        return $this->usuario_id;
    }

    function set__usuario__id($usuario_id){
        $this->usuario_id = $usuario_id;

    }




    function get__demanda__id(){
        return $this->demanda_id;
    }

    function set__demanda__id($demanda_id){
        $this->demanda_id = $demanda_id;

    }



    function get__observacao__id(){
        return $this->observacao_id;
    }

    function set__observacao__id($observacao_id){
        $this->observacao_id = $observacao_id;

    }


    function get__acao(){
        return $this->acao_id;
    }

    function set__acao($acao_id){
        $this->acao_id = $acao_id;

    }
    

    function get__data(){
        return $this->data;
    }

    function set__data($data){
        $this->data = $data;

    }

}

