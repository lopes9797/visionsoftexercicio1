<?php
use yii\helpers\Html;

?>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Título da Tarefa</th>
        <th>Descrição</th>
        <th>Data de Criação</th>
        <th>Data de Conclusão</th>
        <th>Estado</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task): ?>
        <tr data-id="<?= $task->id ?>">
            <td><?= Html::encode($task->title) ?></td>
            <td><?= Html::encode($task->description) ?></td>
            <td><?= Html::encode($task->created_at) ?></td>
            <td><?= Html::encode($task->conclusion_at) ?></td>
            <td>
                <?php if ($task->status_id == 1): ?>
                    <span class="badge text-bg-warning">Pendente</span>
                <?php endif; ?>
                <?php if ($task->status_id == 2): ?>
                    <span class="badge text-bg-success">Em curso</span>
                <?php endif; ?>
                <?php if ($task->status_id == 3): ?>
                    <span class="badge text-bg-secondary">Finalizado</span>
                <?php endif; ?>
            </td>
            <td>
                <?= Html::button('Editar', ['class' => 'btn btn-info btn-edit']) ?>
                <?= Html::button('Eliminar', ['class' => 'btn btn-danger btn-delete']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
