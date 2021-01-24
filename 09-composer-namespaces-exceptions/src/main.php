<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
function program() {
    $inputSource = new CsvTestInputSource("files/file.csv");
    $test = $inputSource->getTestInput();
    while ($test !== null){
        echo $test->widgetName;
        print_r($test->queryParams);
        $test = $inputSource->getTestInput();
    }
}