// Initialize collapsible (uncomment the lines below if you use the dropdown variation)
// var collapsibleElem = document.querySelector('.collapsible');
// var collapsibleInstance = M.Collapsible.init(collapsibleElem, options);

// Or with jQuery

const cargarModalDelete = function () {
    $('.modalDelete').on('click', function (event) {
        event.preventDefault();

        const nameModal = '#' + $(this).data('modal');
        M.Modal.getInstance($(nameModal)).open();
        $(nameModal + ' .actionDelete').prop('href', $(this).prop('href'));
    });
};

$(document).ready(function () {
    //Init sidenav
    $('.sidenav').sidenav();

    //Init select
    $('select').formSelect();

    $('.modal').modal();

    //Init tabs
    $('.tabs').tabs();
    $('ul.tabs').tabs();

    cargarModalDelete();

    $('.tooltipped').tooltip();

    // Checkboxs column table reparto

    $('.ch_hide').on('click',function(){
        $('.'+ $(this).data("column") ).toggleClass("hide-element")
    })

    // Marcar todos los checkbox de solicitudes
    $('#boxSolcAll').on('click',function(){
        if($(this).prop('checked'))
            $('.boxesSolc').prop('checked','checked');
        else
            $('.boxesSolc').prop('checked','');
    });
});