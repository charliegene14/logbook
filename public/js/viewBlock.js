document.title = 'Connexion';

$(document).ready(function() {

        // Hello animation started
        $('#hello').on('animationend', function() {
            $('#pass_form').addClass('active');

            $('input,  #label-container h2')
            .addClass('appears')
            .on('animationend', function() {
                $('#password, #pass_submit').removeClass('appears')
            })
        })
    
    // Events when pass submitted is OK
    function access() {
        $('#input-container') .addClass('access') .on('animationend', function() {

            $('#pass_form').addClass('access').on('animationend', function() {
                $('#wave').removeClass('anim-drop-up').addClass('anim-drop-down').on('animationend', function() {
                    location.reload();
                })
            });
        })
    }

    // Events when pass submitted is not OK
    function refused() {
        $('#input-container')
        .addClass('refused')
        .on('animationend', function() {
            $('#input-container').removeClass('refused')
        })
    }

    // Password form submitting
    $("#pass_form").submit(function(event){
        event.preventDefault();
        var password = $("#password").val();

        $.ajax({
            async: true,
            type: 'post',
            url: '/passSession.php',
            data: {password: password},

            success: function(response) {
                var array = JSON.parse(response);
                array['bool'] ? access() : refused();
            }
        })
    });
})
