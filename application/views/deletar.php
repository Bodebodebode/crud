<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php  $this->load->view('header'); ?>
<div id="container">
  <h1 id="page_title"><?php echo $titulo; ?></h1>
		<nav id="nav_bar" class="nav_bar" style="display : inline-block">
      <a class="nav_bar" href="criar"><p>Create</p></a>
      <a class="nav_bar" href="ler"><p>Read</p></a>
      <a class="nav_bar" href="atualizar"><p>Update</p></a>
      <a class="nav_bar" href="deletar"><p>Delete</p></a>
</nav>
<h2 class="subtitulo"><?php echo $subtitulo; ?></h2>
</div>

<?php $this->load->view('footer'); ?>
