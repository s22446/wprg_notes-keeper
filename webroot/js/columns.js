$(document).ready(function () {
    columnForAdd();
});

function columnForAdd() {
    $('#column-template').children().first()
    .clone().appendTo('.notes-columns')
    .find('.add-column').click(addColumn);
}

function columnAddCleanup(columnName, addButton, columnId) {
    $(addButton).siblings('.column-name').html(columnName);
    $(addButton).closest('.notes-column').data('columnId', columnId);
    $(addButton).parent().prepend($('#column-delete-template').children().first().clone());
    $(addButton).parent().parent().siblings('.notes-column-content').append($('#note-add-template').children().first().clone().click(addNote));
    $(addButton).remove();
    columnForAdd();
}

function columnRemoveCleanup(removeButton) {
    $(removeButton).closest('.notes-column').remove();
}

function addColumn() {
    var addButton = this;
    var columnName = $(this).parent().find('input').val();
    var columnPosition = $(this).parent().parent().parent().index() + 1;

    if (columnName === '') {
        alert('Column name cannot be empty.');
    }
    else {
        var url = getAppUrl() + '/UserColumns/addColumn';

        var successCallback = function (data) {
            data = JSON. parse(data);
            if (data.status === 'SUCCESS') {
                var columnId = data.columnId;
                columnAddCleanup(columnName, addButton, columnId);
            }
            else {
                failCallback();
            }
        };

        var failCallback = function () {
            alert('There has been error during adding column.');
        }

        data = {
            columnName: columnName,
            columnPosition: columnPosition
        }

        sendPostAjax(url, data, successCallback, failCallback);
    }
}

function removeColumn(that) {
    var removeButton = that;
    var columnId = $(removeButton).closest('.notes-column').data('columnId');
    var deleteMessage = "Do you really want to delete this column and all it's notes?";

    if (confirm(deleteMessage) && columnId !== undefined) {
        var url = getAppUrl() + '/UserColumns/removeColumn';

        var successCallback = function (data) {
            data = JSON. parse(data);
            if (data.status === 'SUCCESS') {
                columnRemoveCleanup(removeButton);
            }
            else {
                failCallback();
            }
        };

        var failCallback = function () {
            alert('There has been error during removing this column.');
        }

        data = {
            columnId: columnId
        }

        sendPostAjax(url, data, successCallback, failCallback);
    }
}
