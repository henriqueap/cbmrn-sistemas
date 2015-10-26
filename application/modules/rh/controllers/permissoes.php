<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Permissoes extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('permissoes_model');
        # $this->output->enable_profiler(TRUE);
    }

    public function index() {
        $this->consulta();
    }

    public function cadastro($data = "") {
        $conteudo = $this->load->view('rh/permissoes/cadastro', array('data' => $data), TRUE);
        $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
    }

    public function consulta() {
        $conteudo = $this->load->view('rh/permissoes/consulta', '', TRUE);
        $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
    }

    public function salvar() {
        // 
    }

    public function excluir() {
        //
    }

    public function editar() {
        // 
    }

}