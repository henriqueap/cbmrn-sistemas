<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Home extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('home_model');
  }
  function index(){
    $lista_revisao = $this->home_model->revisao();
    //var_dump($lista_revisao);
    $lista_oleo = $this->home_model->oleo();
     //var_dump($lista_oleo);
    $lista_pendentes = $this->home_model->pendentes();
		$home=$this->load->view('welcome/index', array('lista_revisao'=>$lista_revisao,'lista_oleo'=>$lista_oleo,'lista_pendentes'=>$lista_pendentes), TRUE);
		$this->load->view('layout/index', array('layout'=>$home), FALSE);	 
	}
}