<h1>Random 5 books</h1>
<?php
    $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->reportRandom5(),
	'itemView'=>'_random5',
    ));
?>
