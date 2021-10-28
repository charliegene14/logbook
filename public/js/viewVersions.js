var list_versions = document.querySelectorAll('article.version');

list_versions.forEach(function(version) {
    var changelog_button = version.querySelector('.targetChangelog .button');
    var changelog = version.querySelector('.changelog');

    changelog_button.addEventListener('click', function() {
        changelog.classList.toggle('active');
        goToByScroll(changelog.parentNode.id);
    });
});