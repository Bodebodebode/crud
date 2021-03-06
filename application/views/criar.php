<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php  $this->load->view('header'); ?>
<style>
.form {
  display: inline-grid;
}
form{
  display: inline-grid;
}
label{
  margin: 10px;
  position: relative;
  float: left;
}
input, select{
  position: relative;
  float: right;
  margin: 5px;
}

.form_cell{
  display: block
}
</style>
<div id="container">
  <h1 id="page_title"><?php echo $titulo; ?></h1>
		<nav id="nav_bar" class="nav_bar" style="display : inline-block">
      <a class="nav_bar" href="criar"><p>Create</p></a>
      <a class="nav_bar" href="ler"><p>Read</p></a>
      <a class="nav_bar" href="atualizar"><p>Update</p></a>
      <a class="nav_bar" href="deletar"><p>Delete</p></a>
</nav>
<h2 class="subtitulo"><?php echo $subtitulo; ?></h2>
  <div id="container_adicionar">
    <div class="form" id="adicionar_produto">
      <?php
      echo form_open('main/criar_produto');
      echo '<div class="form_cell">';
      echo form_label('Nome do Produto');
      echo form_input('nome', set_value('nome'), array('autofocus' => 'autofocus'));
      echo '</div>';
      echo '<div class="form_cell">';
      echo form_label('Código');
      echo form_input('codigo', set_value('codigo'));
      echo '</div>';
      echo '<div class="form_cell">';
      echo form_label('Fabricante');
      echo form_input('fabricante', set_value('fabricante'));
      echo '</div>';
      echo '<div class="form_cell">';
      echo form_label('Tipo');
      $options_tipo = array (
        'Comprimido'=> 'Comprimido',
        'Cápsula'   => 'Cápsula',
        'Drágea'    => 'Drágea',
        'Solução'   => 'Solução',
        'Suspensão' => 'Suspensão',
        'Xarope'    => 'Xarope',
        'Pílula'    => 'Pílula',
        'Pomada'    => 'Pomada',
        'Creme'     => 'Creme',
        'Aerosol'   => 'Aerosol',
        'Injetável' => 'Injetável',
        'Colírio'   => 'Colírio'
      );
      echo form_dropdown('tipo', $options_tipo);
      echo '</div>';
      echo '<div class="form_cell">';
      echo form_label('Grupos a que pertence');
      if(!(count($grupos))==0){
        $grupos_nomes = array();
        for($i=0; $i<count($grupos); $i++){
          $grupos_nomes[$grupos[$i]->id] = $grupos[$i]->nome;
        }
        echo form_multiselect('grupos[]', $grupos_nomes, $grupos_nomes, array('style' =>'max-height: 15em;; overflow:scroll; '));
      } else{
        echo form_dropdown('grupos', 'nenhum grupo', '' , array('style' => 'color:grey',
        'disabled' => 'disabled'),
      );
      }
      echo '</div>';
      echo '<div class="form_cell">';
      echo form_submit('', 'Enviar');
      echo '</div>';
      echo form_close();
    ?>



    </div>
      <div class="form" id="adicionar_grupo">
        <?php
        echo form_open('main/criar_grupo');
        echo '<div class="form_cell">';
        echo form_label('Nome do Grupo');
        echo form_input('nome', set_value('nome'), array('autofocus' => 'autofocus'));
        echo '</div>';
        echo '<div class="form_cell">';
        echo form_label('Produtos do grupo');
        if(!(count($produtos))==0){
          $produtos_nomes = array();
          for($i=0; $i<count($produtos); $i++){
            $produtos_nomes[$produtos[$i]->codigo] = $produtos[$i]->nome;
          }
          echo form_multiselect('produtos[]', $produtos_nomes, $produtos_nomes, array('style' =>'max-height: 15em;overflow:scroll; '));
        } else{
          echo form_dropdown('grupos', 'nenhum produto', '' , array('style' => 'color:grey',
          'disabled' => 'disabled'),
        );
      }
      echo '</div>';
      echo '<div class="form_cell">';
      echo form_submit('', 'Enviar');
      echo '</div>';
      echo form_close();
    ?>

      </div>
    </div>
  </div>
</div>

<?php $this->load->view('footer'); ?>
