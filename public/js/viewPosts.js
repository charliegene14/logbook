posts_submit = function() {

    var type = $('#type :selected').val();
    var work = $('#work :selected').val();
    var tool = $('#tool :selected').val();

    var url = 'view/viewPosts.php';
    var symbol = '?';

    if (type != "") {
        url += symbol +'type='+type;
        symbol = '&';
    }

    if (work != "") {
        url += symbol +'work='+work;
        symbol = '&';
    }

    if (tool != "") {
        url += symbol +'tool='+tool;
        symbol = '&';
    }

    $.get({
        async: true,
        url: url,

        success: function(page) {
            $('section#posts .title-section').html($(page).find('.title-section').contents());
            $('section#posts .content-section').remove();
            $('section#posts').append($(page).find('.content-section'));
        }
    })
}

$('section#posts').on('click', '.pagination a', function(e) {
    e.preventDefault();
    var query = this.href.split('?');

    $.get({
        async: true,
        url: 'view/viewPosts.php?' + query[1],

        success: function(page) {
            $('section#posts .title-section').html($(page).find('.title-section').contents());
            $('section#posts .content-section').html($(page).find('.content-section').contents());
        }
    });

    goToByScroll('posts');
});