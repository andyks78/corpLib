<?php
/* @var $this ReaderController */
/* @var $model Reader */

$this->breadcrumbs=array(
	'Readers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Reader', 'url'=>array('index')),
	array('label'=>'Create Reader', 'url'=>array('create')),
	array('label'=>'Update Reader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Reader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Reader', 'url'=>array('admin')),
);
?>

<h1>View Reader #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'date_create',
		'date_edit',
	),
)); ?>

<br />
<a id="addBook2authorLink" href="javascript:void(0)">add book</a>
<br />
<br />

<div class="form" id="addBook2reader" style="display:none">

<?php
    $form=$this->beginWidget('CActiveForm', array(
            'id'=>'reader2book-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
    ));

    echo CHtml::hiddenField('reader', $model->id);
?>

	<div class="row">
		<?php echo $form->labelEx(Book::model(),'name'); ?>
            <div id="selectBooks">
		<?php echo CHtml::dropDownList('authorList', null, array()) ?>
            </div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id'=>'addBooktoReaderBtn')); ?>
	</div>
<?php $this->endWidget(); ?>
</div>

<h2>Book this reader</h2>
<?php
$bookDP = new CArrayDataProvider($model->bookReaders);
    $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$bookDP,
	'itemView'=>'_booksReaderView',
        'htmlOptions'=>array('id'=>'readerBooksList'),
    ));
?>


<script>
    function returnBook(id, linkObj){
        $.ajax({
                type: "POST",
                url: "<?= Yii::app()->createurl('reader/returnBook') ?>",
                data: {id:id},
                dataType : 'json',
                success: function(response){
                    if (response.status === true){
                        $(linkObj).parent().remove();
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
    }

    $('#addBooktoReaderBtn').live('click', function(){
        var form = $('#reader2book-form');
        $.ajax({
                type: "POST",
                url: "<?= Yii::app()->createurl('reader/addBook') ?>",
                data: form.serialize(),
                dataType : 'json',
                success: function(response){
                    if (response.status === true){
                        $("#readerBooksList").prepend(response.text)
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

        $('#addBook2reader').hide();
        return false;
    });

    $('#addBook2authorLink').live('click', function (){

        $.ajax({
                type: "POST",
                url: "<?= Yii::app()->createurl('reader/getFreeBooks') ?>",
                dataType : 'json',
                success: function(response){
                    if (response.status === true){
                        $("#selectBooks").html(response.text);
                        $('#addBook2reader').show();
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