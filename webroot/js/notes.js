$(document).ready(function () {
    $('.add-note').click(addNote);
    $('.save-note').click(saveNote);
    $('.delete-note').click(removeNote);
    $('.note').on('input', textAreaExpander);
    expandExistingTextAreas();
});

function expandExistingTextAreas() {
    $('.note').each(function () {
        var note = $(this)[0];

        expandTextArea(note);
    });
}

function addNote() {
    var note = $('#note-template').children().first().clone().insertBefore(this).find('.note').on('input', textAreaExpander);

    var url = getAppUrl() + '/Notes/addNote';
    var columnId = $(this).closest('.notes-column').data('columnId');
    var position = $(note).parent().index() + 1;

    var successCallback = function (data) {
        data = JSON. parse(data);
        if (data.status === 'SUCCESS') {
            $(note).parent().data('noteId', data.noteId);
            $(note).parent().find('.note-buttons .save-note').click(saveNote);
            $(note).parent().find('.note-buttons .delete-note').click(removeNote);
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
    var url = getAppUrl() + '/Notes/saveNote';

    var noteId = $(this).closest('.note-container').data('noteId');
    var text = $(this).parent().siblings('.note').val();

    var successCallback = function (data) {
        data = JSON. parse(data);
        if (data.status === 'SUCCESS') {
            $('.success-popup-message').text('Saved note successfully');

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
        alert('There has been error during saving this note.');
        window.location.reload(true);
    }

    data = {
        noteId: noteId,
        text: text
    }

    sendPostAjax(url, data, successCallback, failCallback);
}

function removeNote() {
    var url = getAppUrl() + '/Notes/removeNote';

    var note = $(this);
    var noteId = note.closest('.note-container').data('noteId');

    var successCallback = function (data) {
        data = JSON. parse(data);
        if (data.status === 'SUCCESS') {
            $('.success-popup-message').text('Deleted note successfully');

            $('.success-popup-message').show(() => {
                setTimeout(() => {
                    $('.success-popup-message').fadeTo(500, 1).slideUp(500, () => {
                        $('.success-popup-message').hide();
                    })
                }, 2000)
            });

            note.closest('.note-container').remove();
        }
        else {
            failCallback();
        }
    };

    var failCallback = function () {
        alert('There has been error during saving this note.');
        window.location.reload(true);
    }

    data = {
        noteId: noteId
    }

    sendPostAjax(url, data, successCallback, failCallback);
}
