<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
?>

<?php $form = ActiveForm::begin([
      // 'method' => 'get',
      'options' => ['enctype' => 'multipart/form-data']]) ?>
    
<div class="row">
  <div class="col-md-6 col-sm-12">
    <?= $form->field($model, 'modeloImport')->widget(Select2::classname(), [
        'data' => $tablas,
        'language' => 'es',
        'options' => [
          'placeholder' => 'Selecciona la tabla ...',
          'onchange' => '$.get( "'.Url::toRoute("/importador/default/get-datos").'", { tabla: $(this).val()  } )
                          .done(function( data ) {                             
                              $( "#datos_producto" ).fadeOut( 500, function(){
                                  $( "#datos_producto" ).html( data );
                              });                                              
                              $( "#datos_producto" ).fadeIn( 500 );
                          }
                        )',
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Modelo al que importará los datos.'); ?>

  </div>
  <div class="col-md-6 col-sm-12">

    <?= $form->field($model, 'NameSpace')->dropdownList(
      ['app' => 'app','backend' => 'backend','frontend' => 'frontend'],
        ['prompt'=>'Espacio de nombre']
    )->label('Espacio de nombre al que importará los datos.'); ?>

  </div>
</div>
<div class="row">
  <div class="col-md-6">

    <?= $form->field($model, 'csvFile')->fileInput([
    'class' => 'custom-file-upload',
    'accept' => '.csv',
    'id' => 'csvFile',
    'data-btn-text'=>"Cargar archivo"])->hint('seleccione un archivo .csv')->label('Archivo CSV') ?>

  </div>
  <div class="col-md-6">

    <div class="form-group margin-top-25">
        <?= Html::submitButton('<i class="fa fa-sign-in" ></i>Importar', ['class' => 'btn btn-success']) ?>
    </div>

  </div>
</div>

<?php ActiveForm::end() ?>

<div id="datos_producto" style="display:none;">
  
</div>
