<?php
class QuizSession {
    public static function init_if_null() {
        $f3 = \Base::instance();

        if ($f3->get('SESSION.answered_questions') == null) {
            $f3->set('SESSION.answered_questions', 0);
        }

        if ($f3->get('SESSION.best_score') == null) {
            $f3->set('SESSION.best_score', 0);
        }

        if ($f3->get('SESSION.current_score') == null) {
            $f3->set('SESSION.current_score', 0);
        }
    }

    public static function set_question() {
        $f3 = \Base::instance();

        $f3->set('SESSION.question', $result[0]);
    }
}
?>
