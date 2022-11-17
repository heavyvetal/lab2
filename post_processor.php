<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $posts = json_decode(file_get_contents('db.json'), true);
    } catch (Exception $e){
        echo $e->getMessage();
        exit;
    }

    if (isset($_POST['text'])) {
        $text = $_POST['text'];

        foreach ($posts as &$post) {
            if ($post['id'] == $id) {
                $post['content'] = $text;
            }
        }

        $postsJSON = json_encode($posts);

        $response = 'The post was succefully saved';
    }

    if (isset($_POST['del'])) {
        foreach ($posts as &$post) {
            if ($post['id'] == $id) {
                unset($posts[$id]);
            }
        }

        $postsJSON = json_encode($posts);

        $response = 'The post was succefully removed';
    }

    try {
        file_put_contents('db.json', $postsJSON);
    } catch (Exception $e){
        $response = $e->getMessage();
    }

    echo $response;
}