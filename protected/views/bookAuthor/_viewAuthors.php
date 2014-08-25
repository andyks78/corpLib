<div class="view">

	<b><?php echo CHtml::encode($data->author0->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->author0->id), Yii::app()->createUrl('author/view', array('id'=>$data->author0->id))); ?>
	<br />


	<b><?php echo CHtml::encode($data->author0->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->author0->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->author0->getAttributeLabel('date_create')); ?>:</b>
	<?php echo CHtml::encode($data->author0->date_create); ?>
	<br />

	<b><?php echo CHtml::encode($data->author0->getAttributeLabel('date_edit')); ?>:</b>
	<?php echo CHtml::encode($data->author0->date_edit); ?>
	<br />

</div>