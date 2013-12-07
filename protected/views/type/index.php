<?php

$this->breadcrumbs = array(
	Type::label(2),
	Yii::t('app', 'Index'),
);

$this->menu = array(
	array('label'=>Yii::t('app', 'Create') . ' ' . Type::label(), 'url' => array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . Type::label(2), 'url' => array('admin')),
    array('label'=>Yii::t('app', 'Import') . ' ' . Type::label(2), 'url' => array('import')),
    array('label'=>Yii::t('app', 'Export') . ' ' . Type::label(2), 'url' => array('export'))
);
?>

<h1><?php echo GxHtml::encode(Type::label(2)); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));