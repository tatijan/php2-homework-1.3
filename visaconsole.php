<?php
if (!isset($argv['1'])) {
    $notice1= 'Введите название страны: все слова пишите с большой буквы';
    $notice1=iconv('utf-8', 'windows-1251', $notice1);
    exit($notice1);
}
ini_set('display_errors', 'Off');
if ($fp = fopen("https://data.gov.ru/opendata/7704206201-country/data-20180609T0649-structure-20180609T0649.csv?encoding=UTF-8", "r") or $fp = fopen("https://raw.githubusercontent.com/netology-code/php-2-homeworks/master/files/countries/opendata.csv", "r")) {
    while ($data = fgetcsv($fp, 0, ",")):
        $list[] = $data;
    endwhile;
    fclose($fp);
} else {
    $notice2= 'Сервис временно недоступен';
    $notice2=iconv('utf-8', 'windows-1251', $notice2);
    exit($notice2);
}
foreach ($list as $key => $value) {
    $column1[] = $value[1];
    $column4[] = $value[4];
}
$registry = array_combine($column1, $column4);
$country = array_slice($argv, 1);
$country=implode(' ', $country);
// Кодировка у меня в консоли 1251
$country = iconv('windows-1251', 'utf-8', $country);
if (isset($country) && array_key_exists($country, $registry) == false) {
    $notice3= 'Введите правильное название';
    $notice3=iconv('utf-8', 'windows-1251', $notice3);
    echo $notice3;

} else {
    foreach ($registry as $land => $mode) {
        if ($land == $country) {
            echo iconv('utf-8', 'windows-1251', $land) . ' - ' . iconv('utf-8', 'windows-1251', $mode);
        }
    }
}