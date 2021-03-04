<?php
/**
 * Description of Usuario
 *
 */
class m_pessoa{
   
    private $pessoa_id;
    private $categoria_id;
    private $nome;
    private $apelido;
    private $dt_nasc;
    private $dt_cadastro;
    private $dt_atualiza;
    private $cpf;
    private $como_chega;
    private $nome_mae;
    private $rg;
    private $dt_exp;
    private $nis_pis;
    private $sus;
    private $titulo;
    private $endereco;
    private $complemento;
    private $municipio;
    private $estado;
    private $cep;
    private $tel1;
    private $tel2;
    private $tel_fixo;
    private $foto;
    private $ativo;


    function get__pessoa__id() {
        return $this->pessoa_id;
    }

    function set__pessoa__id($pessoa_id) {
        $this->pessoa_id = $pessoa_id;
    }

    function get__categoria__id() {
        return $this->categoria_id;
    }

    function set__categoria__id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }


    function get__nome() {
        return $this->nome;
    }

    function set__nome($nome) {
        $this->nome = $nome;
    
    }
    function get__apelido() {
        return $this->apelido;
    }

    function set__apelido($apelido) {
        $this->apelido = $apelido;
    
    }



    function get__dt__nasc() {
        return $this->dt_nasc;
    }

    function set__dt__nasc($dt_nasc) {
        $this->dt_nasc = $dt_nasc;
    
    }

    function get__dt__cadastro() {
        return $this->dt_cadastro;
    }

    function set__dt__cadastro($dt_cadastro) {
        $this->dt_cadastro = $dt_cadastro;
    
    }



    function get__dt__atualiza() {
        return $this->dt_atualiza;
    }

    function set__dt__atualiza($dt_atualiza) {
        $this->dt_atualiza = $dt_atualiza;
    
    }


    function get__cpf() {
        return $this->cpf;
    }

    function set__cpf($cpf) {
        $this->cpf = $cpf;
    
    }



    function get__como__chega() {
        return $this->como_chega;
    }

    function set__como__chega($como_chega) {
        $this->como_chega = $como_chega;
    
    }


    function get__nome__mae() {
        return $this->nome_mae;
    }

    function set__nome__mae($nome_mae) {
        $this->nome_mae = $nome_mae;
    
    }


    function get__rg() {
        return $this->rg;
    }

    function set__rg($rg) {
        $this->rg = $rg;
    
    }


    function get__dt__exp() {
        return $this->dt_exp;
    }

    function set__dt__exp($dt_exp) {
        $this->dt_exp = $dt_exp;
    
    }


    function get__nis__pis() {
        return $this->nis_pis;
    }

    function set__nis__pis($nis_pis) {
        $this->nis_pis = $nis_pis;
    
    }


    function get__sus() {
        return $this->sus;
    }

    function set__sus($sus) {
        $this->sus = $sus;
    
    }


    function get__titulo() {
        return $this->titulo;
    }

    function set__titulo($titulo) {
        $this->titulo = $titulo;
    
    }

    function get__endereco() {
        return $this->endereco;
    }

    function set__endereco($endereco) {
        $this->endereco = $endereco;
    
    }

    function get__complemento() {
        return $this->complemento;
    }

    function set__complemento($complemento) {
        $this->complemento = $complemento;
    
    }


    function get__municipio() {
        return $this->municipio;
    }

    function set__municipio($municipio) {
        $this->municipio = $municipio;
    
    }

    function get__estado() {
        return $this->estado;
    }

    function set__estado($estado) {
        $this->estado = $estado;
    
    }


    function get__cep() {
        return $this->cep;
    }

    function set__cep($cep) {
        $this->cep = $cep;
    
    }


    function get__tel__1() {
        return $this->tel_1;
    }

    function set__tel__1($tel_1) {
        $this->tel_1 = $tel_1;
    
    }


    function get__tel__2() {
        return $this->tel_2;
    }

    function set__tel__2($tel_2) {
        $this->tel_2= $tel_2;
    
    }


    function get__tel__fixo() {
        return $this->tel_fixo;
    }

    function set__tel__fixo($tel_fixo) {
        $this->tel_fixo = $tel_fixo;
    
    }

    function get__foto() {
        return $this->foto;
    }

    function set__foto($foto) {
        $this->foto = $foto;
    
    }

    function get__ativo(){
        return $this->ativo;
    }

    function set__ativo($ativo){
        $this->ativo = strtoupper($ativo);

    }

}

