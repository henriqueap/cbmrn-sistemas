<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('welcome_model');
  }

  public function index() {
    $welcome = $this->load->view('welcome/index', '', TRUE);
    $this->load->view('layout/index', array('layout' => $welcome), FALSE);
  }
}

