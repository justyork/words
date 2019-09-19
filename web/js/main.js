
$(document).ready(function () {
    $('[data-modal]').click(function () {
        var id = $(this).attr('data-modal');
        $('#'+id).modal('show');

        return false;
    })

    // $('.ui.checkbox')
    //     .checkbox();

    $('select.dropdown')
        .dropdown();


    $('.skip-toggle').click(function() {
        var btn = $(this)
        $.post(_links.skip_word, {id:$(this).attr('data-id')}, function(o) {
            // var json = JSON.parse(o)
            if(o.skip) btn.removeClass('teal').find('i').addClass('slash')
            else btn.addClass('teal').find('i').removeClass('slash')
        })
        return false;
    });
})
