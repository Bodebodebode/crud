<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('Produtos_model', 'GrupoDeProdutos_model'));
		$this->load->database();
		$this->criar_database();
	}

	public function index()	{
		$data =	array(
									'titulo' => 'CRUD - Teste Instituto Bulla',
									'subtitulo' => 'index'
									);
		$this->load->view('index', $data);
	}

	public function criar_database(){
		//	código para criar a db; este método será executado apenas uma vez, pelo constructor
		$this->load->dbforge();
		$tables = $this->db->list_tables();

			foreach ($tables as $table){
			        if($table == 'produtos' || $table == 'grupos' || $table == 'produtosxgrupos'){
								return;
							}
			}
		// criando table dos produtos
		$fields = array(
									'nome' => array(
																	'type' => 'VARCHAR',
																	'constraint' => '100'
									),
									'codigo' => array(
																		'type' => 'INT',
																		'constraint' => '10'
									),
									'fabricante' => array(
																				'type' => 'VARCHAR',
																				'constraint' => '100'
									),
									'tipo' => array(
																	'type' => 'VARCHAR',
																	'constraint' => '100'
									)
			);
			$this->dbforge->add_field($fields);
			$this->dbforge->add_field('id');
			$this->dbforge->add_key('codigo', TRUE);
			$this->dbforge->create_table('produtos');
			// criando table dos grupos
			$fields = array(
										'nome' => array(
																		'type' => 'VARCHAR',
																		'constraint' => '100'
										),
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_field('id', TRUE);
				$this->dbforge->create_table('grupos');
				// produtosxgrupos
				$fields = array(
											'produtos' => array(
												'type' => 'INT',
												'constraint' => '10'
											),
											'grupos' => array(
												'type' => 'INT',
												'constraint' => '9',
												'unsigned' => 'TRUE'
											)
					);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_field('id', TRUE);
				$this->dbforge->add_field('FOREIGN KEY (grupos) REFERENCES grupos(id)');
				$this->dbforge->add_field('FOREIGN KEY (produtos) REFERENCES produtos(id)');
				$this->dbforge->create_table('produtosxgrupos');

				// adicionando as chaves estrangeiras
				/*
				$this->dbforge->add_column('produtosxgrupos', [
																										'COLUMN produtos int NOT NULL',
																										'CONSTRAINT fk_codigo_produtos FOREIGN KEY (produtos) REFERENCES produtos(codigo)'
																										]
				);
				$fields = array(
												'produtos' => array(
																						'type' => 'int',
																						''
												)
				);
			$this->dbforge->add_column('produtosxgrupos', [
																										'COLUMN grupos int NOT NULL',
																										'CONSTRAINT fk_id_grupos FOREIGN KEY (grupos) REFERENCES grupos(id)'
																										]
			); */

	}

	// CREATE
	public function criar(){
		$data = array(
									'titulo' => 'CRUD - Teste Instituto Bulla',
									'subtitulo' => 'Criar',
									'grupos' => $this->GrupoDeProdutos_model->ler(NULL),
									'produtos' => $this->Produtos_model->ler(NULL)
									);
									if($data['grupos'] == ''){
										$data['grupos'] = array();
									}
									if($data['produtos'] == ''){
										$data['produtos'] = array();
									}
		$this->load->view('criar', $data);
	}

	public function criar_produto(){
		$produto_criado = $this->Produtos_model->criar($this->input->post());
		redirect('', 'refresh');

	}

	public function criar_grupo(){
		$produto_criado = $this->GrupoDeProdutos_model->criar($this->input->post());
		redirect('', 'refresh');

	}

	//READ
	public function ler(){
		$data = array(
									'titulo' => 'CRUD - Teste Instituto Bulla',
									'subtitulo' => 'Ler'
									);
		$this->load->view('ler', $data);
	}

	public function mostrar_produto(){

	}

	public function mostrar_grupo(){

	}

	//UPDATE
	public function atualizar(){
		$data = array(
									'titulo' => 'CRUD - Teste Instituto Bulla',
									'subtitulo' => 'Atualizar'
									);
		$this->load->view('atualizar', $data);
	}

	public function atualizar_produto(){

	}

	public function atualizar_grupo(){

	}

	//DELETE
	public function deletar(){
		$data = array(
									'titulo' => 'CRUD - Teste Instituto Bulla',
									'subtitulo' => 'Deletar'
									);
		$this->load->view('deletar', $data);
	}

	public function deletar_produto(){

	}

	public function deletar_grupo(){

	}

}