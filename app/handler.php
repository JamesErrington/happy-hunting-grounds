<?php
class Handler {
    protected $db;

    function beforeroute($f3) {
        switch ($f3->VERB) {
            case 'GET':
                $f3->scrub($_GET);
                break;
            case 'POST':
                $f3->scrub($_POST);
                break;
        }
    }

    function afterroute($f3) {

    }

    function __construct() {
        $f3 = \Base::instance();
        $this->db = $f3->DB;
        new \DB\SQL\Session(new DB\SQL('sqlite:'.getcwd().$f3->db_path.$f3->aux_db));
    }

    function render($path) {
        return \Template::instance()->render($path);
    }
}
?>
