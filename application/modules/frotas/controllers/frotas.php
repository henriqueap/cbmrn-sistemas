<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
 class Frotas extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('frotas_model');
  }

  public function index() {
    redirect('frotas/home');
  }


}

