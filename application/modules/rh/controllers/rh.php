<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Rh extends MX_Controller {

  function __construct() {
    parent::__construct();
    date_default_timezone_set('America/Recife');
    $this->load->model('rh_model');
    $this->load->helper(array('cbmrn', 'file'));
    # $this->output->enable_profiler(TRUE);
  }

  public function index() {
    $welcome = $this->load->view('welcome/index', '', TRUE);
    $this->load->view('layout/index', array('layout' => $welcome), FALSE);
  }

  public function pdf() {
    
  }
}
