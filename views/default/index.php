<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;

$this->title = 'Importador csv';
// $tables = Yii::$app->db->Schema->getTableSchema('autos')->columns;//getTableNames();
// print_r($tablas);
$this->params['breadcrumbs'][] = $this->title;
?>

<?php 
    if (isset($_GET['mensaje'])) {
        if (isset($_GET['tipo'])) {
            \Yii::$app->getSession()->setFlash($_GET['tipo'], $_GET['mensaje']);
        } else {
            \Yii::$app->getSession()->setFlash('info', $_GET['mensaje']);
        }            
    }
?>

<div class="importador-form">

    <?= $this->render('_form', [
        'model' => $model,
        'tablas' => $tablas
    ]) ?>

</div>