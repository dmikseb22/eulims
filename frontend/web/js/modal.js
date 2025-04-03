$(function () {
    $(document).on('click', '.showModalButton', function () {

        // reset content before show
        $('#modalprogress').find('#modalContent').html("<div style='text-align:center'><img src='image/ajax-loader.gif'></div>");
        //if modal isn't open; open it and load content
        $('#modalprogress').on('hidden.bs.modal', function () { }).modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        //dynamiclly set the header for the modal
      //  document.getElementById('headerTitle').innerHTML = $(this).attr('header') ? $(this).attr('header') : $(this).attr('title');
    });
});