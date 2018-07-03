$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // HIDE UNUSED ELEMENTS
    $('.nav-item-footer').hide()
    $('.copyright').hide()

    // FOOTER NAVIGATION BATTONS
    $('#page-action-holder-left').data('tooltip','Filters')
    $('#page-action-holder-right').data('tooltip','Go Top')



    var $load = $('.postLoad')
    $load.hide()
    var page = 1
    var state = 'ready'
    var mode = 'main'
    var dataFilter =  new Object()
    var $container = $('.pushNotificationContainer')


    dataFilter.make = ''
    dataFilter.model = ''
    dataFilter.year = ''

    // SCROLL ACTION LOAD NEXT POSTS
    $(window).scroll(function() {

        if (activePage == 'main'){
            if($container.is(":visible")){
                $container.hide()
                $container.css('background','black')
            }

            if ( mode == "main" ) {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 300 && state == 'ready') {
                    state = 'busy'
                    page++
                    loadMorePosts(page, mode, dataFilter)
                }
            }else{
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 300 && state == 'ready') {
                    state = 'busy'
                    page++
                    loadMorePosts(page, mode, dataFilter)
                }
            }
        }
    });

    // LOAD NEXT 3 POSTS WITH LARAVEL PAGINATION()
    function loadMorePosts(page, mode, dataFilter){
        var $container = $('#portfolio');
        var link
        if ( mode == 'main'){
            link = ''
            dataFilter.ajax = 'ajax'
        }
        else{
            link = '/FiltredPosts'
        }

        $.ajax(
            {
                url: link + '?page=' + page,
                type: "get",
                data: dataFilter,
                beforeSend: function()
                {
                    $load.show();
                }
            })
            .done(function(data)
            {
                if(data[0] == ""){
                    console.log('No more posts found')
                    $container.parent().append( '<span class="noPosts">No more posts found</span>' );
                    $load.hide();
                    return;
                }
                var $content = $(data[0])
                $container.append( $content ).isotope( 'appended', $content );
                MasonryPortfolio()
                $content.each(function() {
                    var image = $(this).find('.item-image').data('src');
                    $(this).find('.item-image').css({'background-image': 'url(' + image + ')'});
                    //$(this).find('.item-shadow').prepend($('<img>',{src:image}))
                });

                state = 'ready'
                $load.hide();

            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                $container.append( '<span class="noPosts">server not responding...</span>' );
            });
    }


    // LOAD FILTERS ACTION
    $('.filterLoad').on('click', function () {
        $('html, body').animate({scrollTop : 0},800);
        mode = 'filter'
        page = 1
        state = 'busy'
        $load.show()
        var filterData = $('#filters')
        var make = filterData.find('#make').val()
        var model = filterData.find('#model').val()
        var year = filterData.find('#year').val()
        dataFilter.make = make
        dataFilter.model = model
        dataFilter.year = year
        $('#portfolio').isotope('destroy')
        $('.page-action-overlay').removeClass('active')
        $('#portfolio').text('')

        $.ajax({

            url: '/FiltredPosts?page=' + page,
            type: "get",
            dataType : 'json',
            data: {
                make: make,
                model: model,
                year: year,
                page: page
            },
            success: function(data) {
                var $content = $(data[0])
                var $container = $('#portfolio');
                $container.append( $content ).isotope( 'appended', $content );

                $('.item').each(function() {
                    var image = $(this).find('.item-image').data('src');
                    $(this).find('.item-image').css({'background-image': 'url(' + image + ')'});
                    $(this).find('.item-shadow').prepend($('<img>',{src:image}))
                });
                MasonryPortfolio()
                $load.hide();
                state = 'ready'
            },
            error: function(data) {
                alert("Error"+ data.error);
            },
        });
    })



    ///// LOAD CARS MAKE
    var selector = $('#make');
    selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');

    $.ajax({

        url: '/loadCarsMake',
        type:'POST',
        dataType : 'json',
        data: {},
        success: function(data) {
            selector.append('<option  selected="selected" disabled="disabled">Make</option>')
            $.each( data.make, function( makes, values ) {
                $.each( values, function( make, value ) {

                    selector.append('<option value="' + value + '">' + value + '</option>');
                });
            });

            selector.parent().find('.dbload').remove();

        }
    });



    ///// LOAD CARS MODEL
    $('#make').on('change', function() {

        var selector = $('#model');
        selector.html('');
        $('#model').html('');
        $('#year').html('');
        $('#engine').html('');
        var make = $(this).val();
        selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');

        $.ajax({

            url: '/loadCarsModel',
            type:'POST',
            dataType : 'json',
            data: {
                make: make
            },
            success: function(data) {
                selector.append('<option  selected="selected" disabled="disabled">Select</option>')
                $.each( data.models, function( models, values ) {
                    $.each( values, function( model, value ) {
                        selector.append('<option value="' + value + '">' + value + '</option>');
                    });
                });

                selector.parent().find('.dbload').remove();

            }
        });
    });

    ///// LOAD CARS YEAR
    $('#model').on('change', function() {

        var selector = $('#year');
        selector.html('');
        $('#engine').html('');
        var make = $('#make').val();
        var model = $(this).val();

        selector.parent().append('<i class="fas fa-cog fa-spin dbload"></i>');

        $.ajax({

            url: '/loadCarsYear',
            type:'POST',
            dataType : 'json',
            data: {
                make: make,
                model: model
            },
            success: function(data) {
                selector.append('<option  selected="selected" disabled="disabled">Select</option>')
                $.each( data.years, function( years, values ) {
                    $.each( values, function( year, value ) {
                        selector.append('<option value="' + value + '">' + value + '</option>');
                    });
                });

                selector.parent().find('.dbload').remove();

            }
        });
    });
});