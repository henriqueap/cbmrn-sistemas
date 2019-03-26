<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Grupos extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('clog_model');
    $this->load->library(array('auth'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$this->cadastro();
	}

	public function cadastro($data="") {
		# Listar todos os grupos de produtos.
		# Bloco de auditoria
			/*$auditoria = array(
								'auditoria'=>'Listou os grupos de produtos',
								'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo'=>$this->session->userdata['sistema']
							);
			$this->clog_model->audita($auditoria, 'consultar');*/
		# .Bloco de auditoria
		$lista = $this->clog_model->listar('grupo_produtos')->result();
		$grupos = $this->load->view('grupos/index', array('data'=>$data, 'lista'=>$lista), TRUE);
		$this->load->view('layout/index', array('layout'=>$grupos), FALSE);
	}

	public function editar($id) {
		# Chamar method cadastro.
		$data = $this->clog_model->listar('grupo_produtos', $id)->row();
		$this->cadastro($data);
	}

	public function excluir($id) {
		$info_grupo = $this->clog_model>getByID('grupo_produtos', $id)->row();
		$exclusao = $this->clog_model->excluir('grupo_produtos', $id);
		if (! $exclusao) {
			# Bloco de auditoria
				$auditoria = array(
									'auditoria'=>"Tentativa de excluir o grupo de produtos ID n° $id, <em>$info_grupo->nome</em>, no sistema",
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
									'auditoria'=>'Excluiu o grupo de produtos ID n° '.$id.', <em>$info_grupo->nome</em>, no sistema',
									'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
									'idmodulo'=>$this->session->userdata['sistema']
								);
				$this->clog_model->audita($auditoria, 'excluir');
			# .Bloco de auditoria
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Excluído com sucesso!'));
		}
		redirect('clog/grupos/index');
	}

	public function salvar() {
		# Salvar 
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('nome', 'nome', 'trim|required|min_length[3]|max_length[45]');

			if ($this->form_validation->run() == TRUE) {
				# Pegar array com os dados do method post.
				$array_post = array(
					'id'=>$this->input->post('id'), 
					'nome'=>$this->input->post('nome')
				);

				if (empty($array_post['id'])) {
					# Salvar caso não exista $id.
					$grupo = $this->clog_model->salvar('grupo_produtos', $array_post);
					if (! $grupo) {
						# Bloco de auditoria
							$auditoria = array(
								'auditoria'=>'Tentativa de incluir novo grupo de produtos(<em>'.$array_post['nome'].'</em>) no sistema',
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
								'auditoria'=>'Incluiu novo grupo de produtos(<em>'.$array_post['nome'].'</em>) no sistema',
								'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
								'idmodulo'=>$this->session->userdata['sistema']
							);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
					}
					redirect('clog/grupos/index');
				} 
				else {
					# Salvar caso exista $id.
					$grupos = $this->clog_model->atualizar('grupo_produtos', $array_post);
					if (! $grupos) {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Tentativa de alterar o grupo de produtos <em>'.$array_post['nome'].'</em>, no sistema',
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'alterar');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Houve um erro. Requisição não concluída!'));
					}
					else {
						# Bloco de auditoria
							$auditoria = array(
												'auditoria'=>'Alterou o grupo de produtos <em>'.$array_post['nome'].'</em>, no sistema',
												'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
												'idmodulo'=>$this->session->userdata['sistema']
											);
							$this->clog_model->audita($auditoria, 'inserir');
						# .Bloco de auditoria
						$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
					}
					redirect('clog/grupos/index');
				}
			} # Validação de formulário.
			else {
				# Bloco de auditoria
					$auditoria = array(
										'auditoria'=>'Tentativa de incluir novo grupo (<em>'.$array_post['nome'].'</em>) de produtos no sistema',
										'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
										'idmodulo'=>$this->session->userdata['sistema']
									);
					$this->clog_model->audita($auditoria, 'inserir');
				# .Bloco de auditoria
				$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O nome do grupo é obrigatório e deve ter entre 3 e 45 caracteres!'));
				redirect('clog/grupos/index');
			}
		} # Verificação caso exista method post.
	}

}