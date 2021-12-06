<?php

/**
 * Description of clientes_model
 *
 * @author lucas
 */
class Clientes_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function save($result)
	{

		$clientes['cnpj'] 					= soNumero($result['cnpj']);
		$clientes['razao_social'] 			= $result['razao_social'];
		$clientes['nome_comercial'] 		= $result['nome_comercial'];
		$clientes['inscricao_estadual'] 	= $result['inscricao_estadual'];
		$clientes['email'] 					= $result['email'];

		$clientes['ddd'] 					= $result['ddd'];
		$clientes['telefone'] 				= soNumero($result['telefone']);
		$clientes['ramal']					= $result['ramal'];
		//$clientes['tipo_linha'] 			= $result['tipo_linha'];

		$clientes['usr_ins_clientes']		= $this->session->userdata('id');
		$clientes['usr_upd_clientes'] 		= $this->session->userdata('id');

		$this->db->insert('tb_clientes', $clientes);
		$id = $this->db->insert_id();

		if (!$id) {
			$retorno = [
				"sucesso" => 0,
				"error" => $this->db->error()
			];
		} else {

			$cont_endereco = count($result['end_cep']);
			for ($i = 0; $i < $cont_endereco; $i++) {
				$endereco['id_clientes'] 		= $id;
				$endereco['tipo'] 					= $result['end_tipo'][$i];
				$endereco['identificacao'] 			= $result['end_identificacao'][$i];
				$endereco['cep'] 					= soNumero($result['end_cep'][$i]);
				$endereco['endereco']				= $result['end_endereco'][$i];
				$endereco['numero'] 				= $result['end_numero'][$i];
				$endereco['bairro'] 				= $result['end_bairro'][$i];
				$endereco['complemento'] 			= $result['end_complemento'][$i];
				$endereco['cidade'] 				= $result['end_cidade'][$i];
				$endereco['uf'] 					= $result['end_uf'][$i];
				$endereco['usr_ins_forn_endereco'] 	= $this->session->userdata('id');
				$endereco['usr_upd_forn_endereco'] 	= $this->session->userdata('id');
				$this->db->insert('tb_clientes_x_endereco', $endereco);
			}

			$retorno = [
				"sucesso" => 1
			];
		}

		return $retorno;
	}

	public function lista($draw, $page, $limit, $search, $order_by, $order_type)
	{
		$totalRecords = $this->db->count_all('tb_clientes');

		$retorno = [
			"draw" => (int) $draw,
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $this->getRecords('filtered', $page, $limit, $search['value'], $order_by, $order_type),
			"data" => $this->getRecords('data', $page, $limit, $search['value'], $order_by, $order_type)
		];
		return $retorno;
	}

	public function getRecords($type, $page, $limit, $search, $order_by, $order_type)
	{
		$this->db->select(
			'
			id_clientes,
			DATE_FORMAT(dt_ins_clientes, "%d/%m/%Y") AS dt_ins_clientes, 
			razao_social, 
			nome_comercial,
			format_cnpj(cnpj) AS cnpj'
		);
		$this->db->from('tb_clientes');
		$this->db->where('status', '1');
		if (!empty($search)) {
			$this->db->where('status', '1')
			->group_start()
			->like('id_clientes', $search, 'both')
			->or_like('razao_social', $search, 'both')
			->or_like('nome_comercial', $search, 'both')
			->or_like('cnpj', $search, 'both')
			->group_end();			
		}
		$this->db->order_by($order_by, $order_type);

		if ($type == "filtered") {
			$stmt = $this->db->get();
			//echo $this->db->last_query();exit;
			return $stmt->num_rows();
		} else {
			$this->db->limit($limit, $page);
			$dados = $this->db->get()->result_array();

			foreach ($dados as $key => $value) {
				$value['options'] = '';
				if (can('USU05')) {
					$value['options'] .= '<button type="button" class="btb btn btn-sm btn-info btn-sm btn-sm-mobile" style="float:right;"	 onclick="window.location = \'clientesView/' . $value['id_clientes'] . ' \'"><i class="fas fa-file" aria-hidden="true"></i> Visualizar</button> ';
				}
				if (can('USU04')) {
					$value['options'] .= '<button type="button" class="btb btn btn-sm btn-primary btn-sm btn-sm-mobile" style="float:right;" onclick="window.location = \'clientesEdit/' . $value['id_clientes'] . ' \'"><i class="fas fa-edit" aria-hidden="true"></i> Editar</button> ';
				}
				if (can('USU06')) {
					$value['options'] .= '<button type="button" class="btb btn btnDel btn-sm btn-danger btn-sm btn-sm-mobile" style="float:right;" onclick="delete_clientes(' . $value['id_clientes'] . ')"><i class="fas fa-trash" aria-hidden="true"></i> Excluir</button> ';
				}

				$dados[$key] = $value;
			}
			return $dados;
		}
	}


	public function delete($id)
	{
		$this->db->where('id_clientes', $id);
		$clientes['status'] = 0;
		if (!$this->db->update('tb_clientes', $clientes)) {
			$retorno = [
				"sucesso"  => 0,
				"mensagem" => $this->db->error()
			];
		} else {
			$retorno = [
				"sucesso" => 1
			];
		}
		return $retorno;
	}


	public function deleteEndereco($id)
	{
		$this->db->where('id_clientes_endereco', $id);

		if ($this->db->delete('tb_clientes_x_endereco')) {
			$retorno = [
				"sucesso" => 1
			];
		} else {
			$retorno = [
				"sucesso" => 0,
				"message" => $this->db->error()
			];
		}
		return $retorno;
	}

	public function edit($result)
	{
		$clientes['cnpj'] 				= soNumero($result['cnpj']);
		$clientes['razao_social'] 		= $result['razao_social'];
		$clientes['nome_comercial'] 	= $result['nome_comercial'];
		$clientes['inscricao_estadual'] = $result['inscricao_estadual'];
		$clientes['email'] 				= $result['email'];
		$clientes['usr_upd_clientes'] 	= $this->session->userdata('id');

		$clientes['ddd'] 				= $result['ddd'];
		$clientes['telefone'] 			= soNumero($result['telefone']);
		$clientes['ramal']				= $result['ramal'];
		//$clientes['tipo_linha'] 		= $result['tipo_linha'];

		$id								= $result['id'];

		$this->db->where('id_clientes', $id);


		if (!$this->db->update('tb_clientes', $clientes)) {
			$retorno = [
				"sucesso"  => 0,
				"mensagem" => $this->db->error()
			];
		} else {


			/* Endereços */
			$enderecos = $this->getEndereco($id);
			foreach ($enderecos as $key => $endereco) {

				$id_end = $endereco['id_clientes_endereco'];

				$endereco['tipo'] 					= $result['end_tipo_' . $id_end];
				$endereco['identificacao']			= $result['end_identificacao_' . $id_end];
				$endereco['cep'] 					= soNumero($result['end_cep_' . $id_end]);
				$endereco['endereco'] 				= $result['end_endereco_' . $id_end];
				$endereco['numero'] 				= $result['end_numero_' . $id_end];
				$endereco['bairro'] 				= $result['end_bairro_' . $id_end];
				$endereco['complemento'] 			= $result['end_complemento_' . $id_end];
				$endereco['cidade'] 				= $result['end_cidade_' . $id_end];
				$endereco['uf'] 					= $result['end_uf_' . $id_end];
				$endereco['usr_upd_forn_endereco'] 	= $this->session->userdata('id');

				$this->db->where('id_clientes_endereco', $id_end);
				$this->db->update('tb_clientes_x_endereco', $endereco);
			}
			if (isset($result['end_cep'])) {
				$cont_endereco = count($result['end_cep']);
				for ($i = 0; $i < $cont_endereco; $i++) {
					$endereco_novo['id_clientes'] 		= $id;
					$endereco_novo['tipo'] 					= $result['end_tipo'][$i];
					$endereco_novo['identificacao'] 		= $result['end_identificacao'][$i];
					$endereco_novo['cep'] 					= soNumero($result['end_cep'][$i]);
					$endereco_novo['endereco']				= $result['end_endereco'][$i];
					$endereco_novo['numero'] 				= $result['end_numero'][$i];
					$endereco_novo['bairro'] 				= $result['end_bairro'][$i];
					$endereco_novo['complemento'] 			= $result['end_complemento'][$i];
					$endereco_novo['cidade'] 				= $result['end_cidade'][$i];
					$endereco_novo['uf'] 					= $result['end_uf'][$i];
					$endereco_novo['usr_ins_forn_endereco'] = $this->session->userdata('id');
					$endereco_novo['usr_upd_forn_endereco'] = $this->session->userdata('id');

					$this->db->insert('tb_clientes_x_endereco', $endereco_novo);
				}
			}


			$retorno = [
				"sucesso" => 1
			];
		}
		return $retorno;
	}

	public function getDados($id)
	{
		$this->db->select('
			id_clientes,
			dt_ins_clientes, 
			status,
			razao_social, 
			nome_comercial, 
			format_cnpj(cnpj) AS cnpj, 
			inscricao_estadual,
			email,
			ddd,
			telefone,
			ramal,
			tipo_linha
		');
		$this->db->from('tb_clientes');
		$this->db->where('id_clientes', $id);
		return $this->db->get()->result_array();
	}


	public function getEndereco($id){
		$this->db->select('id_clientes_endereco, tipo, identificacao, format_cep(cep) AS cep, endereco, numero, bairro, complemento, cidade, uf');
		$this->db->from('tb_clientes_x_endereco');
		$this->db->where('id_clientes', $id);
		$this->db->order_by('tipo ASC');
		return $this->db->get()->result_array();
	}
}
