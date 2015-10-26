<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Abastecimento extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('abastecimento_model');
  }

  public function cadastro(){

    $listar_viaturas = $this->abastecimento_model->getListarViaturas(); // listar viaturas PLACA - MARCA - MODELO
    $setor_lotacao = $this->abastecimento_model->getByIdSetor(); // listar setores/lotações 
  	$abastecimento = $this->load->view('abastecimento/cadastro', array('listar_viaturas'=>$listar_viaturas, 'setor_lotacao'=>$setor_lotacao) , TRUE);
  	$this->load->view('layout/index', array('layout' => $abastecimento ), FALSE);
  }

  public function salvar(){
   
    if($this->input->server('REQUEST_METHOD') === 'POST'){

      $militar=$this->session->userdata('id_militar');
      //$militar=0;

      $this->form_validation->set_rules('selSetor', 'campo setor não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('selViatura', 'campo viatura não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtOdometro', 'campo  odometro não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('txtCombustivel', 'campo combustível não foi preenchido corretamente', 'required');
    
    if($militar==0){
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Sessao expirada!'));
    }else{
      if ($this->form_validation->run() === FALSE) {
          $this->cadastro();
      } else {
        $data2 = array(
          'data' => $this->input->post('data'),
          'odometro' => $this->input->post('txtOdometro'),
          'militares_id' => $militar,
          'viaturas_id' => $this->input->post('selViatura')
        );

        $var2 = $this->abastecimento_model->cadastrarOdometro($data2);

        if($var2 != false){
          $data = array(
            'viaturas_id' => $this->input->post('selViatura'),
            'data'=>$this->input->post('data'),
            'odometros_id'=>$var2,
            'lotacoes_id' => $this->input->post('selSetor'),
            'litros' => $this->input->post('txtCombustivel')
          );
          $var = $this->abastecimento_model->cadastrar($data);
        }

        if ($var == FALSE) {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!Valor da data inválido.'));
        }  else {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
        }
      }
    }
      redirect('frotas/home');
    }
  }
}