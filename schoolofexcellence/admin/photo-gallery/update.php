<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $text = $_POST['text'];


    $data = file_exists('data.json') ? json_decode(file_get_contents('data.json'), true) : [];

    if (isset($data[$index])) {
        $data[$index]['title'] = $title;
        $data[$index]['name'] = $name;
        $data[$index]['date'] = $date;
        $data[$index]['text'] = $text;
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}
header('Location: index.php');


