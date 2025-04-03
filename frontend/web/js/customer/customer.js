$(function(){
	$('.customer_button').click(function(){
		 // alert(this.value);
		LoadModal(this.title,this.value);
});});

function ShowGModal(header,closebutton,width){
    if(closebutton==undefined){
        closebutton=true;
    }
    if(width==undefined){
       width='600px'; 
    }
    $(".close").prop('disabled',!closebutton);
    //$('#searchTextField').val()="";
    var dialog=$("#gmodal").modal({
        backdrop: true,
        show: true,
        draggable: true
    });
    dialog.init(function(){
        setTimeout(function(){
            dialog.find('.modal-title').html(header);
            dialog.find('.modal-dialog ').css({
               width: width
            });
            //dialog.find('#modalContent').load(url);
        }, 5);
    });
}