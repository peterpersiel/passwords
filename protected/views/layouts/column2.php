<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-18">
		<div id="content">
                <div>
                <?php
                    $flashMessages = Yii::app()->user->getFlashes();
                    if ($flashMessages) {
                        foreach($flashMessages as $key => $message) {
                            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                        }
                    }
                ?>
                </div>

			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-6 last">
		<div id="sidebar">
			<?php $this->widget('zii.widgets.CMenu',array( 'items' => $this->menu)); ?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>