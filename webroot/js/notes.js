$(document).ready(function () {
    columnForAdd();
});

function columnForAdd() {
    $('#column-template').children().first()
    .clone().appendTo('.notes-columns')
    .find('.add-column').click(addColumn);
}

function addColumn() {
    var columnName = $(this).parent().find('input').val();
    var columnPosition = $(this).parent().parent().parent().index() + 1;

    if (columnName === '') {
        alert('Column name cannot be empty.');
    }
    else {
        var url = getAppUrl() + '/UserColumns/addColumn';

        var successCallback = function (data) {
            if (data.status === 'SUCCESS') {

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
