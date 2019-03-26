<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
* @version 1.0
* @author CBM-RN
* @link http://www.cbm.rn.gov.br/
**/
class Odometro extends MX_Controller {
		
	public function __construct() {
		parent::__construct();
		$_models = array(
			'abastecimento_model', 
			'frotas_model', 
			'listar_viaturas_model', 
			'odometro_model',
			'tipo_odometro_model',
			'viaturas_model'
		);
		$this->load->model($_models);
	}
	
	public function index() {
		$this->cadastro();
	}
	
	public function cadastro() {
		$listar_viaturas = $this->listar_viaturas_model->listar();
		$listar_tipos_odo = $this->tipo_odometro_model->listar();
		$militar = $this->session->userdata('id_militar');
		
		$_content = $this->load->view('odometro/cadastro_odometro', array('listar_viaturas'=>$listar_viaturas, 'listar_tipos_odo'=>$listar_tipos_odo->result()), TRUE);
		//var_dump($_content); die('Ver o que passa');
		$this->load->view('layout/index', array('layout'=>$_content), FALSE);

		//echo date('d/m/Y', strtotime('+1 day'));
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$data_viatura = explode('-', $this->input->post('selViatura')); 
			//var_dump($data_viatura[0]); die('Dat_Vtr');

			$this->form_validation->set_rules('inputData', 'a data não foi preenchida corretamente', 'required');
			$this->form_validation->set_rules('selViatura', 'a viatura não foi preenchida corretamente', 'required');
			$this->form_validation->set_rules('inputOdometro', 'o odômetro não preenchido corretamente', 'required');
			$this->form_validation->set_rules('inputDestino', 'campo não preenchido corretamente', 'required');

			// valida se a vtr existe
			if (! $this->viaturas_model->getViatura($data_viatura[0])) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Viatura inválida!'));
				redirect('frotas/odometro/cadastrar');
			}

			$last_action= $this->odometro_model->getLastAction($data_viatura[0]);
			#var_dump($last_action); die('Lst_Act');
			
			/* if (! $last_action) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Viatura inválida!'));
				redirect('frotas/odometro/cadastrar');
			} 
			else {
				if ($last_action->id_tipo % 2 != 0) {
					switch ($last_action->id_tipo) {
						case 1:
							$id_tipo_saida = 2;
						break;
					case 3:
						$id_tipo_saida = 4;
						break;
					case 5:
						$id_tipo_saida = 6;
						break;
					}
				}
				else {
					$id_tipo_saida = ($this->viaturas_model->getViatura($data_viatura[0])->tipo_viaturas_id == 1)? 1: 3;
				}
			} */
			
			#var_dump($id_tipo_saida); die();
			
			$data = array(
				'militares_id'=>$militar,
				'data'=>$this->frotas_model->formataData($this->input->post('inputData')),
				#'viaturas_id'=>str_replace($valor,"",$this->input->post('selViatura')),
				'viaturas_id'=>$data_viatura[0],
				'odometro'=>$this->input->post('inputOdometro'),
				#'destino'=> ($last_action->id_tipo % 2 == 0)? $last_action->destino: $this->input->post('inputDestino'),
				'destino'=> (!$this->input->post('inputDestino'))? $this->input->post('hiddenDestino'): $this->input->post('inputDestino'),
				#'id_tipo'=> $id_tipo_saida,
				'tipo'=> (!$this->input->post('selTipoOdo'))? $this->input->post('hiddenTipoOdo'): $this->input->post('selTipoOdo'), 
				'alteracao'=>$this->input->post('inputAlteracao')
			);	
			#var_dump($data); die();
			
			if($militar == 0){
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Sessao expirada!'));
			}
			else {	
				if ($this->odometro_model->getLast($data) == TRUE) {
					if ($this->odometro_model->cadastrar($data) == FALSE) {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! Valor da data inválido.'));				
					} 
					else {
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
					}
				} 
				else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! O odômetro deve ser maior ou igual ao da viatura.'));	
					redirect('frotas/odometro/cadastrar');
				}		
			}		 
			redirect('frotas/home');	
		}
	}

	public function getUltimoDestino() {
		$_id = $this->input->get('id');
		$info = $this->odometro_model->getLastAction($_id);
		//var_dump($info->destino);
		if (!($info) || ($info->id_tipo > 6) || ($info->id_tipo % 2 == 0)) return false; 
		else echo $info->destino;
	}

	public function getInfoDestino() {
		$_id = $this->input->get('id');
		$_info = $this->odometro_model->getLastAction($_id);
		$_listar_tipos_odo = $this->tipo_odometro_model->listar()->result();
		//var_dump($_info);
		//var_dump($listar_tipos_odo);
		//$_content = $this->load->view('frotas/odometro/ajax_odometro');
		$_data = array('info_odo'=>$_info, 'listar_tipos_odo'=>$_listar_tipos_odo);
		$_content = $this->load->view('odometro/ajax_odometro', $_data, true);
		echo $_content;
	}
	
	public function getMaxOdometro() {
		$_id = $this->input->get('id');
		$_info = $this->odometro_model->getLastAction($_id, true);
		echo (! $_info)? 'Sem odômetro cadastrado': $_info->odometro;
	}
}