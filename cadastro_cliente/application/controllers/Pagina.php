<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pagina extends CI_Controller
{

    public $tela;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->tela = $this->uri->segment(1);
		
		if (($this->tela == 'login') || ($this->tela == 'recupera_senha') || ($this->tela == 'edit_senha')) {
            
        } else {
            verifica_login();
        }
    }

    public function index()
    {
        $dados = array(
            'tela' => $this->tela,
            'page_title' => 'CodeIgniter com Blade Template Engine! (PAGE 2)',
            'page_content' => 'Esse é um exemplo do CodeIgniter com Blade Template Engine (PAGE 2)'
        );
        $this->blade->view('main', $dados);
    }

  


	// =================================== CLIENTES ===================================
    public function clientesAdd()
    {
        if (can('CLI03')) {
			
			$dados = Array();
            $aux = [
				'id_clientes' 			=> '',
                'cnpj' 					=> '',
                'razao_social' 			=> '',
                'nome_comercial'		=> '',
                'inscricao_estadual' 	=> '',
                'email' 				=> '',
				'ddd' 					=> '',
				'telefone' 				=> '',
				'ramal' 				=> '',
				'tipo_linha' 			=> ''
            ];
			
			
			
			$dados['clientes'] = $aux;
			$dados['tela'] = $this->tela;
			$dados['disabled'] = '';

            $this->blade->view('clientes/clientes', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function clientesEdit()
    {
        if (can('CLI04')) {
            $this->load->model('call/Clientes_model', 'Clientes');

            $id = $this->uri->segment(2);
            $user = $this->Clientes->getDados($id);	
			$enderecos = $this->Clientes->getEndereco($id);	
			
			$dados = Array();
            if (! empty($user)) {
				
				$dados['clientes'] = $user[0];
				$dados['tela'] = $this->tela;
				$dados['enderecos'] = $enderecos;
				$dados['disabled'] = '';
				
                $this->blade->view('clientes/clientes', $dados);	
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function clientesView()
    {
        if (can('CLI02')) {
            $this->load->model('call/Clientes_model', 'Clientes');

            $id = $this->uri->segment(2);
			$user = $this->Clientes->getDados($id);	
			$enderecos = $this->Clientes->getEndereco($id);	
			
            $dados = Array();
            if (! empty($user)) {
				
				$dados['clientes'] = $user[0];
				$dados['tela'] = $this->tela;
				$dados['enderecos'] = $enderecos;
                $dados['disabled'] = 'disabled';

                $this->blade->view('clientes/clientes', $dados);
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function clientesList()
    {
        if (can('CLI05')) {
            $dados = [
                'tela' => $this->tela
            ];
            $this->blade->view('clientes/clientesList', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }



	// =================================== EMPRESAS ===================================
    public function empresasAdd()
    {
        if (can('EMP03')) {
			
			$dados = Array();
            $aux = [
				'id_empresas' 			=> '',
				'dt_ins_empresas' 		=> '', 
				'status' 				=> '',
				'razao_social' 			=> '', 
				'nome_comercial' 		=> '', 
				'apelido' 				=> '', 
				'cnpj' 					=> '', 
				'inscricao_estadual' 	=> '',
				'ccm' 					=> '', 
				'email' 				=> '',
				'site' 					=> '', 
				'contato' 				=> '', 
				'ddd' 					=> '',
				'telefone' 				=> '',
				'ramal' 				=> '',
				'tipo_linha' 			=> '',
				'cep' 					=> '', 
				'endereco' 				=> '', 
				'numero' 				=> '', 
				'bairro' 				=> '', 
				'complemento' 			=> '', 
				'cidade' 				=> '', 
				'uf' 					=> '',
				'img_logo' 				=> base_url('images/general/sem-imagem.png')
            ];
			
			
			
			$dados['empresas'] = $aux;
			$dados['tela'] = $this->tela;
			$dados['disabled'] = '';

            $this->blade->view('empresas/empresas', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function empresasEdit()
    {
        if (can('EMP04')) {
            $this->load->model('call/Empresas_model', 'empresas');

            $id = $this->uri->segment(2);
            $user = $this->empresas->getDados($id);	
			
			$dados = Array();
            if (! empty($user)) {
				
				$dados['empresas'] = $user[0];
				$dados['tela'] = $this->tela;
				$dados['disabled'] = '';
				
                $this->blade->view('empresas/empresas', $dados);	
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function empresasView()
    {
        if (can('EMP02')) {
            $this->load->model('call/Empresas_model', 'empresas');

            $id = $this->uri->segment(2);
			$user = $this->empresas->getDados($id);	
			
            $dados = Array();
            if (! empty($user)) {
				
				$dados['empresas'] = $user[0];
				$dados['tela'] = $this->tela;
                $dados['disabled'] = 'disabled';

                $this->blade->view('empresas/empresas', $dados);
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function empresasList()
    {
        if (can('EMP05')) {
            $dados = [
                'tela' => $this->tela
            ];
            $this->blade->view('empresas/empresasList', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }

	// =================================== ORÇAMENTOS ===================================
    public function orcamentosAdd()
    {
        if (can('OR203')) {
			
			$dados = Array();
            $aux = [
				'id_orcamentos' => '',
				'num_orcamento' => '', 
				'id_clientes' 	=> '',
				'valor_total' 	=> '', 
				'user_id' 		=> ''
            ];
			
			
			
			$dados['orcamentos'] = $aux;
			$dados['tela'] = $this->tela;
			$dados['disabled'] = '';

            $this->blade->view('orcamentos/orcamentos', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function orcamentosEdit()
    {
        if (can('OR204')) {
            $this->load->model('call/Orcamentos_model', 'orcamentos');

            $id = $this->uri->segment(2);
            $user = $this->orcamentos->getDados($id);	
			
			$dados = Array();
            if (! empty($user)) {
				
				$dados['orcamentos'] = $user[0];
				$dados['tela'] = $this->tela;
				$dados['disabled'] = '';
				
                $this->blade->view('orcamentos/orcamentos', $dados);	
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function orcamentosView()
    {
        if (can('OR202')) {
            $this->load->model('call/Orcamentos_model', 'orcamentos');

            $id = $this->uri->segment(2);
			$user = $this->orcamentos->getDados($id);	
			
            $dados = Array();
            if (! empty($user)) {
				
				$dados['orcamentos'] = $user[0];
				$dados['tela'] = $this->tela;
                $dados['disabled'] = 'disabled';

                $this->blade->view('orcamentos/orcamentos', $dados);
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function orcamentosList()
    {
        if (can('OR205')) {
            $dados = [
                'tela' => $this->tela
            ];
            $this->blade->view('orcamentos/orcamentosList', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }


    // =================================== Relatorios ===================================
    public function reportPessoa()
    {
        if (can('RPE01')) {
            // a chave do array devera ser igual o nome da coluna do banco e o valor será o nome da label
            // No caso de select chumbado que não virá de uma tabela , a chave permanece sendo igual
            // o nome da coluna da tabela porém o valor será um array onde a chave texto será a label e as posteriores o valor e texto dos imputs
            /*
             * Em alguns casos deverá ser feito join com tabelas associativas n pra n , nesses casos deve-se especificar da seguinte forma ex:
             *
             * "cargos_id" => [ -> chave cujo será o name do select de cargos
             * "texto" => "Cargos", -> a label do select de cargos
             * "origin" => "tb_pessoas_x_cargos", -> a tabela associativa entre pessoas e cargos
             * "campo" => "cargos_id", -> o nome da coluna da tabela associativa onde devera ser feito o where
             * ]
             */
            $array = [
                "main_pessoas" => "Nome",
                "cpf" => "CPF",
                "cpf_responsavel" => [
                    "texto" => "CPF do Responsável",
                    0 => [
                        "valor" => 0,
                        "texto" => "NÃO"
                    ],
                    1 => [
                        "valor" => 1,
                        "texto" => "SIM"
                    ]
                ],
                "apelido" => "Apelido",
                "data_nascimento" => "Data Nascimento",
                "sexo" => [
                    "texto" => "Gênero",
                    0 => [
                        "valor" => 1,
                        "texto" => "Feminino"
                    ],
                    1 => [
                        "valor" => 2,
                        "texto" => "Masculino"
                    ],
                    2 => [
                        "valor" => 3,
                        "texto" => "Outros"
                    ]
                ],
                "nacionalidades_id" => "Nacionalidade",
                "cutis" => [
                    "texto" => "Cutis",
                    0 => [
                        "valor" => 1,
                        "texto" => "Negro"
                    ],
                    1 => [
                        "valor" => 2,
                        "texto" => "Branco"
                    ]
                ],
                "tipo_sanguineo" => [
                    "texto" => "Tipo Sanguíneo",
                    0 => [
                        "valor" => 1,
                        "texto" => "O-"
                    ],
                    1 => [
                        "valor" => 2,
                        "texto" => "O+"
                    ],
                    2 => [
                        "valor" => 3,
                        "texto" => "A-"
                    ],
                    3 => [
                        "valor" => 4,
                        "texto" => "A+"
                    ],
                    4 => [
                        "valor" => 5,
                        "texto" => "B-"
                    ],
                    5 => [
                        "valor" => 6,
                        "texto" => "B+"
                    ],
                    6 => [
                        "valor" => 7,
                        "texto" => "AB-"
                    ],
                    7 => [
                        "valor" => 8,
                        "texto" => "AB+"
                    ]
                ],
                "agremiacoes_id" => "Agremiação",
                "nome_pai" => "Nome do Pai",
                "nome_mae" => "Nome da Mãe",
                "email" => "E-mail",
                "rg" => "RG",
                "empresa" => "Empresa",
                "profissoes_id" => "Profissão",
                "departamentos_id" => "Departamento",
                "estado_civil" => [
                    "texto" => "Estado Civil",
                    0 => [
                        "valor" => 1,
                        "texto" => "Casado"
                    ],
                    1 => [
                        "valor" => 0,
                        "texto" => "Solteiro"
                    ]
                ],
                "ativo" => [
                    "texto" => "Status",
                    0 => [
                        "valor" => 1,
                        "texto" => "Ativo"
                    ],
                    1 => [
                        "valor" => 0,
                        "texto" => "Inativo"
                    ]
                ],
                "papeis" => [
                    "texto" => "Papéis",
                    "origin" => "tb_pessoas_x_papeis",
                    "campo" => "titulo",
                    0 => [
                        "valor" => "Atleta",
                        "texto" => "Atleta"
                    ],
                    1 => [
                        "valor" => "Agremiação",
                        "texto" => "Agremiação"
                    ],
                    2 => [
                        "valor" => "Setor",
                        "texto" => "Setor"
                    ]
                ],

                // No caso abaixo foi feito um desvio neste projeto porque o join é um duas tabelas associativas
                "cargos_id" => [
                    "texto" => "Cargos",
                    "origin" => "desvio_",
                    "campo" => "cargos_id"
                ]
            ];

            $second_array = [
                "cargo" => [
                    "label" => "Cargo externo",
                    "tabela" => "tb_cargos"
                ]
            ];

            $page_data['form'] = montaForm($array, "tb_pessoas", $second_array);
            $page_data['tela'] = $this->tela;
            $this->blade->view('pessoa/reportPessoa', $page_data);
        } else {
            $this->blade->view('errors/permissao');
        }

        // O exemplo abaixo seria o correto para uma tabela associativa
        // "cargos_id" => [
        // "texto" => "Cargos",
        // "origin" => "tb_pessoas_x_cargos",
        // "campo" => "cargos_id",
        // ]
    }

    public function empresaList()
    {
        if (can('EMP05')) {
            $dados = [
                'tela' => $this->tela
            ];
            $this->blade->view('empresas/empresasList', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }
//    public function empresasAdd()
//    {
//        if (can('PE201')) {
//            $fake = array(
//                'test' => 'asd',
//            );
//            $dados = [
//                'tela' => $this->tela,
//                'title' => 'Adicionar',
//                'data' => $fake
//            ];
//            $this->blade->view('empresas/empresasEdit', $dados);
//        } else {
//            $this->blade->view('errors/permissao');
//        }
//    }
//    public function clientesList()
//    {
//        if (can('PE201')) {
//            $dados = [
//                'tela' => $this->tela
//            ];
//            $this->blade->view('clientes/clientesList', $dados);
//        } else {
//            $this->blade->view('errors/permissao');
//        }
//    }
//    public function clientesAdd()
//    {
//        if (can('PE201')) {
//            $fake = array(
//                'test' => 'asd',
//            );
//            $dados = [
//                'tela' => $this->tela,
//                'title' => 'Adicionar',
//                'data' => $fake
//            ];
//            $this->blade->view('clientes/clientesEdit', $dados);
//        } else {
//            $this->blade->view('errors/permissao');
//        }
//    }

// =================================== Insumos ===================================
    public function insumosList()
    {

        if (can('INS05')) {
            $dados = [
                'tela' => $this->tela
            ];
            $this->blade->view('insumos/insumosList', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }
    public function insumosEdit($id)
    {
		if (can('INS04')) {
			$this->load->model('call/Insumos_model', 'insumos');
			$date = $this->insumos->edit($id);
			$dados = [
				'tela' => $this->tela,
				'title' => 'Editar',
				'date' => $date[0],
				'fornecedor' => $this->insumos->get_fornecedor(),
			];
			$this->blade->view('insumos/insumosEdit', $dados);
		} else {
            $this->blade->view('errors/permissao');
        }
    }
    public function insumosAdd()
    {
        if (can('INS03')) {
			$this->load->model('call/Insumos_model', 'insumos');
            $fake = array(
                'id_insumos' => null,
                'nome' => '',
                'descricao' => '',
                'preco_venda' => '',
                'preco_compra' => '',
                'altura' => '',
                'largura' => '',
                'comprimento' => '',
                'peso' => '',
                'estoque' => '',
                'imagem' => base_url('images/general/sem-imagem.png'),
                'codigo_barra' => '',
                'status_insumos' => '',
                'unidade_medida' => '',
                'fabricante' => '',
                'id_fornecedores' => '',
                'sku' => '',
                'referenca_externa' => '',
                'ipi' => '',
                'dolar' => '0'
            );
            $dados = [
                'tela' => $this->tela,
                'title' => 'Adicionar',
                'fornecedor' => $this->insumos->get_fornecedor(),
                'date' => $fake
            ];
            $this->blade->view('insumos/insumosEdit', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }

// =================================== Categorias ===================================
    public function categoriasList()
    {

        if (can('CAT05')) {
            $dados = [
                'tela' => $this->tela

            ];
            $this->blade->view('categorias/categoriasList', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }

    public function categoriasAdd()
    {
        if (can('CAT03')) {
            $fake = array(
                'id_categoria' => null,
                'nome'=> '',
                'prod_diaria'=> '',
            );
            $dados = [
                'tela' => $this->tela,
                'title' => 'Adicionar',
                'date' => $fake
            ];
            $this->blade->view('categorias/categoriasEdit', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }
    public function categoriasEdit($id){
		if (can('CAT04')) {
			$this->load->model('call/Categorias_model', 'categorias');
			$date = $this->categorias->edit($id);
			$dados = [
				'tela' => $this->tela,
				'title' => 'Editar',
				'date' => $date[0],
			];
			$this->blade->view('categorias/categoriasEdit', $dados);
		} else {
            $this->blade->view('errors/permissao');
        }
    }
    
    public function configValores() {
        $dados = [
            'tela' => $this->tela,
            'title' => 'Editar'
        ];
        $this->blade->view('configuracoes/configuracoes', $dados);
    }
	
	
	// ==================================== ICMS ====================================
	
	public function ICMSList()
    {
        if (can('ICM01')) {
            $dados = [
                'tela' => $this->tela
            ];
            $this->blade->view('ICMS/ICMS', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }
	
	public function ICMSEdit($id){
		if (can('ICM04')) {
			$this->load->model('call/ICMS_model', 'ICMS');
			$date = $this->ICMS->edit($id);
			$dados = [
				'tela' => $this->tela,
				'title' => 'Editar',
				'date' => $date[0],
			];
			$this->blade->view('ICMS/ICMSEdit', $dados);
		} else {
            $this->blade->view('errors/permissao');
        }
    }
	
    
	// =================================== PRODUTOS ===================================
	
    public function produtosList()
    {
        if (can('PRO05')) {
            $dados = [
                'tela' => $this->tela
            ];
            $this->blade->view('produtos/produtosList', $dados);
        } else {
            $this->blade->view('errors/permissao');
        }
    }
	
	public function produtosAdd()
    {
        if (can('PRO03')) {
			
			$this->load->model('call/produto_model', 'produtos');
			
			$dados = Array();
            $aux = [
				'descricao' 				=> '',
                'categoria' 				=> '',
				'id_produtos' 				=> '',
				'substituicao_tributaria' 	=> '',
				'img_produto' 				=> ''
            ];
			
			$dados = [
					'tela' => $this->tela,
					'title' => 'Cadastrar',
					'insumos' => $this->produtos->get_insumos(),
					'categorias' => $this->produtos->get_categorias(),
					'produtos' => $aux,
					'disabled' => ''
				];

            $this->blade->view('produtos/produtos', $dados);	
        } else {
            $this->blade->view('errors/permissao');
        }
    }
   
	
   
   
   
	public function produtosEdit($id) {
        if (can('PRO04')) {
            $this->load->model('call/produto_model', 'produtos');

            $id = $this->uri->segment(2);
            $produtos = $this->produtos->getDados($id);		
			
			$insumos = json_decode($produtos[0]['insumos'], true);
			
			//echo '<pre>'; print_r($insumos); die();
			
			$dados = Array();
            if (! empty($produtos)) {
				
				$dados = [
					'tela' => $this->tela,
					'title' => 'Editar',
					'insumos' => $this->produtos->get_insumos(),
					'prod_insumos' => $insumos,
					'categorias' => $this->produtos->get_categorias(),
					'produtos' => $produtos[0],
					'disabled' => ''
				];
                $this->blade->view('produtos/produtos', $dados);	
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }
	
	
	public function produtosView($id) {
        if (can('PRO02')) {
            $this->load->model('call/produto_model', 'produtos');

            $id = $this->uri->segment(2);
            $produtos = $this->produtos->getDados($id);		
			
			$insumos = json_decode($produtos[0]['insumos'], true);
			
			$dados = Array();
            if (! empty($produtos)) {
				
				$dados = [
					'tela' => $this->tela,
					'title' => 'Visualizar',
					'insumos' => $this->produtos->get_insumos(),
					'prod_insumos' => $insumos,
					'categorias' => $this->produtos->get_categorias(),
					'produtos' => $produtos[0],
					'disabled' => 'disabled'
				];
                $this->blade->view('produtos/produtos', $dados);	
            } else {
                show_404();
            }
        } else {
            $this->blade->view('errors/permissao');
        }
    }
    public function uploads(){
        $dados = [
            'tela' => $this->tela,
            'title' => 'Editar'
        ];
        $this->blade->view('uploads/uploads', $dados);
    }
    public function upload_insumos(){
        $dados = [
            'tela' => $this->tela,
            'title' => 'Upload'
        ];
        $this->blade->view('uploads/upload_insumos', $dados);
    }
    public function upload_fornecedor(){
        $dados = [
            'tela' => $this->tela,
            'title' => 'Upload'
        ];
        $this->blade->view('uploads/upload_fornecedor', $dados);
    }
}
