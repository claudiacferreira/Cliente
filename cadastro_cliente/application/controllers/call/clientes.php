<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {
    function __construct() {
        parent::__construct();   
        $this->load->model('call/Clientes_model', 'clientes'); 
        $this->load->library('form_validation');
    }
    
    public function clientesAdd() {
        $clientes = trimArray($this->input->post());
        unset($clientes['id']);
        $this->form_validation->set_rules('razao_social','Razão Social','required');
        $this->form_validation->set_rules('nome_comercial','Nome Comercial','required');
        $this->form_validation->set_rules('cnpj','CNPJ','required');
        $this->form_validation->set_rules('email','E-mail','required');
        
        if( $this->form_validation->run() === FALSE ) {
            $retorno = [
                "sucesso" => 0,
                "errors" => validation_errors()
            ];
        } else {
            $retorno = $this->clientes->save($clientes);
        }
        echo json_encode($retorno);
    }

    public function clientesList(){
        $index_order = $this->input->post('order')[0]["column"];
        $order_type = $this->input->post('order')[0]['dir'];
        $draw  = $this->input->post("draw");
        $page = $this->input->post("start");
        $limit  = $this->input->post("length");
        $search = $this->input->post("search");
        $order_by = $this->input->post('columns')[$index_order]['name'];

        $retorno = $this->clientes->lista($draw,$page,$limit,$search, $order_by, $order_type);/*ta no model*/
        echo json_encode($retorno);
    }

    public function clientesDelete() {
        $id = $this->input->post('id');
        $retorno = $this->clientes->delete($id);
        echo json_encode($retorno);
    }
	
	public function clientesEnderecoDelete() {
        $id = $this->input->post('id');
        $retorno = $this->clientes->deleteEndereco($id);
        echo json_encode($retorno);
    }

    public function clientesEdit(){
        $clientes = $this->input->post();
        $this->form_validation->set_rules('razao_social','Razão Social','required');
        $this->form_validation->set_rules('nome_comercial','Nome Comercial','required');
        $this->form_validation->set_rules('cnpj','CNPJ','required');
        $this->form_validation->set_rules('email','E-mail','required');
      
        if( $this->form_validation->run() === FALSE ) {
            $retorno = [
                "sucesso" => 0,
                "error" => validation_errors()
            ];
        } else {
            $retorno = $this->clientes->edit($clientes);
        }

        echo json_encode($retorno);
    }
	

	
	public function buscaEndereco(){
		$aux = $this->input->post();
		$cep = $aux['cep'];
		// formatar o cep removendo caracteres nao numericos
		$cep = preg_replace("/[^0-9]/", "", $cep);
		$retorno = file_get_contents("http://viacep.com.br/ws/$cep/json/");
		echo $retorno;
	}
	
	
}
