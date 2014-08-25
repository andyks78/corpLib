<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'book-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <br />

    <h2>Authors</h2>
    <table id="authorTable">
        <tr></tr>
        <?php
        foreach ($model->bookAuthors as $ba) :
            $this->renderPartial('bookAuthorView', array('bookAuthor'=>$ba));
        endforeach;
        ?>
    </table>
    <a id="addAuthor" href="javascript:void(0)">Add author</a>
    <br /><br />

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php

Yii::app()->clientScript->registerCoreScript('jquery');
?>

<script>
    $('#addAuthor').live('click', function(){

        var selProp = [];
        $('#authorTable').find('input:hidden').each(function(){
            selProp.push($(this).val());
        });

        $('#authorTable').find('select').each(function(){
            selProp.push( $('option:selected', this).val());
            $(this).attr("disabled","disabled");
        });

        $.ajax({
                type: "POST",
                url: "<?= Yii::app()->createurl('book/getAuthors') ?>",
                data : {aids : selProp.join(',')},
                dataType : 'json',
                success: function(response){
                    if (response.status === true){
                        $("#authorTable tr:last").after(response.text)
                    } else{
                        $.each(response.errors, function (k,v) {
                            alert('error :'+v.toString());
                        });
                    }
                },
                error: function(){
                    alert('server error');
                    return false;
                }
            });
    });
</script>