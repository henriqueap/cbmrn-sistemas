<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Notas extends MX_Controller 
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('clog_model', 'notas_model'));
	}

	public function index()
	{
		$this->cadastro();
	}

	public function cadastro($data="")
	{
		# Listar empresas cadastradas.
		$empresas = $this->clog_model->listar('empresas')->result();

		$notas = $this->load->view('notas/cadastro', array('data'=>$data, 'empresas'=>$empresas), TRUE);
		$this->load->view('layout/index', array('layout'=>$notas), FALSE);
	}

	public function salvar()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			
			$this->form_validation->set_rules('numero', 'numero', 'trim|required|xss_clean');
			$this->form_validation->set_rules('data', 'data', 'trim|required|xss_clean');
			$this->form_validation->set_rules('empresas_id', 'empresas', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == TRUE) {
				# Caso tenha sido feita a validação com sucesso.
				$id_nota_fiscal = $this->notas_model->dados_notas();
				redirect("frotas/notas/itens_nota/$id_nota_fiscal");
			} else{
				# Caso tenha sido enviado algum dado errado.
				# Exibir erros!
			}
		} else redirect('frotas/notas/index'); # Caso não tenha sido enviado nenhum POST.
	}

	public function itens_nota($id_nota)
	{
		if (isset($id_nota)) {
			# Listar todos os produtos.
			$produtos = $this->clog_model->listar('produtos')->result();
			
			# Informações da nota fiscal.
			$info_nota = $this->clog_model->listar('notas_fiscais', $id_nota)->row();

			# Listagem de todos os itens já cadastrados na nota fiscasl.
			$itens = $this->notas_model->itens_notas($id_nota)->result();
			# var_dump($itens);

			$itens = $this->load->view('notas/itens_nota', array('id_nota'=>$id_nota, 'info_nota'=>$info_nota, 'produtos'=>$produtos, 'itens'=>$itens), TRUE);
			$this->load->view('layout/index', array('layout'=>$itens), FALSE);

			if ($this->input->server('REQUEST_METHOD') == 'POST') {
				# Adicionar item a nota fiscal.
				$this->add_itens_nota($id_nota);
			}
		} else die();
	}

	public function add_itens_nota($id_nota) 
	{
		# Adicionar itens a nota fiscal.
		$this->notas_model->add_item($id_nota);
		redirect("frotas/notas/itens_nota/$id_nota");
	}

	public function consulta()
	{
		$notas = $this->load->view('notas/consulta', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$notas), FALSE);
	}
}
