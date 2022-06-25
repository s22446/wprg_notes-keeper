function getAppUrl() {
    return window.location.origin;
}

function sendPostAjax(url, data, doneCallback, failCallback) {
    var token = $("meta[name='meta_token']").attr("content");
    $.ajax({
        method: "POST",
        url: url,
        data: data,
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .done(doneCallback)
    .fail(failCallback);
}

function textAreaExpander() {
    var note = $(this)[0];

    note.style.height = "";
    note.style.height = note.scrollHeight + "px";
}
