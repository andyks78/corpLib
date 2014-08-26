<?php
/* @var $this ReaderController */
/* @var $model Reader */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_create'); ?>
		<?php
                    //echo $form->dateField($model,'date_create');
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name'=>'date_create',  // name of post parameter
                        'value'=>Yii::app()->request->getParam('Author[\'date_create\']'),  // value comes from cookie after submittion
                         'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat'=>'yy-mm-dd',
                        ),
                    ));
                ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_edit'); ?>
		<?php
                    //echo $form->textField($model,'date_edit');
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name'=>'date_edit',  // name of post parameter
                        'value'=>Yii::app()->request->getParam('Author[\'date_edit\']'),  // value comes from cookie after submittion
                         'options'=>array(
                            'showAnim'=>'fold',
                            'dateFormat'=>'yy-mm-dd',
                        ),
                    ));
                ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->