<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_model extends CI_Model {

  function __construct(){
    parent::__construct();
  }

  public function criar($dados){
    $this->db->where('codigo', $dados['codigo']);
    $query = $this->db->get('produtos', 1);
    if(!$query->num_rows()==1){
      $dados_produto = array(
        'nome' => $dados['nome'],
        'codigo' => $dados['codigo'],
        'fabricante' => $dados['fabricante'],
        'tipo' => $dados['tipo']
      );
      $this->db->insert('produtos', $dados_produto);
      if(array_key_exists('grupos', $dados)){
        foreach ($dados['grupos'] as $grupo_id) {
          $this->db->where('id', $grupo_id);
          $grupo = $this->db->get('grupos', 1);

          $this->db->where('codigo', $dados['codigo']);
          $produto = $this->db->get('produtos', 1);

          $this->db->where('produtos', ((array)$produto->result()[0])['id']);
          $this->db->where('grupos', ((array)$grupo->result()[0])['id']);
          $query = $this->db->get('produtosxgrupos', 1);

          if(!$query->num_rows()==1){
            print_r("4");
            $dados_produtoxgrupos = array(
                                          'produtos' => ((array)$produto->result()[0])['id'],
                                          'grupos'  => ((array)$grupo->result()[0])['id']
                                        );
            $this->db->insert('produtosxgrupos', $dados_produtoxgrupos);
        }
      }
      return $this->db->insert_id();
    } else{
      return 0;
    }
  }
}

  public function ler($data){
    if($data == NULL){
      // retorna todos os valores da table
      $query = $this->db->get('produtos');
      return $query->result();
    }
  }

}
