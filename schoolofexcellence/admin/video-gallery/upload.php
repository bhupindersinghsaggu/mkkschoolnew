<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = isset($_POST['index']) && $_POST['index'] !== '' ? (int) $_POST['index'] : null;
    $title = $_POST['title'];
    $name = $_POST['name'];
    $date = $_POST['date'];

    $youtubeLink = $_POST['youtube'];

    parse_str(parse_url($youtubeLink, PHP_URL_QUERY), $params);
    $videoId = $params['v'] ?? '';

    if ($videoId) {
        $thumbnail = "https://img.youtube.com/vi/$videoId/hqdefault.jpg";
        $data = file_exists('data.json') ? json_decode(file_get_contents('data.json'), true) : [];

        $videoData = [
            'title' => $title,
            'name' => $name,
            'date' => $date,
            'youtube_id' => $videoId,
            'thumbnail' => $thumbnail
        ];

        if ($index !== null && isset($data[$index])) {
            $data[$index] = $videoData;
        } else {
            $data[] = $videoData;
        }

        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}
header('Location: index.php');
