<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Acesso extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('acesso_model', '../modules/clog/models/clog_model', '../modules/clog/models/militares_model'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {	
		$this->acesso();
	}

	/**
	 * @param Empty
	 * View de acesso ao usuário ao sistema.
	 */
	public function acesso() 
	{
		$modulos = $this->acesso_model->search_module();

		
		/*PHP Fatal error:  Uncaught exception 'Exception' with message 'This application must be run on the command line.' in /var/www/html/sistemas/application/third_party/MX/Loader.php(319) : eval()'d code:5\nStack trace:\n#0 /var/www/html/sistemas/application/third_party/MX/Loader.php(319): eval()\n#1 /var/www/html/sistemas/application/third_party/MX/Loader.php(269): MX_Loader->_ci_load(Array)\n#2 /var/www/html/sistemas/application/controllers/acesso.php(29): MX_Loader->view('acesso/google', Array, true)\n#3 /var/www/html/sistemas/application/controllers/acesso.php(17): Acesso->acesso()\n#4 [internal function]: Acesso->index()\n#5 /var/www/html/sistemas/system/core/CodeIgniter.php(359): call_user_func_array(Array, Array)\n#6 /var/www/html/sistemas/index.php(189): require_once('/var/www/html/s...')\n#7 {main}\n  thrown in /var/www/html/sistemas/application/third_party/MX/Loader.php(319) : eval()'d code on line 5*/
		
		# Acesso aos sistemas.
		$index = $this->load->view('acesso/acesso', array('modulos'=>$modulos), TRUE);
		$this->load->view('acesso/index', array('layout'=>$index), FALSE);
	}

	/**
	 * @param Empty 
	 * Recuperar senha de usuários.
	 */
	public function recuperar_acesso() 
	{
		# Acesso aos sistemas.
		$index = $this->load->view('acesso/recuperar_acesso', '', TRUE);
		$this->load->view('acesso/index', array('layout'=>$index), FALSE);
	}

	/**
	 * @param Empty 
	 * Acesso ao sistema, validação de usuários e sistemas. 
	 */
	public function loggin() {
		# Validação de acesso.
		if ($this->input->server('REQUEST_METHOD')  === 'POST') {
			
			$this->form_validation->set_rules('sistema', 'Modulo', 'trim|required|xss_clean');
			$this->form_validation->set_rules('matricula', 'Matrícula', 'trim|required|min_length[9]|max_length[9]|xss_clean');
			$this->form_validation->set_rules('senha', 'Senha', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE) {

				$modulo = $this->acesso_model->consulta_modulos(array('sistema'=>$this->input->post('sistema')))->row();
				$result_query_users = $this->acesso_model->consulta_militares()->row();
				//var_dump($result_query_users);die();
				$users_data = array(
					'id_militar'=>$result_query_users->id,
					'militar'=>$result_query_users->militar,
					'matricula_militar'=>$result_query_users->matricula,
					'sistema'=>$modulo->id, 
					'lotacao_id'=>$result_query_users->lotacao_id,
					'loggin'=>TRUE
				);
				# var_dump($users_data); die();

				$this->session->set_userdata($users_data);
				$var = $this->session->userdata('id_militar');

				switch (empty($result_query_users)) {
					case TRUE:
						$this->session->set_flashdata('msg', array('type' => 'alert-danger', 'msg' => 'Erro!'));
						redirect("acesso/index");
						break;
					case FALSE:
						# Caso a validação seja verdadeira!
						# Bloco de auditoria
							$auditoria = array(
								'auditoria'=>'Entrou no sistema',
								'idmilitar'=>$result_query_users->id, #Checar quem está acessando e permissões
								'idmodulo'=>$modulo->id
							);
							//var_dump($auditoria); die();
							$this->clog_model->audita($auditoria, 'logar');
						# .Bloco de auditoria
						redirect(base_url("index.php").'/'.strtolower($modulo->sigla));
						break;
					default: 
						break;
				}
			} else {
				# Chamar method acesso, caso algum erro tenha acontecido.
				$this->acesso();
			}
		}
	}

	/**
	 * @param Empty.
	 * Destruir sessão dos usuários.
	 */
	public function logout() {
		# session_destroy();
		$session = array(
			'loggin'=>$this->session->userdata('loggin'), 
			'id_militar'=>$this->session->userdata('id_militar'),
			'militar'=>$this->session->userdata('militar'),
			'matricula_militar'=>$this->session->userdata('matricula_militar'), 
			'sistema'=>$this->session->userdata('sistema')
		);
		
		if (TRUE === $this->session->userdata('loggin')) {
			# Bloco de auditoria
				$auditoria = array(
					'auditoria'=>'Saiu do sistema',
					'idmilitar'=>$this->session->userdata['id_militar'], #Checar quem está acessando e permissões
					'idmodulo'=>$this->session->userdata['sistema']
				);
				$this->clog_model->audita($auditoria, 'sair');
			# .Bloco de auditoria
		}

		$this->session->unset_userdata($session);
		$this->session->set_flashdata('msg', array('type' => 'alert-success', 'msg' => 'Logout efetuado com sucesso!'));
		redirect('acesso');
	}
}

