<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Modelos_marcas extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('modelos_marcas_model');
  }

  public function cadastro($data = "", $data2=""){
    $modelos = $this->modelos_marcas_model->listarModelos(); //listar todos os modelos, com marca, do banco
    $listar_marcas = $this->modelos_marcas_model->getByIdMarcas(); //retorna marcas para o select na view 
  	$modelos_marcas = $this->load->view('modelos_marcas/cadastro', array('data2' => $data2 , 'data' => $data , 'listar_marcas'=>$listar_marcas, 'modelos'=>$modelos), TRUE); //passando as variaveis via array para a view
  	$this->load->view('layout/index', array('layout' => $modelos_marcas ), FALSE);
  }

  public function testes($id){
    if ($this->modelos_marcas_model->testaExiste($id) === FALSE) {
      $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro, este tipo de modelo esta em uso, não é possível excluí-lo!'));
    } else {
      if ($this->modelos_marcas_model->excluir($id) === FALSE) {
        $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
      } else {
        $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
      }
    }
    redirect('frotas/modelos_marcas/cadastro');
  }

  public function editar($id) {
    # Atualizar dados 
    $data = $this->modelos_marcas_model->getById($id); //Pegando o Id modelo_veiculos
    $data2 = $this->modelos_marcas_model->getByIdMarcas($data->marca_veiculos_id); // Passando via array marca_veiculos_id e nome herdado reutilizando o metodo do Model
    $data2 = array(
      'id'=>$data2['0']->id, 
      'nome'=>$data2['0']->nome
    );
    $this->cadastro($data, $data2);
  }

  public function salvar(){
  if ($this->input->server('REQUEST_METHOD')  === 'POST') {
      $this->form_validation->set_rules('txtModelo', 'o campo não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('selMarca', 'o campo não foi selecionado', 'required');
      if ($this->form_validation->run() === FALSE) {
        $this->cadastro();
        } else {

        $data = array(
          'id' => $this->input->post('id'), 
          'marca_veiculos_id' => $this->input->post('selMarca'),
          'modelo' => $this->input->post('txtModelo')
        );

        if (empty($data['id'])) { //função para manipular variavel, responsavel por verificar a variavel esta vazia
          if ($this->modelos_marcas_model->cadastrar($data) == FALSE) { //chamando o metodo do Model
            $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
          }
        } else {
          if ($this->modelos_marcas_model->atualizar($data)) { //chamando o metodo do Model
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
          }
        }
      }
    }
    redirect('frotas/modelos_marcas/cadastro'); 
  }
}
