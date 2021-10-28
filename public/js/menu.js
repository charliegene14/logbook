var menu_content = document.querySelector('header#menu div#menu-content');
var menu_opener = document.querySelector('header#menu div#menu-opener');

var menu_button = menu_opener.querySelector('div#menu-image');
var menu_title = menu_content.querySelector('h1 a');

var menu_list = menu_content.querySelectorAll('nav li');

function menuToggle() {
    var active = menu_content.classList.toggle('active');
    menu_button.classList.toggle('active');

    menu_title.classList.toggle('active');

    if (!active) {
        menu_content.classList.add('inactive');
    } else {
        menu_content.classList.remove('inactive');
        menu_content.style.display = "block";
    }
}

menu_opener.addEventListener('click', e => {
    menuToggle();
});

menu_content.addEventListener('animationend', function() {

    if (menu_content.classList.contains('inactive')) {
        menu_content.style.display = "none";
    }
});

$('header#menu nav li a').on('click', function() {
    menuToggle();
})

$('header#menu nav li').each(function() {
    $(this)
    .has('ul')
    .addClass('has-children')
})

document.querySelectorAll('nav ul li.has-children').forEach(function(element) {

    var span = document.createElement('span');
    element.querySelector('a').after(span);
    element.querySelector('span').classList.add('opener-sub-cat')
});

$('.opener-sub-cat').on('click', function() {
    $(this).toggleClass('active');
    $(this).next().toggleClass('active');
})