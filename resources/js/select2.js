require('select2');

$.fn.select2.defaults.set('language', 'pt-BR');
$.fn.select2.defaults.set('theme', 'bootstrap4');

$(function () {
    $('.select2-defaul').select2({
        ajax: {
            url: function (params) {
                return $(this).data('url');
            },
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.data.map(function(ele) {return {id:ele.id, text: ele.name}})
                };
            }
        }
    });
});
