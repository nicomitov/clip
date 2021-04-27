require('./bootstrap');
require('datatables.net-bs4');


$( document ).ready(function() {

    // datatables
    let table = $('#dTable').DataTable({
        lengthMenu: [10, 20, 50, 100, 1000],
        "pageLength": 20,
        responsive: true
    });

    // dadtatables modal delete
    $('#dTable tbody').on('click', '.form-delete', function (e) {
        e.preventDefault();
        let form = $(this);

        $('#confirm').modal({ backdrop: 'static', keyboard: false })
            .on('click', '#delete-btn', function(){
                form.submit();
        });
    });

    // dadtatables clickable row
    $('table').on('click', '.clickable', function (event) {
        if(!$(event.target).hasClass('href')) {
           window.document.location = $(this).data("href");
        }
    });







    // modal delete
    $('.form-delete').on('click', function (e) {
        e.preventDefault();
        let form = $(this);

        $('#confirm').modal({ backdrop: 'static', keyboard: false })
            .on('click', '#delete-btn', function(){
                form.submit();
        });
    });

    // TOOLTIP
    $('[data-rel="tooltip"]').tooltip();

    // POPOVER
    $('[data-toggle="popover"]').popover();
    $(document).on('click', function (e) {
        $('[data-toggle="popover"],[data-original-title]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
            }
        });
    });

    // submit
    $('.formSubmit').click(function(e) {
        e.preventDefault();
        $(this).parents('form:first').submit()
    });

    // alerts
    setTimeout(function() {
        if ($("#alert").length > 0) {
            $("#alert").fadeTo(5, 0).slideUp(5, function() {
                $(this).remove();
            });
        }
    }, 5000);

    // subscription: append topics fields
    $('#Pressclipping').click(function(e) {
        let topics =  $(this).data("topics");
        let selectedTopics = $(this).data("selected_topics");
// console.log(selectedTopics);
console.log(topics);

        topics.sort(function (a, b) {
            return ('' + a.attr).localeCompare(b.attr);
        });

        let html =
        '<div class="form-group required row">'+
            '<label for="toTopics" class="col-lg-2 col-form-label">Topics:</label>'+
            '<div class="col-lg-10">'+
                 '<select class="bsmultiselect custom-select" id="toTopics" name="toTopics[]" size="6" data-non_selected_text="Please Select..." multiple>'+
                 '</select>'+
            '</div>'+
        '</div>';

        // append select
        if (!$('#toTopics').length) {
            $('#append').prepend(html);
        }

        // populate select
        $.each(topics, function(key, value) {
            if (value.selected == true) {
                $('#toTopics').append('<option selected value=' + value.id + '>' + value.name + '</option>');
            } else {
                $('#toTopics').append('<option value=' + value.id + '>' + value.name + '</option>');
            }
        });

        // build multiselect
        bsms();
    });

    // trigger click on validation errors
    if ($('#Pressclipping:checked').length > 0) {
        $('#Pressclipping').click();
    }

    // subscription: remove topics
    $("[id='Daily News']").click(function(e) {
        $("#append").html("");
    });

    // populate clientEmails
    $('#client_id').change(function() {
        let dropdown = $('#toEmails');
        let id = $( "#client_id" ).val();

        dropdown.empty();
        dropdown.prop('selectedIndex', 0);

        const url = '/clients/get_emails/' + id;

        // Populate dropdown
        $.getJSON(url, function (data) {
            $.each(data, function (key, entry) {
            dropdown.append($('<option></option>').attr('value', entry.k).text(entry.v));
            })
            $('#toEmails').multiselect('rebuild');
        });
    });

    // populate clientEmails
    $('#client_id').change(function() {
        let commentBox = $('#comment');
        let id = $( "#client_id" ).val();

        commentBox.val('');

        const url = '/clients/get_comment/' + id;

        // Populate commentBox
        $.getJSON(url, function (data) {
            commentBox.val(data);
        });
    });

    // bootstrap-multiselect init settings
    function bsms() {
        let bs_multi = $('.bsmultiselect');

        if(bs_multi.length) {
            bs_multi.each(function (index, element) {

                // let label = $(this).data("label");
                // let id = $(this).data("id");
                let nonSelectedText = $(this).data("non_selected_text");
                // let maxHeight = $(this).data("max_height");
                // let dropUp = $(this).data("drop_up");
                // let buttonWidth = $(this).data("button_width");
                // let enableFiltering = $(this).data("enable_filtering");
                // let enableCaseInsensitiveFiltering = $(this).data("enable_case_insensitive_filtering");

                $(this).multiselect({
                    nonSelectedText: nonSelectedText,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    // enableHTML: false,
                    includeSelectAllOption: true,
                    // maxHeight: maxHeight,
                    // dropUp: dropUp,
                    // buttonWidth: '100%',

                    templates: {
                        li: '<li><a class="dropdown-item py-1"><label class="px-0 w-100"></label></a></li>',
                        ul: '<ul class="multiselect-container dropdown-menu w-100 px-3 py-2"></ul>',
                        filter: '<li class="multiselect-item filter" style="min-width:100%"><div class="input-group mx-0"><input class="form-control multiselect-search mb-0" type="text"></div></li>',
                        filterClearBtn: '<div class="input-group-append"><button class="btn btn-sm px-3 multiselect-clear-filter" type="button"><i class="fas fa-times fa-lg pt-1 text-muted"></i></button></div>'
                    },
                    buttonContainer: '<div class="dropdown" />',
                    buttonClass: 'form-control'
                });
            });
        }
    };

    bsms();


});
