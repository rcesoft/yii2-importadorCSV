<?php

namespace backend\modules\importadorCSV\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\importadorCSV\models\importForm;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Hoteles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new importForm();

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if ($model->import()) {
                // file is uploaded successfully
                $model->modeloImport=$_POST['importForm']['modeloImport'];
                $model->NameSpace=$_POST['importForm']['NameSpace'];
                $cont=0;
                $handle = fopen('uploads/' .$model->csvFile, "r");
                while (($fileop = fgetcsv($handle, 1000, ",")) !== false) 
                { 
                    if ($cont!=0) {
                    	$modelocation = $model->NameSpace."\models\\".$model->modeloImport;
                        $modelImportar = new $modelocation();

                        $indice=0;
                        foreach ($modelImportar as $key => $value) {
                            if ($indice!=0) {
                                $modelImportar->$key = $fileop[$indice];
                            }
                            $indice++;
                        }

                        if (!$modelImportar->save()) {
                            $mensaje = 'No se pudo guardar la fila del hotel'.$modelImportar->nombre;
                            $tipo = 'error';
                            return $this->redirect(['index', 'mensaje' => $mensaje,'tipo' => $tipo]);
                        } 
                    }
                    $cont++;
                } 
            } else {
                $mensaje = 'No se pudo realizar la importación, los datos no son válidos';
                $tipo = 'error';
                return $this->redirect(['index', 'mensaje' => $mensaje,'tipo' => $tipo]);
            }
            $mensaje = 'Importación Satisfactoria';
            $tipo = 'success';
            return $this->redirect(['index', 'mensaje' => $mensaje,'tipo' => $tipo]);
        } else {

            $tables = Yii::$app->db->Schema->getTableNames();
            foreach ($tables as $key => $value) {
                $tablas[$value] = $value;
            }

            return $this->render('index', ['model' => $model,'tablas' => $tablas]);
        }

    }
    
    public function actionGetDatos($tabla)
    {
        $columnas = Yii::$app->db->Schema->getTableSchema($tabla)->columns;
        $lista='';
        foreach ($columnas as $key => $value) {
            $lista.='<b>'.$key."</b>(".$value->dbType.") ";
        }

        return 'El archivo csv debe tener las siguientes columnas: <br>'.$lista;        
    }

}
