<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Tipo_usuario extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('tipo_usuario_model');
  }

  public function cadastro(){
  	$tipo_usuario = $this->load->view('tipo_usuario/cadastro', '' , TRUE);
  	$this->load->view('layout/index', array('layout' => $tipo_usuario ), FALSE);
  }
}