<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
  class Odometro extends MX_Controller {
	  
	function __construct() {
    	parent::__construct();
    	$this->load->model('odometro_model');	
  	}
	
	function index(){
		$this->cadastrar();
	}
	
	function cadastrar(){
		$listar_viaturas = $this->odometro_model->listarViaturas();
		
		$militar = $this->session->userdata('id_militar');

		//var_dump($listar_viaturas);
		$odometro = $this->load->view('odometro/cadastro_odometro', array('listar_viaturas'=>$listar_viaturas), TRUE);
		$this->load->view('layout/index', array('layout'=>$odometro), FALSE);
		
		if($this->input->server('REQUEST_METHOD')=='POST'){			
			$this->form_validation->set_rules('data', 'a data não foi preenchida corretamente', 'required');
			$this->form_validation->set_rules('selViatura', 'a viatura não foi preenchida corretamente', 'required');
			$this->form_validation->set_rules('inputOdometro', 'o odômetro não preenchido corretamente', 'required');
			$this->form_validation->set_rules('inputDestino', 'campo não preenchido corretamente', 'required');			  
		
			$valor=substr($this->input->post('selViatura'), 1);  

			$data = array(
				'militares_id'=>$militar,
				'data'=>$this->input->post('data'),
				'viaturas_id'=>str_replace($valor,"",$this->input->post('selViatura')),
				'odometro'=>$this->input->post('inputOdometro'),
				'destino'=>$this->input->post('inputDestino'),
				'alteracao'=>$this->input->post('inputAlteracao')
			);	

			
		if($militar==0){
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Sessao expirada!'));
		}else{	
		  	if($this->odometro_model->getLast($data) == TRUE){
			  if ($this->odometro_model->cadastro($data) == FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!Valor da data inválido.'));				
			  } else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
			  }
		  	} else {
			  $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! O odômetro deve ser maior ou igual ao da viatura.'));	
			  redirect('frotas/odometro/cadastrar');
		 	}	
		}		 
		  redirect('frotas/home');	
		}
	}
}