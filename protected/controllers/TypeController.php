<?php

class TypeController extends Controller {

    public function filters()
    {
        return array(
        'rights',
        );
    }

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Type'),
		));
	}

	public function actionCreate() {
		$model = new Type;

		$this->performAjaxValidation($model, 'type-form');

		if (isset($_POST['Type'])) {
			$model->setAttributes($_POST['Type']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Type');

		$this->performAjaxValidation($model, 'type-form');

		if (isset($_POST['Type'])) {
			$model->setAttributes($_POST['Type']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Type')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Type');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Type('search');
		$model->unsetAttributes();

		if (isset($_GET['Type']))
			$model->setAttributes($_GET['Type']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

    public function actionImport() {
        $model = new ImportForm('type');

        if(isset($_POST['ImportForm'])) {

            $model->attributes=$_POST['ImportForm'];
            $model->xml = CUploadedFile::getInstance($model, 'xml');

            if ($model->validate()) {
                $xml   = simplexml_load_file($model->xml->getTempName());
                $saved = 0;

                foreach ($xml->children() as $node) {
                    $type = new Type;
                    $type->name = $node->name;

                    if ($type->validate() && $type->save()) {
                        $saved++;
                    }

                    //YiiDebug::dump($pw);
                }

                Yii::app()->user->setFlash('success', sprintf("%d Types saved!", $saved));

                $this->redirect(array('type/import'));
            }

        }

        $this->render('import', array(
            'model' => $model,
            'xml'   => file_get_contents('protected/data/type.xml')
        ));

    }

    public function actionExport() {
        $model = new Type();

        $xml = simplexml_load_string('<types></types>');

        foreach ($model->findAll() as $type) {
            $node = $xml->addChild('type');
            $node->addChild('name', $type->name);
        }

        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="type.xml"');

        echo $xml->asXML();

    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Type::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='type-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}