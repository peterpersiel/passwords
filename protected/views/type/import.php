<?php

$this->breadcrumbs = array(
    'Types' => array('index'),
    Yii::t('app', 'Import'),
);

$this->menu = array(
    array('label'=>Yii::t('app', 'List Types'), 'url' => array('index')),
    array('label'=>Yii::t('app', 'Manage Types'), 'url' => array('admin'))
);
?>

<h1>Import Types</h1>
<pre><?php echo htmlentities($xml); ?></pre>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
     'method' => 'post',
     'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    )
)); ?>


    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>

     <?php echo CHtml::errorSummary($model); ?>


        <div class="row">
                <?php echo $form->labelEx($model,'xml'); ?>
                <?php echo $form->fileField($model, 'xml'); ?>
                <?php echo $form->error($model,'xml'); ?>
        </div>
        <!-- row -->


<?php echo CHtml::submitButton(Yii::t('app', 'Import')); ?>
<?php $this->endWidget(); ?>


</div><!-- form -->