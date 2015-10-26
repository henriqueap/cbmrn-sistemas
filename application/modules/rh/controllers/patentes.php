<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Patentes extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('patentes_model');
        # $this->output->enable_profiler(TRUE);
    }

    public function index() {
        $this->consulta();
    }

    public function salvar() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('nome', 'Patente', 'required|max_length[80]');
            $this->form_validation->set_rules('sigla', 'Sigla da Patente', 'required|max_length[10]');

            if ($this->form_validation->run() === FALSE) {
                $this->cadastro();
            } else {
                $data = array('id' => $this->input->post('id'), 'nome' => $this->input->post('nome'), 'sigla' => $this->input->post('sigla'));

                if (empty($data['id'])) {
                    if ($this->patentes_model->salvar($data)) {
                        $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
                    } else {
                        $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao cadastrar!'));
                    }
                } else {
                    if ($this->patentes_model->atualizar($data)) {
                        $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
                    } else {
                        $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
                    }
                }
                
                # Redireciona caso tudo tenho sido concluído!
                redirect('rh/patentes/');
            }
        }
    }

    public function cadastro($data = "") {
        # Method responsável pelo cadastro.
        $conteudo = $this->load->view('patentes/cadastro', array('data' => $data), TRUE);
        $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
    }

    public function editar($id) {
        # Method lógico resposável pelo a atulização.
        $data = $this->patentes_model->getById($id);
        $this->cadastro($data);
    }

    public function consulta() {
        # Consultar patentes.
        $patente = $this->patentes_model->listPatentes();
        $conteudo = $this->load->view('patentes/resultado_consulta', array('patentes' => $patente), TRUE);
        $this->load->view('layout/index', array('layout' => $conteudo), FALSE);
    }

    public function excluir($id) {
        # Excluír dados.
        $this->patentes_model->excluir($id);
        redirect('rh/patentes/');
    }
}