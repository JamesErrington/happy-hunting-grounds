<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();

$f3->config('config.ini');

$f3->set('DB', new DB\SQL('sqlite:'.__DIR__.$f3->get('db_path')));

$f3->set('scores', $f3->get('DB')->exec('SELECT DISTINCT score FROM Question;'));
$f3->set('seasons', $f3->get('DB')->exec('SELECT DISTINCT season FROM Answer ORDER BY season ASC;'));

$f3->route('GET /', function($f3) {
    new \Session();
    // @TODO: handle session restart properly
    $f3->set('SESSION.answered_questions', 0);
    $f3->set('SESSION.answered_correct', 0);

    $f3->set('page', "main.html");

    echo render('layout.html');
});

$f3->route('GET /question-select', function($f3) {
    new \Session();

    echo render('question-select.html');
});

$f3->route('GET /question-body', function($f3) {
    $f3->scrub($_GET);
    $db = $f3->get('DB');

    $result = $db->exec('SELECT id, score, ground, team FROM Question WHERE score = ? ORDER BY RANDOM() LIMIT 1;', $_GET['score']);
    $f3->set('question', $result[0]);

    echo render('question-body.html');
});

$f3->route('POST /answer', function($f3) {
    $f3->scrub($_POST);
    $db = $f3->get('DB');
    new \Session();

    $f3->set('SESSION.answered_questions', $f3->get('SESSION.answered_questions') + 1);
    $params = array($_POST['id'], $_POST['player'], $_POST['season']);
    $result = $db->exec('SELECT EXISTS(SELECT 1 FROM Answer WHERE question_id = ? AND player = ? AND SEASON = ?) AS correct;', $params);
    $f3->set('correct', $result[0]['correct'] == 1);

    if ($f3->get('correct')) {
        $f3->set('SESSION.answered_correct', $f3->get('SESSION.answered_correct') + 1);
    }

    echo render('answer.html');
});

$f3->route('POST /player-search', function($f3) {
    $f3->scrub($_POST);
    $db = $f3->get('DB');

    $result = array();
    if (strlen($_POST['player']) != 0) {
        $result = $db->exec('SELECT player FROM Answer WHERE player LIKE ? LIMIT 10;', '%'.$_POST['player'].'%');
    }
    $f3->set('player_search_result', $result);

    echo render('player-search.html');
});



$f3->run();

function render($path) {
    return \Template::instance()->render($path);
}
?>
