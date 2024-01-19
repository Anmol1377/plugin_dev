console.log("hello from console.... ");
jQuery(document).ready(function ($) {

    let search_form = $('#my-search-form');

    search_form.submit(function (event) {
        event.preventDefault();
        let search_term = $('#my-search-term').val();
        // console.log(search_term);

        let formData = new FormData();
        formData.append('action', 'my_search_func');
        formData.append('search_term', search_term);

        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // console.log(response)
                $('#my-table-result').html(response);
            },
            error: function () {
                console.log('error');
            }
        });

    });

});