
jQuery(document).ready(function ($) {
    $('.btn-modal').click(function () {
        ShowModal(this.name, this.value,true,'600px');
    }); 
    $('.img-modal').click(function () {
        ShowModal(this.name, this.title,true,'600px');
    }); 
    $('.img-modalx').click(function () {
        ShowModal(this.name, this.title,true,'900px');
    }); 
    // --- Delete action (bootbox) ---
    yii.confirm = function (message, ok, cancel) {
        var title = $(this).data("title");
        var confirm_label = $(this).data("ok");
        var cancel_label = $(this).data("cancel");
        
        bootbox.confirm(
            {
                title: title,
                message: message,
                buttons: {
                    confirm: {
                        label: confirm_label,
                        className: 'btn-danger btn-flat'
                    },
                    cancel: {
                        label: cancel_label,
                        className: 'btn-default btn-flat'
                    }
                },
                callback: function (confirmed) {
                    if (confirmed) {
                        !ok || ok();
                    } else {
                        !cancel || cancel();
                    }
                }
            }
        );
        // confirm will always return false on the first call
        // to cancel click handler
        return false;
    };
});

function MessageBox(){
    krajeeDialog.dialog(
        'This is a <b>custom dialog</b>. The dialog box is <em>draggable</em> by default and <em>closable</em> ' +
        '(try it). Note that the Ok and Cancel buttons will do nothing here until you write the relevant JS code ' +
        'for the buttons within "options". Exit the dialog by clicking the cross icon on the top right.',
        function (result) {alert(result);}
    );
}
/**
 * @description To enable Progress events
 * @param {type} df
 * @returns {undefined}
 */
function ShowProgress(df=true){
    if(df){
       $("#eulims_progress").removeClass("progress-stop");
       $("#eulims_progress").addClass("progress-start");
    }else{
       $("#eulims_progress").removeClass("progress-start");
       $("#eulims_progress").addClass("progress-stop");
    }
}
function ConfirmBox(Title, Message){
    bootbox.confirm(
        {
            title: Title,
            message: Message,
            buttons: {
                confirm: {
                        label: 'Yes',
                        className: 'btn-danger btn-flat'
                },
                cancel: {
                        label: 'No',
                        className: 'btn-default btn-flat'
                }
            },
            callback: function (confirmed) {
                if (confirmed) {
                    !ok || ok();
                } else {
                    !cancel || cancel();
                }
            }
        }
    );
}
function CurrencyFormat(number,decimalplaces){
   if (typeof decimalplaces === 'undefined'){ 
       decimalplaces = 2; 
   }
   var decimalcharacter = ".";
   var thousandseparater = ",";
   number = parseFloat(number);
   var sign = number < 0 ? "-" : "";
   var formatted = new String(number.toFixed(decimalplaces));
   if( decimalcharacter.length && decimalcharacter != "." ) { formatted = formatted.replace(/\./,decimalcharacter); }
   var integer = "";
   var fraction = "";
   var strnumber = new String(formatted);
   var dotpos = decimalcharacter.length ? strnumber.indexOf(decimalcharacter) : -1;
   if( dotpos > -1 )
   {
      if( dotpos ) { integer = strnumber.substr(0,dotpos); }
      fraction = strnumber.substr(dotpos+1);
   }
   else { integer = strnumber; }
   if( integer ) { integer = String(Math.abs(integer)); }
   while( fraction.length < decimalplaces ) { fraction += "0"; }
   temparray = new Array();
   while( integer.length > 3 )
   {
      temparray.unshift(integer.substr(-3));
      integer = integer.substr(0,integer.length-3);
   }
   temparray.unshift(integer);
   integer = temparray.join(thousandseparater);
   return sign + integer + decimalcharacter + fraction;
}
function StringToFloat(str, decimalForm){
	//This function will convert string value into Float valid values
	if (typeof decimalForm === 'undefined'){ 
		decimalForm = 2; 
	}
	var v=str.replace(',','').replace(' ','');
	v=v.replace(',','').replace(' ','');
	v=parseFloat(v);
	//console.log(v);
	var v=v.toFixed(decimalForm);
	return parseFloat(v);
}
function ShowModal(header,url,closebutton,width){
    if(closebutton===undefined){
        closebutton=true;
    }
    
    if(width===undefined){
       width='600px'; 
    }
    $(".close").prop('disabled',!closebutton);
    $('#modalContent').html("<div style='text-align:center;'><img src='/images/img-loader64.gif' alt=''></div>");
    $('.modal-title').html();
    var dialog=$("#modal").modal({
        backdrop: false,
        show: true,
        draggable: true
    });
    dialog.init(function(){
        setTimeout(function(){
            dialog.find('.modal-title').html(header);
            dialog.find('.modal-dialog ').css({
               width: width
            });
            dialog.find('#modalContent').load(url);
        }, 5);
    });
}

function LoadModal(header,url,closebutton,width){
    ShowModal(header,url,closebutton, width);
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
function MessageBox(Message,Title="System Message",labelYes="",labelCancel="", WithCallback=false) {
    var labelButton=(labelYes==="") && (labelCancel==="");
    if(labelButton && FuncName===""){
        bootbox.alert({
            title: Title,
            message: Message,
            size: 'medium'
        });
        return true;
    }else if(!labelButton && !WithCallback){
        bootbox.confirm({
            title: Title,
            message: Message,
            buttons: {
                cancel: {
                    label: labelCancel,
                    className: 'btn-default'
                },
                confirm: {
                    label: labelYes,
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                return true;
            }
        });
    }else if(!labelButton && WithCallback){
        bootbox.confirm({
            title: Title,
            message: Message,
            buttons: {
                cancel: {
                    label: labelCancel,
                    className: 'btn-default'
                },
                confirm: {
                    label: labelYes,
                    className: 'btn-success'
                }
        },
        callback: function (result) {
           if(result){//yes
               ConfirmCallback();
           }else{//No
               CancelCallBack();
           }
        }
        });
    }
}

