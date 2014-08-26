<?php

class BookController extends Controller
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Book;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];
                        $errorText = 'Error save to DB';
                        $transaction=$model->dbConnection->beginTransaction();
                        try {
                            if($model->save()){
                                if (isset($_POST['Book']['Author'])){
                                    foreach ($_POST['Book']['Author'] as $aKey=>$aVal){
                                        // новый автор .. добавим связку
                                        $b2aModel = new BookAuthor();
                                        $b2aModel->book = $model->id;
                                        $b2aModel->author = $aVal;
                                        if (! $b2aModel->save()){
                                            $errorText = 'error add authors to book';
                                            throw new Exception($errorText);
                                        }
                                    }
                                }
                                $transaction->commit();
                                $this->redirect(array('view','id'=>$model->id));
                            }
                            else{
                                throw new Exception('error save book');
                            }
                        }
                        catch (Exception $e){
                            $model->addError('common', $errorText);
                            $transaction->rollback();
                        }
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

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];

                        $errorText = 'Error save to DB';
                        $transaction=$model->dbConnection->beginTransaction();
                        try {
                            if($model->save()){
                                if (isset($_POST['Book']['Author'])){
                                    // соберем ИД связок ... что бы знать что удалять
                                    $removeB2A = array();
                                    foreach ($model->bookAuthors as $b2a){
                                        $removeB2A[$b2a->id] = $b2a->author;
                                    }
                                    foreach ($_POST['Book']['Author'] as $aKey=>$aVal){
                                        if ($aKey > $model::MIN_ID){
                                            // новый автор .. добавим связку
                                            $b2aModel = new BookAuthor();
                                            $b2aModel->book = $model->id;
                                            $b2aModel->author = $aVal;
                                            if (! $b2aModel->save()){
                                                $errorText = 'error add authors to book';
                                                throw new Exception($errorText);
                                            }
                                        }
                                        else{
                                            if (array_key_exists($aKey, $removeB2A)){
                                                unset($removeB2A[$aKey]);
                                            }
                                        }
                                    }
                                    // удалим авторов, которых удалили на клиенте ...
                                    foreach ($removeB2A as $rKey=>$rVal){
                                        if ( ! BookAuthor::model()->deleteByPk($rKey)){
                                            $errorText = 'error remove authors from book';
                                            throw new Exception($errorText);
                                        }
                                    }
                                }
                                $transaction->commit();
                                $this->redirect(array('view','id'=>$model->id));
                            }
                            else{
                                throw new Exception('error save book');
                            }
                        }
                        catch (Exception $e){
                            // записать в лог $e->getMessage();
                            $model->addError('common', $errorText);
                            $transaction->rollback();
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

        /**
         * Получение HTML для выбора автора при редактировании книги
         *
         */
        public function actionGetAuthors(){
            $response = array('status'=>true);

            $cr = new CDbCriteria();
            $authorsStr = Yii::app()->request->getParam('aids');
            $authorsIDS = array();
            if ($authorsStr !== null){
                $authorsIDS = explode(',', $authorsStr);
            }

            $cr->addNotInCondition('id', $authorsIDS);

            $authors = Author::model()->findAll($cr);
            if (count($authors) == 0){
                $response['status'] = false;
                $response['errors'][] = 'authors not found for this book';
            }
            else{
                $response['text'] = $this->renderPartial('bookAuthorView', array('authorList'=>$authors), true, false);
            }
            echo CJSON::encode($response);

        }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            $model = $this->loadModel($id);

                // удаляем из нескольких таблиц - надо удалить ВСЕ ...
                $transaction = $model->dbConnection->beginTransaction();
                try
                {
                    if ($model->delete()){
                        $transaction->commit();
                    }
                    else{
                        throw new CDbException('error delete book');
                    }
                }
                catch (CDbException $e){
                    $transaction->rollback();
                    // не здаем кому попало что конкретнее случилось надо писать в отдельный лог
                    throw new Exception('error delete book');
                }

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Book');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Book('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Book'])){
			$model->attributes=$_GET['Book'];
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
	 * @return Book the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Book::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Book $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='book-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
