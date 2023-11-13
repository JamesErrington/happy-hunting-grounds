<?php
require 'session.php';

class Home extends Handler {
    function show($f3) {
        $f3->set('page', 'main.html');

        QuizSession::init_if_null();

        echo $this->render('layout.html');
    }

    function select_question($f3) {
        echo $this->render('partials/question-select.html');
    }

    function select_difficulty($f3) {
        $result = $this->db->exec('SELECT id, score, ground, team FROM Question WHERE score = ? ORDER BY RANDOM() LIMIT 1;', $_POST['score']);
        // @TODO: handle error?
        $f3->set('SESSION.question', $result[0]);

        echo $this->render('partials/question-body.html');
    }

    function search_player($f3) {
        $result = array();
        if (strlen($_POST['player']) != 0) {
            $result = $this->db->exec('SELECT player FROM Answer WHERE player LIKE ? LIMIT 10;', '%'.$_POST['player'].'%');
        }
        $f3->set('player_search_result', $result);

        echo $this->render('partials/player-search.html');
    }

    function answer($f3) {
        $params = array($_POST['id'], $_POST['player'], $_POST['season']);
        $result = $this->db->exec('SELECT EXISTS(SELECT 1 FROM Answer WHERE question_id = ? AND player = ? AND SEASON = ?) AS correct;', $params);
        $correct = $result[0]['correct'] == 1;
        $f3->set('correct', $correct);

        if ($correct) {
            $f3->set('SESSION.current_score', $f3->get('SESSION.current_score') + $f3->get('SESSION.question')['score']);
        }

        $answered = $f3->get('SESSION.answered_questions');
        $f3->set('SESSION.answered_questions', $answered + 1);
        if ($answered + 1 >= $f3->max_questions) {
            $f3->set('SESSION.answered_questions', 0);
            if ($f3->get('SESSION.current_score') > $f3->get('SESSION.best_score')) {
                $f3->set('SESSION.best_score', $f3->get('SESSION.current_score'));
            }
            $f3->set('SESSION.current_score', 0);
            return;
        }


        echo $this->render('partials/answer.html');
    }
}
?>
