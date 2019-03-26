<?php
if (!defined('BASEPATH'))
		exit('No direct script access allowed'); 
 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Tipo_odometro extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('tipo_odometro_model');
	}

	public function index() {
		$this->consulta();
	}

	public function cadastro($data = ""){ //atribuindo nenhum valor a variavel $data (sera util na view para receber um id)
		# Consultar tipos de odômetro.
		$tipos_odometro = $this->tipo_odometro_model->listar(); //listar marcas no select 
		$conteudo = $this->load->view('tipo_odometro/cadastro', array('data' => $data , 'tipos' => $tipos_odometro), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function testes($id) {
		if ($this->tipo_odometro_model->testaExiste($id) === FALSE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro, este tipo de odômetro está em uso, não é possível excluí-lo!')); 
		} else {  
			if ($this->tipo_odometro_model->excluir($id) === FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
			} else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!' ));
			}
		}    
		redirect('frotas/tipo_odometro/cadastro');
	}

	public function editar($id) {
		# Atualizar dados
		$data = $this->tipo_odometro_model->getById($id);
		$this->cadastro($data);
	}

	public function salvar() {
		if ($this->input->server('REQUEST_METHOD')  === 'POST') {
			$this->form_validation->set_rules('txtTipoOdo', 'o campo não foi preenchido corretamente', 'required');

			if ($this->form_validation->run() === FALSE) {
				$this->cadastro();
				} else {
				$data = array(
					'tipos_odometros_id' => $this->input->post('id'),
					'tipo_odometro' => $this->input->post('txtTipoOdo'),
				); 
			}
			
			#Tratamento de excessões para Cadastrar e Atualizar 
			if (empty($data['tipos_odometros_id'])) {
					if ($this->tipo_odometro_model->cadastrar($data) == FALSE) {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
					} else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
					}
				} else {
					if ($this->tipo_odometro_model->atualizar($data)) {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
					} else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
					}
				}
			}
		redirect('frotas/tipo_odometro/cadastro'); 
	}
	
}