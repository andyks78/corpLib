<?php
/* @var $this BookAuthorController */
/* @var $model BookAuthor */

$this->breadcrumbs=array(
	'Book Authors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BookAuthor', 'url'=>array('index')),
	array('label'=>'Manage BookAuthor', 'url'=>array('admin')),
);
?>

<h1>Create BookAuthor</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>