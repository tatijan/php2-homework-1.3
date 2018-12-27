<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            padding: 30px;
        }
        fieldset {
            width: 400px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .head_test {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            margin-bottom: 15px;
        }
        .list {
            margin: 40px 0;
        }
        .list p {
            margin: 0;
        }
    </style>
    <title>Поиск книг</title>
</head>
<body>

<form method="post">
    <fieldset>
        <p class="head_test">Поиск книг по ключевой фразе</p>

        <p><input type="text" name="search" placeholder="Введите запрос"></p>
        <p><input type="submit" value="Искать"></p>
    </fieldset>
</form>
<?php
if (empty($_POST['search'])) {
    echo "Введите данные в форму";

} else {
    $search = $_POST['search'];
    $search = trim($search);
    $search = stripslashes($search);
    $search = strip_tags($search);
    $search = htmlspecialchars($search);

    $search = urlencode($_POST['search']);


    $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $search;

    $a       = file_get_contents($url);
    $json_de = json_decode($a, true);

    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - Ошибок нет';
            break;
        case JSON_ERROR_DEPTH:
            echo ' - Достигнута максимальная глубина стека';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Некорректные разряды или несоответствие режимов';
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Некорректный управляющий символ';
            break;
        case JSON_ERROR_SYNTAX:
            echo ' - Синтаксическая ошибка, некорректный JSON';
            break;
        case JSON_ERROR_UTF8:
            echo ' - Некорректные символы UTF-8, возможно неверно закодирован';
            break;
        default:
            echo ' - Неизвестная ошибка';
            break;
    }

    echo PHP_EOL;
    echo '<br><br>';

    ini_set('display_errors','Off');
    foreach ($json_de as $value) {
        if (is_array($value)) {
            $a = $value;
        }
    }
    for ($i = 0; $i < count($a); $i++) {
        $b[$i][] = $a[$i]['id'];
        $b[$i][] = $a[$i]['volumeInfo']['title'];
        $b[$i][] = $a[$i]['volumeInfo']['authors'][0];
    }
    $fo = fopen('books.csv', "wb");

    foreach ($b as $value) {
        $fpc = fputcsv($fo, $value);
    }

    $fp = fopen('books.csv', "r");
    while ($data = fgetcsv($fp, 0, ",")) {
        $list[] = $data;
    }
    ?>
    <p class="head_test">Список найденных книг:</p>

    <?php
    foreach ($list as $value) {
        ?>
        <div class="list">
            <p>id: <?= $value[0] ?></p>
            <p>название: <?= $value[1] ?></p>
            <p>автор: <?= $value[2] ?></p>
        </div>
        <?php
    }

}
?>
</body>
</html><?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 27.12.2018
 * Time: 20:52
 */