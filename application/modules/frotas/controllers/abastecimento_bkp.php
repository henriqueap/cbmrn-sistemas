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
		/*$_models = array(
			'abastecimento_model', 
			'frotas_model', 
			'listar_viaturas_model', 
			'odometro_model',
			'viaturas_model'
		);*/
		$this->load->model('listar_viaturas_model');
		$this->load->model('viaturas_model');
		$this->load->model('odometro_model');
		//$this->load->model($_models);
	}

	public function cadastro() {
		//$listar_viaturas = $this->listar_viaturas_model->listar();
		//$setor_lotacao = $this->frotas_model->getLotacoes();
		$abastecimento = $this->load->view(
			'abastecimento/cadastro', 
			array(), //'listar_viaturas'=>$listar_viaturas, 'setor_lotacao'=>$setor_lotacao), 
			TRUE
		);
		$this->load->view('layout/index', array('layout' => $abastecimento ), FALSE);
	}

/*	public function salvar() {
		// Testando se tem POST
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$militar=$this->session->userdata('id_militar');
			//$militar=0;
			$this->form_validation->set_rules('inputData', 'a data não foi preenchida corretamente', 'required');
			$this->form_validation->set_rules('selSetor', 'campo setor não foi preenchido corretamente', 'required');
			$this->form_validation->set_rules('selViatura', 'campo viatura não foi preenchido corretamente', 'required');
			$this->form_validation->set_rules('txtOdometro', 'campo  odometro não foi preenchido corretamente', 'required');
			$this->form_validation->set_rules('txtCombustivel', 'campo combustível não foi preenchido corretamente', 'required');
			
			// Testando sessão
			if ($militar == 0) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Sessao expirada!'));
			}
			// Executando os cadastros
			else {
				if ($this->form_validation->run() === FALSE) $this->cadastro(); 
				else {
					// Montando um array com os dados do form
					$data_odo = array(
						'data'=>$this->frotas_model->formataData($this->input->post('inputData')),
						'odometro' => $this->input->post('txtOdometro'),
						'destino' => "Abastecer a viatura",
						'tipo' => 7,
						'militares_id' => $militar,
						'viaturas_id' => $this->input->post('selViatura')
					);

					//var_dump($data_odo); die();

					// Tratando erro de odômetro maior que o último
					if (! $this->odometro_model->validaOdometro($data_odo)) {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Odômetro menor que o último cadastrado!'));
					}
					// Criando novo odômetro e testando para criar o novo abastecimento
					else {
						// Criando novo odômetro, testando e pegando o id do odômetro
						$novo_odometro_id = $this->odometro_model->cadastrar($data_odo, TRUE);
						if ($novo_odometro_id != false) {
							// Montando o array para cadastrar novo abastecimento
							$data = array(
								'viaturas_id' => $data_odo['viaturas_id'],
								'data' => $data_odo['data'],
								'odometros_id' => $novo_odometro_id,
								'lotacoes_id' => $this->input->post('selSetor'),
								'litros' => $this->input->post('txtCombustivel')
							);
							// Criando novo abastecimento	usando os dados do array e gera feedback
							$novo_abastecimento = $this->abastecimento_model->cadastrar($data);
							if ($novo_abastecimento == FALSE) {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! Valor da data inválido.'));
							}
							else {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
							}
						}
					}
				}
			}
			redirect('frotas/home');
		}
	}

	public function loadVtrSetor() {
		$_id = $this->input->get('id');
		if (! is_null($_id)) {
			$_viaturas = ($_id == "0")? $this->listar_viaturas_model->listar(): $this->listar_viaturas_model->listarPorSetor($_id);
			$_tag =	"<select class=\"form-control input-sm\" id=\"selViatura\" name=\"selViatura\">\n	<option value=0 selected>Placa - Marca Modelo</option>\n";
			if (! is_bool($_viaturas)) {
				foreach ($_viaturas->result() as $_viatura) {
					$_tag .=	"	<option value = $_viatura->id>$_viatura->placa - $_viatura->marca $_viatura->modelo</option>\n";
				}
			}
			$_tag .= "</select>";
			echo $_tag;
		} 
		else return FALSE;
	}
*/
}