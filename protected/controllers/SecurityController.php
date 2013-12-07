<?php

class SecurityController extends Controller {

    public function filters()
    {
        return array(
        'rights',
        );
    }

    public $layout = 'column1';

    public function actionIndex() {
        $model = new Password;

        $lengths = array();

        foreach ($model->findAll() as $password) {
            $l = mb_strlen($password);

            if (!isset($lengths[$l])) {
                $lengths[$l] = 0;
            }

            $lengths[$l]++;
        }

        $data = array();

        $count = $model->count();

        foreach ($lengths as $l => $numberOf) {
            $data[] = array($l . ' chars long', $numberOf / $count * 100 );
        }

        $this->render('index', array(
            'data' => $data
       //     'model' => $this->loadModel($id, 'Password'),
        ));
    }

}