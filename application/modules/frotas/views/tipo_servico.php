<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Tipo_servico extends MX_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model('tipo_servico_model');
  }
  
  public function cadastro($data = ""){
    $servicos = $this->tipo_servico_model->listarServicos();
  	$tipo_servico = $this->load->view('tipo_servico/cadastro', array('data' => $data , 'listaservico' => $servicos), TRUE); // array ( 'chave' + $valor ... que na view sera interpretado no foreach como $variavel as e o valor dela)
  	$this->load->view('layout/index', array('layout'=>$tipo_servico), FALSE);
  }

  public function editar($id) {
    $data = $this->tipo_servico_model->getById($id);
    $this->cadastro($data);
  }

  public function testes($id) {
    if ($this->tipo_servico_model->testaExiste($id) === FALSE) {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro, este tipo de serviço esta em uso, não é possível excluí-lo!'));
    } else {
      if ($this->tipo_servico_model->excluir($id) == FALSE) {
        $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
      } else {
        $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
      }
    }
    redirect('frotas/tipo_servico/cadastro');
  }

  public function cadastrar(){
    if ($this->input->server('REQUEST_METHOD') === 'POST'){
      $this->form_validation->set_rules('txtTipoServico', 'o campo não foi preenchido corretamente', 'required');
      if($this->form_validation->run() === FALSE) {
        $this->cadastro();
      } else {
        $data = array (
          'id' => $this->input->post('id'),
          'nome' => $this->input->post('txtTipoServico')
        );
      }

      #Tratar excessões 
      if(empty($data['id'])) {
        if ($this->tipo_servico_model->salvar($data) == FALSE) {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
        } else {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
        }
      } else {
        if ($this->tipo_servico_model->atualizar($data)) {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
        } else {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
        }
      }
      redirect('frotas/tipo_servico/cadastro'); 
    }
  }
}
