// Initialize collapsible (uncomment the lines below if you use the dropdown variation)
// var collapsibleElem = document.querySelector('.collapsible');
// var collapsibleInstance = M.Collapsible.init(collapsibleElem, options);

// Or with jQuery

$(document).ready(function () {
    //Init sidenav
    $('.sidenav').sidenav();

    //Init select
    $('select').formSelect();

    $('.modal').modal();

    //Init tabs
    $('.tabs').tabs();
    $('ul.tabs').tabs();

    //prepare modals callbacks
    const modal = M.Modal.getInstance($('#modal'));

    $('.modalDelete').on('click', function (event) {
        event.preventDefault();

        modal.open();
        $("#actionDelete").prop('href', $(this).prop('href'));
    });
});