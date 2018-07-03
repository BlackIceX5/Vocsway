$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.nav-item-footer').hide()
    $('.copyright').hide()
    $('.after-slider').hide()


    // EDIT USER DATA
    $(document).on('click','.vote', function(){
        var item = $(this)
        var carId = item.data('carid')


        $.ajax({
            url: '/userVote',
            type:'POST',
            dataType : 'json',
            encode  : true,
            data: {
                carId: carId
            },
            success: function(data) {
                console.log(data)
                if(data.success){
                    var carVotes = item.parent().parent().find('#carVotes').data('carvotes')
                    var totalVotes = item.parent().parent().find('#carTotalVotes').data('totalvotes')
                    item.parent().parent().find('#carVotes').text(carVotes + 1)
                    $('.carTotalVotes').text(totalVotes + 1)
                    $('.voteButtonContainer').html('').append('Thanks! Your vote added')
                }
            }

        });

    });

});