<?php

use app\models\Status;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;

$this->title = 'Gestão de Tarefas';
?>

<div class="container">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php Pjax::begin(['id' => 'taskPjaxContainer']); ?>
    <?= $this->render('_taskTable', ['tasks' => $tasks]) ?>
    <?php Pjax::end(); ?>
    <?= Html::button('Adicionar Tarefa', ['class' => 'btn float-right btn-primary mb-3', 'id' => 'addTaskButton']) ?>
</div>

<?php
Modal::begin([
    'title' => '',
    'id' => 'taskModal',
    'size' => 'modal-lg'
]);
?>

<?php $form = ActiveForm::begin(['id' => 'taskForm', 'options' => ['data-pjax' => true]]); ?>
<?= $form->field($taskModel, 'title')->textInput(['id' => 'taskTitle']) ?>
<?= $form->field($taskModel, 'description')->textarea(['id' => 'taskDescription']) ?>
<?= $form->field($taskModel, 'status_id')->dropDownList(ArrayHelper::map(Status::find()->select(['name', 'id'])->all(), 'id', 'name'), ['class' => 'form-control inline-block', 'id' => 'taskStatus']); ?>
<?= Html::hiddenInput('id', '', ['id' => 'taskId']) ?>
<div class="form-group float-right">
    <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php Modal::end(); ?>
