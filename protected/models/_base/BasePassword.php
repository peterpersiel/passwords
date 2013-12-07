<?php

/**
 * This is the model base class for the table "{{password}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Password".
 *
 * Columns in table "{{password}}" available as properties of the model,
 * followed by relations of table "{{password}}" available as properties of the model.
 *
 * @property string $id
 * @property string $password
 * @property string $title
 * @property string $username
 * @property string $type_id
 * @property string $project_id
 *
 * @property Project $project
 * @property Type $type
 */
abstract class BasePassword extends GxActiveRecord {

    const SECRET = 'asdalsdjk12jk23j42j3jl2ljlljalsalssxmxmnwernwenrmwernmwo333%%%';

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{password}}';
	}

    protected function beforeSave() {
        $this->password = base64_encode($this->password . self::SECRET);

        return true;
    }

    protected function afterFind() {
        $this->password = str_replace(self::SECRET, '', base64_decode($this->password));
    }

	public static function label($n = 1) {
		return Yii::t('app', 'Password|Passwords', $n);
	}

	public static function representingColumn() {
		return 'password';
	}

	public function rules() {
		return array(
			array('password, type_id, project_id', 'required'),
			array('title, username', 'length', 'max'=>255),
			array('type_id, project_id', 'length', 'max'=>10),
			array('title, username', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, password, title, username, type_id, project_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
			'type' => array(self::BELONGS_TO, 'Type', 'type_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'password' => Yii::t('app', 'Password'),
			'title' => Yii::t('app', 'Title'),
			'username' => Yii::t('app', 'Username'),
			'type_id' => null,
			'project_id' => null,
			'project' => null,
			'type' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('type_id', $this->type_id);
		$criteria->compare('project_id', $this->project_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}