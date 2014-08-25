<?php
/* @var $this BookAuthorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Book Authors',
);

$this->menu=array(
	array('label'=>'Create BookAuthor', 'url'=>array('create')),
	array('label'=>'Manage BookAuthor', 'url'=>array('admin')),
);
?>

<h1>Book Authors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
