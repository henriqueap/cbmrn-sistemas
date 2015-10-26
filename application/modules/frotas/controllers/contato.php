<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Contato extends MX_Controller {

  function __construct() {
    parent::__construct();
    # $this->load->model('contato_model');
  }

  public function index()
  {
    $this->contato();
  } 

  public function contato(){
  	$contato = $this->load->view('sobre/contato', '', TRUE);
  	$this->load->view('layout/index', array('layout' => $contato ), FALSE);
  }
}