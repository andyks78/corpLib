<?php

class ReaderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

        /*
         * выдача книги
         * сохраняет связь читателя с книгой
         */
        public function actionAddBook(){

            $response = array('status'=>true);
            $readerID = Yii::app()->request->getParam('reader');
            $bookID = Yii::app()->request->getParam('book');

            if (($bookID === null) || ($readerID === null)){
                $response['status'] = false;
                $response['errors'] = array('book or reader empty');
            }
            else{
                $b2r = new BookReader();
                $b2r->book = $bookID;
                $b2r->reader = $readerID;
                if ($b2r->save()){
                    $response['text'] = $this->renderPartial('_booksReaderView', array('data'=>$b2r), true);
                }
                else{
                    $response['errors'] = array('error add book on reader');
                }
            }
            echo CJSON::encode($response);
        }

        public function actionReturnBook(){
            $response = array('status'=>false);
            $id = Yii::app()->request->getParam('id');
            if ($id !== null){
                $model = BookReader::model()->findByPk($id);
                if ($model !== null){
                    if ($model->delete()){
                        $response['status'] = true;
                    }
                    else{
                        $response['errors'] = array('book not returned');
                    }
                }
                else{
                    $response['errors'] = array('book not found for return');
                }
            }
            else{
                $response['errors'] = array('params not found');
            }
            echo CJSON::encode($response);
        }
	/**
	 * Получает списко книг для выдачи читателю
	 * + наверно одну и туже книзу нельзя выдать двум сразу? ;))
         * так что код читателя можно не получать ..
	 */
	public function actionGetFreeBooks()
	{
            $response = array('status'=>true);



            // в запросе если юзать NOT IN мускул тормозит ..
            // выберем отдельно ИД выданных книг .. будет быстрее
            $b2rList = BookReader::model()->findAll();
            $b2rArr = array();
            foreach ($b2rList as $b2r){
                $b2rArr[] = $b2r->book;
            }

            $cr = new CDbCriteria();
            $cr->addNotInCondition('id', $b2rArr);

            $bookList = Book::model()->findAll($cr);
            if (count($bookList) > 0){
                $response['text'] = CHtml::dropDownList('book', null, CHtml::listData($bookList, 'id', 'name'));
            }
            else{
                $response['status'] = false;
                $response['errors'] = array('book ended');
            }
            echo CJSON::encode($response);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Reader;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reader']))
		{
			$model->attributes=$_POST['Reader'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reader']))
		{
			$model->attributes=$_POST['Reader'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Reader');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Reader('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reader'])){
                    $model->attributes=$_GET['Reader'];
                    $this->proceesDates($model);
                }

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Reader the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Reader::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Reader $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reader-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
