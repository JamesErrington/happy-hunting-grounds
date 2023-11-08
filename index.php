<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();

$f3->config('config.ini');

$f3->route('GET /', function($f3) {
    $f3->set('page', "main.html");
    echo \Template::instance()->render('layout.html');
});

$f3->route('POST /clicked', function($f3) {
    echo \Template::instance()->render("clicked.html");
});
$f3->run();
?>
