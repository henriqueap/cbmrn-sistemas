<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* @version 1.0
* @author CBM-RN
* @link http://www.cbm.rn.gov.br/
*/

class Auth	{

	function __construct() 
	{
		$CI = & get_instance();
		$CI->load->library('session');
		$this->init();
	}

	public function init() 
	{
		# Check users exists.
		$this->check_users_exists_session();
	}

	public function check_users_exists_session() 
	{	
		# Instanciar CodeIgniter.
		$CI = & get_instance();

		# Instanciar banco de dados.
		$CI->load->database();
		$CI->load->model('acesso_model');
		$CI->load->helper('url');

		# Array Session.
		$session = array(
			'loggin'=>$CI->session->userdata('loggin'), 
			'id_militar'=>$CI->session->userdata('id_militar'), 
			'usuario'=>$CI->session->userdata('militar'),
			'sistema'=>$CI->session->userdata('sistema')
		);

		if($session['loggin'] != TRUE) {
			
			# Capturar modulo atual e verificar se ele não for o acesso.php redirecionar para o mesmo.
			$function = $_SERVER['REQUEST_URI'];
			$explode = explode('/', $function);
			$modulo = $explode['3'];

			if(!strcasecmp('acesso', $modulo) == 0) {
			 	$CI->session->set_flashdata('msg', array('type' => 'alert-danger', 'msg' => 'Erro ao entrar no sistema!'));
			 	redirect("acesso");
		  }
		}

		# Check.
	  $this->check_users_get_permission();
	}

	public function check_users_get_permission() 
	{
		$CI = & get_instance();

		# Instanciar banco de dados.
		$CI->load->database();
		$CI->load->model('acesso_model');
		$CI->load->helper('url');
		$CI->load->library('session');

		$uri = $_SERVER['REQUEST_URI'];
		$militar = $CI->session->userdata('id_militar');
		$usuario = $CI->session->userdata('militar');
		$uri_array = explode('/', $uri);
		/*var_dump($militar);
		/*var_dump($uri_array[4]);*/

		if (FALSE === $militar) {
			$CI->session->set_flashdata('msg', array('type' => 'alert-danger', 'msg' => 'O sistema fechou por inatividade!'));
			redirect("acesso");
		}

		if (isset($uri_array[4])) {
			# Capturar modulo.	
			$modulo = $uri_array[3].'/'.$uri_array[4];

			if (isset($uri_array[5])) {
				if ($uri_array[5] == "index") {
					$modulo = $uri_array[3].'/'.$uri_array[4];
				}
				else {
					if (FALSE !== strpos($uri_array[5], "?")) $modulo = $uri_array[3].'/'.$uri_array[4].'/'.substr($uri_array[5], 0, strpos($uri_array[5], "?"));
					else $modulo = $uri_array[3].'/'.$uri_array[4].'/'.$uri_array[5];
				}
				
			}
			# var_dump($modulo);

			if (!$CI->acesso_model->getPermissao($modulo, $militar)) { 
				$CI->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'O usuário logado não tem acesso a esta página do sistema!'));
				redirect("clog/clog/index");
				# $sistema = $CI->session->userdata('sistema');
				#redirect("");
			} 

		} # Condição para verificar se existe.
	}
}

