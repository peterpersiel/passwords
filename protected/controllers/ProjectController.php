<?php

class ProjectController extends Controller {

    public function filters()
    {
        return array(
        'rights',
        );
    }

	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Project'),
		));
	}

    public function actionPdf($id) {
         # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/print.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML($this->renderPartial(
            'pdf',
            array(
                'project' => $this->loadModel($id, 'Project')
            ),
            true
        ));

        # Outputs ready PDF
        $mPDF1->Output('project_' .  $id . '.pdf', 'D');
    }

	public function actionCreate() {
		$model = new Project;

		$this->performAjaxValidation($model, 'project-form');

		if (isset($_POST['Project'])) {
			$model->setAttributes($_POST['Project']);

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
		$model = $this->loadModel($id, 'Project');

		$this->performAjaxValidation($model, 'project-form');

		if (isset($_POST['Project'])) {
			$model->setAttributes($_POST['Project']);

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
			$this->loadModel($id, 'Project')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Project');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Project('search');
		$model->unsetAttributes();

		if (isset($_GET['Project']))
			$model->setAttributes($_GET['Project']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

    public function actionImport() {
        $model = new ImportForm('project');

        if(isset($_POST['ImportForm'])) {

            $model->attributes=$_POST['ImportForm'];
            $model->xml = CUploadedFile::getInstance($model, 'xml');

            if ($model->validate()) {
                $xml   = simplexml_load_file($model->xml->getTempName());
                $saved = 0;

                foreach ($xml->children() as $node) {
                    $project = new Project;
                    $project->name = $node->name;
                    $project->client_id = $node->client_id;

                    if ($project->validate() && $project->save()) {
                        $saved++;
                    }

                    //YiiDebug::dump($pw);
                }

                Yii::app()->user->setFlash('success', sprintf("%d Projects saved!", $saved));

                $this->redirect(array('project/import'));
            }

        }

        $this->render('import', array(
            'model' => $model,
            'xml'   => file_get_contents('protected/data/project.xml')
        ));

    }

    public function actionExport() {
        $model = new Project();

        $xml = simplexml_load_string('<projects></projects>');

        foreach ($model->findAll() as $project) {
            $node = $xml->addChild('project');
            $node->addChild('name', $project->name);
            $node->addChild('client_id', $project->client_id);
        }

        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="project.xml"');

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
        $model=Project::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}