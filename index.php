<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();

$f3->config('config.ini');

$f3->set('DB', new DB\SQL('sqlite:'.__DIR__.$f3->get('db_path')));

$f3->set('scores', $f3->get('DB')->exec('SELECT DISTINCT score FROM Question;'));

$f3->route('GET /', function($f3) {
    $f3->set('page', "main.html");

    echo \Template::instance()->render('layout.html');
});

$f3->route('GET /question', function($f3) {
    $params = array();
    parse_str($f3->get('QUERY'), $params);
    $f3->set('question', $f3->get('DB')->exec('SELECT score, ground, team FROM Question WHERE score = ? ORDER BY RANDOM() LIMIT 1;', $params['score'])[0]);

    echo \Template::instance()->render('question.html');
});

$f3->route('POST /search', function($f3) {
    $search = $_POST['search'];
    $f3->set('players', $f3->get('DB')->exec('SELECT player FROM Answer WHERE player LIKE ?;', $search.'%'));

    echo \Template::instance()->render('player_search.html');
});
$f3->run();
?>
