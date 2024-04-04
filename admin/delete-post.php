<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch post from database in order to delete thumbnail from images folder
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connectiion, $query);

    // make sure only 1 record/post was fetched
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../images/' . $thumbnail_name;

        if (file_exists($thumbnail_path)) {
            // Exclui a miniatura se ela existir
            unlink($thumbnail_path);

            // delete post from database
            $delete_post_query = "DELETE FROM posts WHERE id=$id LIMIT 1";
            $delete_post_result = mysqli_query($connectiion, $delete_post_query);

            if (!mysqli_errno($connectiion)) {
                $_SESSION['delete-post-success'] = "Post deleted successfully";
            }
        } else {
            // Se a miniatura não existir, apenas exclua o post do banco de dados
            $delete_post_query = "DELETE FROM posts WHERE id=$id LIMIT 1";
            $delete_post_result = mysqli_query($connectiion, $delete_post_query);

            if (!mysqli_errno($connectiion)) {
                $_SESSION['delete-post-success'] = "Post deleted successfully";
            }
        }
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();
