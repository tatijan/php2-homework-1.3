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
            text-align: center;
        }
        .head_test {
            font-size: 19px;
            font-weight: bold;
            margin: 0;
            margin-bottom: 15px;
        }
    </style>
    <title>Режим въезда</title>
</head>
<body>

<form method="post">
    <fieldset>
        <p class="head_test">Режим въезда с общегражданским паспортом</p>

        <input type="text" name="country">
        <input type="submit" value="Узнать" />
</form>

<?php
ini_set('display_errors', 'Off');
if ($fp = fopen("https://data.gov.ru/opendata/7704206201-country/data-20180609T0649-structure-20180609T0649.csv?encoding=UTF-8", "r") or $fp = fopen("https://raw.githubusercontent.com/netology-code/php-2-homeworks/master/files/countries/opendata.csv", "r")) {
    while ($data = fgetcsv($fp, 0, ",")):
        $list[] = $data;
    endwhile;
    fclose($fp);
} else {
    ?>
    <p>Сервис временно недоступен</p>
    <?php
    break;
}
foreach ($list as $key => $value) {
    $column1[] = $value[1];
    $column4[] = $value[4];
}
$registry = array_combine($column1, $column4);
if (empty($_POST['country'])) {
    echo '<br><br>Введите название страны, например - Япония';
}
$country = $_POST['country'];
if (isset($_POST['country']) && array_key_exists($country, $registry) == false) {
    echo '<br><br>Введите правильное название';
} else {
    foreach ($registry as $land => $mode) {
        if ($land == $country) {
            ?> <p><?=$land?> - <?=$mode?></p>
            <?php

        }
    }
}
?>
</body>
</html>