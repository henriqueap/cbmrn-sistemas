<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed'); 
 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Marcas_veiculos extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('marcas_veiculos_model');
  }

  public function index() {
    $this->consulta();
  }

  public function cadastro($data = ""){ //atribuindo nenhum valor a variavel $data (sera util na view para receber um id)
    # Consultar marcas.
  	$marcas = $this->marcas_veiculos_model->listaMarcas(); //listar marcas no select 
    $conteudo = $this->load->view('marcas_veiculos/cadastro', array('data' => $data , 'marcas_veiculos' => $marcas), TRUE);
    $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
  }

  public function testes($id) {
    if ($this->marcas_veiculos_model->testaExiste($id) === FALSE) {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro, este tipo de marca esta em uso, não é possível excluí-lo!')); 
    } else {  
      if ($this->marcas_veiculos_model->excluir($id) === FALSE) {
        $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
      } else {
        $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!' ));
      }
    }    
    redirect('frotas/marcas_veiculos/cadastro');
  }

  public function editar($id) {
    # Atualizar dados
    $data = $this->marcas_veiculos_model->getById($id);
    $this->cadastro($data);
  }

  public function salvar(){
  if ($this->input->server('REQUEST_METHOD')  === 'POST') {
    $this->form_validation->set_rules('txtMarcas', 'o campo não foi preenchido corretamente', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->cadastro();
      } else {
      $data = array(
        'id' => $this->input->post('id'),
        'nome' => $this->input->post('txtMarcas'),
      ); 
    }
    
    #Tratamento de excessões para Cadastrar e Atualizar 
    if (empty($data['id'])) {
        if ($this->marcas_veiculos_model->cadastrar($data) == FALSE) {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
        } else {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
        }
      } else {
        if ($this->marcas_veiculos_model->atualizar($data)) {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
        } else {
          $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
        }
      }
    }
    redirect('frotas/marcas_veiculos/cadastro'); 
  }
}