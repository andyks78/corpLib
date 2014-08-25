<?php
/* @var $this BookAuthorController */
/* @var $model BookAuthor */

$this->breadcrumbs=array(
	'Book Authors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BookAuthor', 'url'=>array('index')),
	array('label'=>'Create BookAuthor', 'url'=>array('create')),
	array('label'=>'View BookAuthor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BookAuthor', 'url'=>array('admin')),
);
?>

<h1>Update BookAuthor <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>