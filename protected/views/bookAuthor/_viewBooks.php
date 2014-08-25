<div class="view">

	<b><?php echo CHtml::encode($data->book0->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->book0->id), Yii::app()->createUrl('book/view', array('id'=>$data->book0->id))); ?>
	<br />


	<b><?php echo CHtml::encode($data->book0->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->book0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->book0->getAttributeLabel('date_create')); ?>:</b>
	<?php echo CHtml::encode($data->book0->date_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->book0->getAttributeLabel('date_edit')); ?>:</b>
	<?php echo CHtml::encode($data->book0->date_edit); ?>
	<br />
</div>