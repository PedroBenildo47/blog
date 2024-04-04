<?php
require 'config/database.php';

// Verifica se o botão de edição de post foi clicado
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0; // Se estiver marcado, atribui 1, caso contrário, atribui 0
    $thumbnail = $_FILES['thumbnail'];

    // Verifica e valida os valores de entrada
    if (!$title || !$category_id || !$body) {
        $_SESSION['edit-post'] = "Couldn't update post, invalid form data on edit post page.";
    } else {
        // Exclui a miniatura anterior se uma nova miniatura estiver disponível
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if (file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }

            // Trabalha na nova miniatura
            // Renomeia a imagem
            $time = time();  // torna cada nome de imagem único usando o timestamp atual
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // Verifica se o arquivo é uma imagem
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail['name']);
            $extension = end($extension);
            if (in_array($extension, $allowed_files)) {
                // Verifica se a miniatura não é muito grande (maior que 2 MB)
                if ($thumbnail['size'] < 2000000) {
                    // Faz o upload da miniatura
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Couldn't update post. Thumbnail size too big. Should be less than 2MB.";
                }
            } else {
                $_SESSION['edit-post'] = "Couldn't update post. Thumbnail should be PNG, JPG, or JPEG.";
            }
        }
    }

    if ($_SESSION['edit-post']) {
        // Redireciona para a página de gerenciamento de formulários se o formulário for inválido
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // Define is_featured de todos os posts como 0 se is_featured para este post for 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connectiion, $zero_all_is_featured_query);
        }

        // Define o nome da miniatura se uma nova for enviada, senão mantém o nome da miniatura antiga
        $thumbnail_to_insert = isset($thumbnail_name) ? $thumbnail_name : $previous_thumbnail_name;

        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connectiion, $query);
    }

    if (!mysqli_errno($connectiion)) {
        $_SESSION['edit-post-success'] = "Post updated successfully.";
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();
