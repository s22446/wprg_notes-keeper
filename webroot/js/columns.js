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
    $(addButton).parent().prepend($('#column-edit-template').children().first().clone());
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

function editColumn(that) {
    var currentColumnName = $(that).siblings('.column-name').html();

    $(that).parent().hide().siblings('.column-name-change').css('display', 'flex').find('input').val(currentColumnName);
}

function saveEditedColumn(that) {
    var saveEditedColumnButton = $(that);
    var newColumnName = saveEditedColumnButton.siblings('.column-name-update').find('input').val();
    var columnId = saveEditedColumnButton.closest('.notes-column').data('columnId');

    if (newColumnName === '') {
        alert('Column name cannot be empty.');
    }
    else {
        var url = getAppUrl() + '/UserColumns/editColumn';

        var successCallback = function (data) {
            data = JSON. parse(data);
            if (data.status === 'SUCCESS') {
                saveEditedColumnButton.parent().hide().siblings('.column-header-content').css('display', 'flex').find('.column-name').html(newColumnName);

                $('.success-popup-message').text('Saved column successfully');

                $('.success-popup-message').show(() => {
                    setTimeout(() => {
                        $('.success-popup-message').fadeTo(500, 1).slideUp(500, () => {
                            $('.success-popup-message').hide();
                        })
                    }, 2000)
                });
            }
            else {
                failCallback();
            }
        };

        var failCallback = function () {
            alert('There has been error during editing column.');
        }

        data = {
            newColumnName: newColumnName,
            columnId: columnId
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
