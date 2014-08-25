<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->breadcrumbs=array(
	'Authors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Author', 'url'=>array('index')),
	array('label'=>'Create Author', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#author-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Authors</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'author-grid',
	'dataProvider'=>$model->searchAdmin(),
	'filter'=>$model,
        'afterAjaxUpdate' => 'reinstallDatePicker',
	'columns'=>array(
		'id',
		'name',
		array(
                    'name'=>'date_create',
                    'filter'=>
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'=>$model,
                            'attribute'=>'date_create',
                            'language' => 'en',
                            'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
                            'htmlOptions' => array(
                                'id' => 'datepicker_for_date_create',
                                'size' => '10',
                            ),
                            'defaultOptions' => array(  // (#3)
                                'showOn' => 'focus',
                                'dateFormat' => 'yy-mm-dd',
                                'showOtherMonths' => true,
                                'selectOtherMonths' => true,
                                'changeMonth' => true,
                                'changeYear' => true,
                                'showButtonPanel' => true,
                            )
                        ),
                        true
                      ),
                ),
		array(
                    'name'=>'date_edit',
                    'filter'=>
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'=>$model,
                            'attribute'=>'date_edit',
                            'language' => 'en',
                            'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
                            'htmlOptions' => array(
                                'id' => 'datepicker_for_date_edit',
                                'size' => '10',
                            ),
                            'defaultOptions' => array(  // (#3)
                                'showOn' => 'focus',
                                'dateFormat' => 'yy-mm-dd',
                                'showOtherMonths' => true,
                                'selectOtherMonths' => true,
                                'changeMonth' => true,
                                'changeYear' => true,
                                'showButtonPanel' => true,
                            )
                        ),
                        true
                      ),
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
));

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_date_create, #datepicker_for_date_edit').datepicker();
}
");
?>

