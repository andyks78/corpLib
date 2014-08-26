<h1><?= $title ?></h1>
<?php
    $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dp,
	'itemView'=>'_reportItemView',
    ));
?>
