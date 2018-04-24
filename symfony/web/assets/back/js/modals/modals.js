function getTopForModal(modal){
    var heightScreen = window.screen.height;
    console.log(heightScreen);
    var modalContent = modal.find('.modal-content');
    var hauteurModal = modalContent.height();
    var top = (heightScreen/2) - (hauteurModal);
    console.log(top);
    return 25;
}

function modalShow(modal){
    modal.css({'top':getTopForModal(modal)});
    modal.modal('show');
}

function linkModal(lien,modal){
    $('#'+lien).click(function () {
        modalShow($('#'+modal));
    });
}
function linkModals(lien,modal){
    $('.'+lien).each(function(){
        $(this).click(function(){
            $('#'+modal+'_'+$(this).data('id')).modal('show');
        });
    });
}

