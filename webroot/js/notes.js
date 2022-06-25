$(document).ready(function () {
    $('.add-note').click(addNote);
    $('.note').on('input', textAreaExpander);
});

function addNote() {
    var note = $('#note-template').children().first().clone().on('input', textAreaExpander).insertBefore(this);

    var url = getAppUrl() + '/Notes/addNote';
    var columnId = $(this).closest('.notes-column').data('columnId');
    var position = $(note).index() + 1;

    var successCallback = function (data) {
        data = JSON. parse(data);
        if (data.status === 'SUCCESS') {
            $(note).data('noteId', data.noteId);
            $(note).find('.note-buttons .save-note').click(saveNote);
            $(note).find('.note-buttons .delete-note').click(deleteNote);
        }
        else {
            failCallback();
        }
    };

    var failCallback = function () {
        alert('There has been error during adding note.');
        window.location.reload(true);
    }

    data = {
        columnId: columnId,
        notePosition: position
    }

    sendPostAjax(url, data, successCallback, failCallback);
}

function saveNote() {
    console.log('save note');
}

function deleteNote() {
    console.log('delete note');
}
