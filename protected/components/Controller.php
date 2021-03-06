<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

        public function proceesDates($model){
            $dc = Yii::app()->request->getParam('date_create');
            if (($dc !== null) && (trim($dc) > 0)){
                $model->date_create = $dc;
            }
            unset($dc);

            $de = Yii::app()->request->getParam('date_edit');
            if (($de !== null) && (trim($de) > 0)){
                $model->date_edit = $de;
            }
            unset($de);
            //return $model;
        }
}