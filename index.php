<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();

$f3->config('config.ini');

$db = new DB\SQL('sqlite:'.getcwd().$f3->db_path.$f3->app_db);
$f3->set('DB', $db);

$f3->set('scores', $db->exec('SELECT DISTINCT score FROM Question;'));
$f3->set('seasons', $db->exec('SELECT DISTINCT season FROM Answer ORDER BY season ASC;'));

$f3->route('GET /', 'Home->show');
$f3->route('POST /select-question', 'Home->select_question');
$f3->route('POST /select-difficulty', 'Home->select_difficulty');
$f3->route('POST /search-player', 'Home->search_player');
$f3->route('POST /answer', 'Home->answer');

$f3->run();
?>
