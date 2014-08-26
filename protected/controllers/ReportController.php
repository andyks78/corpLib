<?php

/**
 * Отчеты
 *
 * @author qwerty
 */
class ReportController extends Controller{

    public function actionRandomBook5(){

        $model = new Book;

        $this->render('random5', array('model'=>$model));
    }

}

?>
