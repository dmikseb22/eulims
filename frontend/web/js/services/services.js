$(function(){
    $('.modal_services').click(function () {
        LoadModal(this.title, this.value);
    });
});

$(function(){
    $('.modal_method').click(function () {
        LoadModal(this.title, this.value, true, 1100);
    });
});

$(function(){
    $('.modal_package').click(function () {
        LoadModal(this.title, this.value, true, 700);
    });
});




