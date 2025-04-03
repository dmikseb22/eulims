
jQuery(document).ready(function ($) {
    $("#modalBtn").click(function(){
        $("#modal").modal('show')
            .find('#modalContent')
            .load($(this).attr('value'),$(this).attr('title'));
    });
    //modalCancel
    $("#modalCancel").click(function(){
        $("#modal").modal('hide');
    });
});
function LoadModal(header,url){
   $("#modalHeader").html(header);
   $("#modal").modal('show')
        .find('#modalContent')
        .load(url); 
}
function printPartOfPage(elementId) {
    var printContent = document.getElementById(elementId);
    var windowUrl = 'about:blank';
    var uniqueName = new Date();
    var windowName = 'Print' + uniqueName.getTime();
    var printWindow = window.open(windowUrl, windowName, 'left=50000,top=50000,width=0,height=0');

    printWindow.document.write(printContent.innerHTML);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}