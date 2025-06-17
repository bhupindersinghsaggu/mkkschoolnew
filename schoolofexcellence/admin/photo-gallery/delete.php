<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $data = file_exists('data.json') ? json_decode(file_get_contents('data.json'), true) : [];

    if (isset($data[$index])) {
        $file = 'uploads/' . $data[$index]['filename'];
        if (file_exists($file)) unlink($file);

        array_splice($data, $index, 1);
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}
header('Location: index.php');
