$(document).ready(function() {
    $(document).pjax('a', '#taskPjaxContainer');

    $('#addTaskButton').click(function() {
        $('#taskForm')[0].reset();
        $('#taskId').val('');
        $('#taskModal .modal-title').text('Adicionar Tarefa');
        $('#taskModal').modal('show');
    });

    $('#taskForm').on('beforeSubmit', function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        let taskId = $('#taskId').val();
        let url = taskId ? `/task/update?id=${taskId}` : '/task/create';

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    $.pjax.reload({container: '#taskPjaxContainer'});
                    $('#taskModal').modal('hide');
                } else {
                    alert('Erro ao salvar tarefa');
                }
            }
        });
        return false;
    });

    $(document).on('click', '.btn-edit', function() {
        let row = $(this).closest('tr');
        let taskId = row.data('id');
        $.ajax({
            url: `/task/view?id=${taskId}`,
            method: 'GET',
            success: function(task) {
                $('#taskTitle').val(task.title);
                $('#taskDescription').val(task.description);
                $('#taskDueDate').val(task.conclusion_at);
                $('#taskStatus').val(task.status_id);
                $('#taskId').val(task.id);
                $('#taskModal .modal-title').text('Editar Tarefa');
                $('#taskModal').modal('show');
            }
        });
    });

    $(document).on('click', '.btn-delete', function() {
        if (confirm('Tem certeza que deseja eliminar esta tarefa?')) {
            let row = $(this).closest('tr');
            let taskId = row.data('id');
            $.ajax({
                url: `/task/delete?id=${taskId}`,
                method: 'POST',
                // data: {'_method': 'DELETE'},
                success: function(response) {
                    if (response.status === 'success') {
                        $.pjax.reload({container: '#taskPjaxContainer'});
                    } else {
                        alert('Erro ao eliminar tarefa');
                    }
                }
            });
        }
    });

    $('#taskModal').on('hidden.bs.modal', function () {
        $('#taskForm')[0].reset();
        $('#taskId').val('');
        $('#taskModal .modal-title').text('Adicionar Tarefa');
    });
});
