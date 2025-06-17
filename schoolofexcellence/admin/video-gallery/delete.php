<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = intval($_POST['index']);
    $dataFile = 'data.json';

    if (file_exists($dataFile)) {
        $data = json_decode(file_get_contents($dataFile), true);
        if (isset($data[$index])) {
            array_splice($data, $index, 1); // remove the item
            file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        }
    }
}
header('Location: index.php');