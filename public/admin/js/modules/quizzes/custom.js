if (!Date.now) {
    Date.now = function() { return new Date().getTime(); }
}

$(document).ready(function () {
    ['question', 'answer', 'result'].forEach(function(item, i, arr) {
        $('form').on('click', '.add-'+item, function (event) {
            event.preventDefault();

            var id = Date.now();

            if (item == 'answer') {
                var parentId = $(this).closest('.panel-group').attr('data-id');

                var newEl = $($('.templates .'+item).html().replace(new RegExp('template-id', 'g'), id).replace(new RegExp('question-id', 'g'), parentId)).insertBefore(this);
            } else {
                var newEl = $($('.templates .'+item).html().replace(new RegExp('template-id', 'g'), id)).insertBefore(this);
            }

            Holder.run({
                images: newEl.find('.preview img').get(0)
            });

            initImageUploaders(newEl);
            initTinyMCE('#'+newEl.attr('id'));

            if (item === 'result') {
                $('#questionsAccordion').show();

                if ($('.templates .answer_results').length > 0) {
                    $('.answer-results .col-sm-10').each(function () {
                        var answerId = $(this).closest('.panel-group').attr('data-id');

                        $($('.templates .answer_results').html().replace(new RegExp('new_template-id', 'g'), answerId).replace(new RegExp('result-id', 'g'), id)).appendTo($(this));

                        $(this).closest('.answer-results').show();
                    });
                }

                $('.answer-results').show();
            } else if (item === 'answer') {
                $('.answer-results').show();
            }
        });
    });

    $('form').on('click', '.delete-option', function (event) {
        event.preventDefault();

        var el = $(this).closest('.panel-group'),
            type = el.attr('data-type'),
            id = el.attr('data-id');

        swal({
            title: "Вы уверены?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Отмена",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, удалить",
            closeOnConfirm: true
        }, function () {
            el.remove();

            if (type === 'result') {
                var assocResults = $('[data-assoc-result='+id+']'),
                    assocResultsContainers = $('[data-assoc-result='+id+']').closest('.answer-results');

                assocResults.remove();

                assocResultsContainers.each(function (index, value) {
                    var $val = $(value);
                    if ($val.find('.row').length == 0) {
                        $val.hide();
                    }
                });
            }
        });
    });

    $('form').on('change', '.change-header', function () {
        var panel = $(this).closest('.panel-group'),
            type = panel.attr('data-type'),
            id = panel.attr('data-id');

        var value = $(this).val();

        if (value !== '') {
            panel.find('.panel-title:first a:first-child').text(value);

            if (type === 'result') {
                $('[data-assoc-result='+id+']').find('.result-title').text(value);
            }
        }
    });
});
