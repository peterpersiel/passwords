<?php

$this->breadcrumbs = array(
	Client::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . Client::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . Client::label(2), 'url' => array('admin')),
    array('label'=>Yii::t('app', 'Import') . ' ' . Client::label(2), 'url' => array('import')),
    array('label'=>Yii::t('app', 'Export') . ' ' . Client::label(2), 'url' => array('export'))
);
?>

<h1><?php echo GxHtml::encode(Client::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));