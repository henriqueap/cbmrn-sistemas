<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Marcas extends MX_Controller  {
	
	function __construct() {
		parent::__construct();
		$this->load->model('clog_model');
    $this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		# Index
		$this->cadastro();
	}

	public function cadastro($data="") {
		# Listar marcas.
		# Bloco de auditoria
			/*$auditoria = array(
								'auditoria'=>'Listou as marcas de produtos',
								'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo'=>$this->session->userdata['sistema']
							);
			$this->clog_model->audita($auditoria, 'consultar');*/
		# .Bloco de auditoria
		$lista = $this->clog_model->listar('marcas_produtos')->result(); # Adicionar result para listar todos.
		# Carregar views.
		$marcas = $this->load->view('marcas/index', array('lista'=>$lista, 'data'=>$data), TRUE);
		$this->load->view('layout/index', array('layout'=>$marcas), FALSE);
	}

	public function editar($id) {
		# Editar
		$data = $this->clog_model->listar('marcas_produtos', $id)->row();
		$this->cadastro($data);
	}

	public function excluir($id) {
		# Excluir
		$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Excluído com sucesso!'));
		$exclusao = $this->clog_model->excluir('marcas_produtos', $id);
		$info_marca = $this->clog_model->getByID('marcas_produtos', $id)->row();
		if (! $exclusao) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Tentativa de excluir a marca de produtos('.$info_marca['marca'].') de ID n° '.$id.', no sistema',
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro. requisição não concluída!'));
		}
		else {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>'Excluiu a marca de produtos('.$info_marca['marca'].') de ID n° '.$id.', no sistema',
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Excluído com sucesso!'));
		}
		redirect('clog/marcas/index');
	}

	public function salvar() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules('marca', 'marca', 'trim|required|min_length[1]|max_length[45]|xss_clean');

			if ($this->form_validation->run() == TRUE) {
				# Pegar array com os dados do method post.
				$array_post = array(
					'id'=>$this->input->post('id'), 
					'marca'=>$this->input->post('marca')
				);

				if (empty($array_post['id'])) {
					# Salvar caso não exista $id.
					$marcas = $this->clog_model->salvar('marcas_produtos', $array_post);
					if (! $marcas) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Tentativa de incluir nova marca de produtos('.$array_post['marca'].') no sistema',
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro. requisição não concluída!'));
					}
					else {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Incluiu nova marca de produtos('.$array_post['marca'].') no sistema',
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
					}
					redirect('clog/marcas/index');
				} 
				else {
					# Salvar caso exista $id.
					$marcas = $this->clog_model->atualizar('marcas_produtos', $array_post);
					if (! $marcas) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Tentativa de alterar a marca de produtos('.$array_post['marca'].') de ID n° '.$array_post['id'].', no sistema',
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro. requisição não concluída!'));
					}
					else {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Alterou a marca de produtos('.$array_post['marca'].') de ID n° '.$array_post['id'].', no sistema',
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
					}
					redirect('clog/marcas/index');
				}
			} # Validação de formulário.
		} # Verificação caso tenha sido enviado um POST.
	}
	
}