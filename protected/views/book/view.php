<?php
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs=array(
	'Books'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Book', 'url'=>array('index')),
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'Update Book', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Book', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Book', 'url'=>array('admin')),
);
?>

<h1>View Book #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'date_create',
		'date_edit',
	),
)); ?>

<?php if (isset($model->bookReader->reader0->id)) : ?>
<h2>Current reader</h2>
<?php
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->bookReader->reader0,
	'attributes'=>array(
		'id',
		'name',
		'date_create',
		'date_edit',
	),
));

else:
?>
<h2>Book in library</h2>
<?php endif; ?>

<h2>Authors</h2>
<?php
$authorDP = new CArrayDataProvider($model->bookAuthors, array());
    $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$authorDP,
	'itemView'=>'/bookAuthor/_viewAuthors',
    ));
?>