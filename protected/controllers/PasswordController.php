<?php

class PasswordController extends Controller {

    public function filters()
    {
        return array(
        'rights',
        );
    }

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Password'),
		));
	}

	public function actionCreate() {
		$model = new Password;

		$this->performAjaxValidation($model, 'password-form');

		if (isset($_POST['Password'])) {
			$model->setAttributes($_POST['Password']);

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
		$model = $this->loadModel($id, 'Password');

		$this->performAjaxValidation($model, 'password-form');

		if (isset($_POST['Password'])) {
			$model->setAttributes($_POST['Password']);

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
			$this->loadModel($id, 'Password')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Password');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Password('search');
		$model->unsetAttributes();

		if (isset($_GET['Password']))
			$model->setAttributes($_GET['Password']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

    public function actionImport() {
        $model = new ImportForm('password');

        if(isset($_POST['ImportForm'])) {

            $model->attributes=$_POST['ImportForm'];
            $model->xml = CUploadedFile::getInstance($model, 'xml');

            if ($model->validate()) {
                $xml   = simplexml_load_file($model->xml->getTempName());
                $saved = 0;

                foreach ($xml->children() as $node) {
                    $pw = new Password;
                    $pw->password   = $node->password;
                    $pw->type_id    = $node->type_id;
                    $pw->project_id = $node->project_id;

                    if (isset($node->title)) {
                        $pw->title = $node->title;
                    }

                    if (isset($node->username)) {
                        $pw->username = $node->username;
                    }

                    if ($pw->validate() && $pw->save()) {
                        $saved++;
                    }

                    //YiiDebug::dump($pw);
                }

                Yii::app()->user->setFlash('success', sprintf("%d Passwords saved!", $saved));

                $this->redirect(array('password/import'));
            }

        }

        $this->render('import', array(
            'model' => $model,
            'xml'   => file_get_contents('protected/data/password.xml')
        ));

    }

    public function actionExport() {
        $model = new Password();

        $xml = simplexml_load_string('<passwords></passwords>');

        foreach ($model->findAll() as $password) {
            $node = $xml->addChild('password');
            $node->addChild('type_id', $password->type_id);
            $node->addChild('project_id', $password->project_id);
            $node->addChild('password', $password->password);

            if ($password->username) {
                $node->addChild('username', $password->username);
            }

            if ($password->title) {
                $node->addChild('title', $password->title);
            }
        }

        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="password.xml"');

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
        $model=Password::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='password-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}