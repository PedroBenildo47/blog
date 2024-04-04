<?php
require 'config/database.php';

if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  // ATUALIZAR CATEGORIAS DOS POSTS RELACIONADOS ANTES DE EXCLUIR A CATEGORIA
  // Atualiza o category_id dos posts que pertencem a esta categoria para o id da categoria "Não Categorizado" (por exemplo, 5)
  $update_query = "UPDATE posts SET category_id = 5 WHERE category_id = $id";
  $update_result = mysqli_query($connectiion, $update_query); // Corrigido o nome da variável "$connection" e a tabela "posts"

  if (!mysqli_errno($connectiion)) { // Corrigido o nome da variável "$connection"
    // Exclui a categoria
    $query = "DELETE FROM categories WHERE id = $id LIMIT 1";
    $result = mysqli_query($connectiion, $query); // Corrigido o nome da variável "$connection"

    if ($result) {
      $_SESSION['delete-category-success'] = "Category deleted successfully";
    } else {
      $_SESSION['delete-category-error'] = "Failed to delete category"; // Mensagem de erro caso haja falha na exclusão
    }
  } else {
    $_SESSION['delete-category-error'] = "Failed to update posts"; // Mensagem de erro caso haja falha na atualização
  }
}

header('location: ' . ROOT_URL . 'admin/manage-category.php');
die();
