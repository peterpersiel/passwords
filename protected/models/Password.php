<?php

Yii::import('application.models._base.BasePassword');

class Password extends BasePassword
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}