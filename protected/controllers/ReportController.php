<?php

/**
 * Отчеты
 *
 * @author qwerty
 */
class ReportController extends Controller{

    public function actionRandomBook5(){

        $model = new Book;

        $this->render('report', array('dp'=>$model->reportRandom5(), 'title'=>'Random 5 books.'));
    }

    public function actionBooks3authors(){
        $model = new Book;
        $this->render('report', array('dp'=>$model->report3Authors(), 'title'=>'Lists the books in in the hands readers, and having at least three co-authors.'));
    }

    public function actionAuthors3readers(){
        $model = new Author;
        $this->render('report', array('dp'=>$model->report3Readers(), 'title'=>'List of authors whose books are currently reading more than three readers'));

    }
}

?>
