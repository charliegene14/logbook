function goToByScroll(elementId) {
    var element = document.getElementById(elementId);
    element.scrollIntoView({
        block: 'start',
        behavior: 'smooth'
    });
};