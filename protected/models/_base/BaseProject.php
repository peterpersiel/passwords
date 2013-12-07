<?php

/**
 * This is the model base class for the table "{{project}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Project".
 *
 * Columns in table "{{project}}" available as properties of the model,
 * followed by relations of table "{{project}}" available as properties of the model.
 *
 * @property string $id
 * @property string $name
 * @property string $client_id
 *
 * @property Password[] $passwords
 * @property Client $client
 */
abstract class BaseProject extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{project}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Project|Projects', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, client_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('client_id', 'length', 'max'=>10),
			array('id, name, client_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'passwords' => array(self::HAS_MANY, 'Password', 'project_id'),
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'client_id' => null,
			'passwords' => null,
			'client' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('client_id', $this->client_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}