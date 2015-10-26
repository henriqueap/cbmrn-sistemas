<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Usuario extends MX_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('usuario_model');
  }

  public function cadastro(){
    $tipos_usuarios = $this->usuario_model->listarTiposUsuarios(); //Listar Todos os tipo de usuarios
    $listar_militares = $this->usuario_model->listarMilitares(); // Listar todos os militares
  	$usuario = $this->load->view('usuario/cadastro', array('tipos_usuarios' => $tipos_usuarios, 'listar_militares' => $listar_militares) , TRUE);
  	$this->load->view('layout/index', array('layout' => $usuario ), FALSE);
  }

  public function salvar(){
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
      $this->form_validation->set_rules('senha1', 'O campo não foi preenchido corretamente', 'required');
      $this->form_validation->set_rules('senha2', 'O campo não foi preenchido corretamente', 'required');
          
      $data = array(
        'militares_id'=>$this->input->post('selMilitar'), 
        'tipo_usuario_id'=>$this->input->post('selTipo'),
        'senha'=>$this->input->post('senha1'),
        'senha'=> $this->input->post('senha2')
      );

      if ($this->input->post('senha1') != $this->input->post('senha2')) {
        $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro, as senhas não conferem'));
      } else {
        if(empty($data['id'])) {
          if ($this->usuario_model->salvar($data) == FALSE) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso'));
          }
        } 
      }
    } // FECHA IF POST
    redirect('frotas/usuario/cadastro');
  } // FECHA O METODO SALVAR
}    