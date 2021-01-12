<?php
$estiloPagina = 'main.css';
require_once 'header.php';

if(have_posts()){
  ?>
  <main>
    <?php 
    while(have_posts()){
      the_post();
      the_post_thumbnail('post-thumbnail', array('class' => 'imagem-sobre-nos'));
      echo '<div class="conteudo container-alura">';
      the_title('<h2>', '</h2>');
      the_content();
      echo '</div>';
    };
   ?>
  </main>
<?php
};

require_once 'footer.php';