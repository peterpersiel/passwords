<?php

class ClientController extends Controller {


    public function filters()
    {
        return array(
        'rights',
        );
    }

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Client'),
		));
	}

	public function actionCreate() {
		$model = new Client;

		$this->performAjaxValidation($model, 'client-form');

		if (isset($_POST['Client'])) {
			$model->setAttributes($_POST['Client']);

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
		$model = $this->loadModel($id, 'Client');

		$this->performAjaxValidation($model, 'client-form');

		if (isset($_POST['Client'])) {
			$model->setAttributes($_POST['Client']);

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
			$this->loadModel($id, 'Client')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Client');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Client('search');
		$model->unsetAttributes();

		if (isset($_GET['Client']))
			$model->setAttributes($_GET['Client']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

    public function actionImport() {
        $model = new ImportForm('client');

        if(isset($_POST['ImportForm'])) {

            $model->attributes=$_POST['ImportForm'];
            $model->xml = CUploadedFile::getInstance($model, 'xml');

            if ($model->validate()) {
                $xml   = simplexml_load_file($model->xml->getTempName());
                $saved = 0;

                foreach ($xml->children() as $node) {
                    $client = new Client;
                    $client->name = $node->name;

                    if ($client->validate() && $client->save()) {
                        $saved++;
                    }

                    //YiiDebug::dump($pw);
                }

                Yii::app()->user->setFlash('success', sprintf("%d Clients saved!", $saved));

                $this->redirect(array('client/import'));
            }

        }

        $this->render('import', array(
            'model' => $model,
            'xml'   => file_get_contents('protected/data/client.xml')
        ));

    }

    public function actionExport() {
        $model = new Client();

        $xml = simplexml_load_string('<clients></clients>');

        foreach ($model->findAll() as $client) {
            $node = $xml->addChild('client');
            $node->addChild('name', $client->name);
        }

        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="client.xml"');

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
        $model=Client::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}