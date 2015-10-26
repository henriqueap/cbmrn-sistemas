<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Os extends MX_Controller {

	public $path="clog/os/"; 

	function __construct() {
		parent::__construct();
		$this->load->model(array('acesso_model', 'clog_model', 'militares_model', 'os_model'));
		# $this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$militares = $this->os_model->getMilitares()->result();
		$os = $this->load->view('os/cadastro', array('militares'=>$militares), TRUE);
		$this->load->view('layout/index', array('layout'=>$os), FALSE);		 
	}

	public function equipe() {
		#var_dump($session);
		$metodo= $this->path.__FUNCTION__;
		#var_dump($metodo);
		#$teste=$this->acesso_model->getPermissao($metodo, 10);
		#if ($teste===TRUE) {
			$militares = $this->os_model->getMilitares()->result();
			$setores = $this->os_model->getLotacoes()->result();
			$equipe = $this->load->view('os/cadastro_equipe', array('setores'=>$setores, 'militares'=>$militares), TRUE);
			$this->load->view('layout/index', array('layout'=>$equipe), FALSE);
		#}
		#else {
		#  $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Sem Acesso!'));
		#  redirect('clog/os/index');
		#} 
	}

	/*public function ordem_servico() {
		$id = $this->input->get('id');
		$os = $this->os_model->getOS($id)->result();
		$idsolicitante = $os->solicitante_militares_id;
		$idresponsavel = $os->equipe_militares_id;
		$solicitante = $this->os_model->getMilitar($idsolicitante);
		$responsavel = $this->os_model->getMilitar($idresponsavel);
		$data = array(
							'os_id'=>$os->id,
							'solicitante'=>$solicitante,
							'data_solicitacao'=>$os->data_solicitacao,
							'descricao'=>$os->descricao,
							'responsavel'=>$responsavel
						);
		$dataOS = $this->load->view('os/ordem_servico', $data, TRUE);
		$this->load->view('layout/index', array('layout'=>$dataOS), FALSE);    
	}*/

	public function ordem_servico() {
		$id = $this->input->get('id');
		$os = $this->os_model->getOS($id)->row();
		if (! is_bool($os)) {
			$status = $this->os_model->getStatusOS($id);
			#var_dump($status);
			$data = array('os'=>$os, 'status'=>$status);
			$dataOS = $this->load->view('os/ordem_servico', $data, TRUE);
			#$os = $this->load->view('os/ordem_servico', '', TRUE);
			$this->load->view('layout/index', array('layout'=>$dataOS), FALSE);
		} 
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao carregar os dados da OS!'));
			#redirect('index');
		}  
	}

	public function listar() {
		#Dados para auditoria
		$data = array(
							'auditoria'=>'Consultou lista de ordens de serviço',
							'idmilitar'=>10, #Checar quem está acessando e permissões
							'idmodulo'=>3
						);
		if ($this->os_model->audita($data, 'consultar') === TRUE) {
			if ($this->os_model->getOS() === FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível listar OS!'));
				$listarOS = $this->load->view('os/listar', '', TRUE);
			}
			else {
				$os = $this->os_model->getOS()->result();
				$listarOS = $this->load->view('os/listar', array('listarOS'=>$os), TRUE);
			}
			$this->load->view('layout/index', array('layout'=>$listarOS), FALSE);
		}
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro crítico no sistema!'));
			redirect('clog/os/index');
		}
	}
	
	public function listar_equipe() {
		# Tratando setores
		$setores = $this->os_model->getLotacoes();
		if ($setores !== FALSE) $setores = $setores->result();
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível listar os setores!'));
			redirect('clog/os/index');
		}
		# Tratando o POST
			if ($this->input->post('lotacoes_id') == 0 || $this->input->post('lotacoes_id') === FALSE) $id = NULL;
			else $id = $this->input->post('lotacoes_id');
		# Dados para auditoria
		$data = array(
							'auditoria'=>'Consultou lista de equipes',
							'idmilitar'=>10, #Checar quem está acessando
							'idmodulo'=>3
						);
		if ($this->os_model->audita($data, 'consultar') === TRUE) {
			if (!(is_null($id))) {
				$equipe = $this->os_model->getEquipe($id);
				$listarEquipe = $this->load->view('os/listar_equipes', array('setores'=>$setores, 'equipe'=>$equipe), TRUE);
			}
			else {					
				$listarEquipe = $this->load->view('os/listar_equipes', array('setores'=>$setores), TRUE);
			}
			# Carregando a página
			$this->load->view('layout/index', array('layout'=>$listarEquipe), FALSE);
		}
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro crítico no sistema!'));
			redirect('clog/os/index');
		}
	}

	public function mostarLotacao() {
		$id = $this->input->get('id');
		$mostraLotacao = $this->os_model->getLotacao($id);
		echo $mostraLotacao;
	}

	public function novaOS() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/*if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
			} 
			else
			{
				echo "<script>alert('Deu erro');</script>";
				redirect('clog/os/index');
			}*/
			$data = array(
								'solicitante_militares_id'=>$this->input->post('idsolicitante'), 
								'data_solicitacao'=>implode('-',array_reverse(explode('/',$this->input->post('data_solicitacao')))),
								'data_inicio'=>implode('-',array_reverse(explode('/',$this->input->post('data_solicitacao')))),
								'descricao'=>$this->input->post('descricao')
							);
			#var_dump($data); die();
			$query = $this->os_model->inserir($data, 'os');
			if ($query === TRUE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Nova OS cadastrada com sucesso!'));
				redirect('clog/os/index');
			}
			else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar a OS!'));
				redirect('clog/os/index');
			}
		} 
		else redirect('clog/os/index'); # Caso não tenha sido enviado nenhum POST.
	}

	public function novaEquipe() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			/*if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
			} 
			else
			{
				echo "<script>alert('Deu erro');</script>";
				redirect('clog/os/index');
			}*/

			$data = array(
					'militares_id'=>$this->input->post('militares_id'), 
					'lotacoes_id'=>$this->input->post('lotacoes_id')
			);
			#var_dump($data); die();
			$teste = $this->os_model->exists($data, 'equipe_os');
			#var_dump($teste); die();
			if($teste === FALSE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar! Este militar já faz parte da equipe do setor!'));
				redirect('clog/os/equipe');
			}
			else {
				$query = $this->os_model->inserir($data, 'equipe_os');
				if ($query === TRUE) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
					redirect('clog/os/equipe');
				}
				else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
					redirect('clog/os/equipe');
				}
			}
		} 
		else redirect('clog/os/index'); # Caso não tenha sido enviado nenhum POST.
	}

	public function cancelarOS() {
		$id = $this->input->get('id');
		$query = $this->os_model->cancela($id, 'os');
		if ($query === TRUE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Ordem de serviço cancelada com sucesso!'));
			#redirect('clog/os/index');
		}
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível cancelar a OS!'));
			#redirect('clog/os/index');
		}
		redirect('clog/os/index');
	}

	public function concluirOS() {
		$data = array(
							'os_id'=>$this->input->post('os_id'), 
							'observacao'=>$this->input->post('observacao')
						);
		$query = $this->os_model->conclui($data, 'os');
		if ($query === TRUE) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Ordem de serviço concluída com sucesso!'));
			#redirect('clog/os/index');
		}
		else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível concluir a OS!'));
			#redirect('clog/os/index');
		}
		redirect('clog/os/index');
	}

	public function retiraMembro() {
		$id = $this->input->get('id');
		#var_dump($id); die();
		if ($id !== FALSE) {
			$query = $this->clog_model->excluir('equipe_os', $id);
			var_dump($query); die();
			if ($query === TRUE) {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Membro retirado da equipe com sucesso!'));
				redirect('clog/os/listar_equipe');
			}
			else {
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Não foi possível retirar o membro desta equipe!'));
				redirect('clog/os/listar_equipe');
			}
		}
		else redirect('clog/os/index');
	}	
}