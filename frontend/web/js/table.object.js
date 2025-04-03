

function selectRow(ctrl){
    $(ctrl).addClass('info').siblings().removeClass('info');
    var index=$(ctrl).attr("data_key");
    ctrl.currentRowIndex=index;
    var e = jQuery.Event("select");
    e.index = index; // # Some key code value
    $(ctrl).trigger(e);
}
function keydown(ctrl){
    var event = jQuery.Event("keydown");
    var index=$(ctrl).attr("data_key");
    event.index=index;
    $(ctrl).trigger(event);
}
/**
 * 
 * @param {string} table_id
 * @returns {table DOM object}
 */
class tableobject{
    constructor(table_id){
        this.id=table_id;
        this.table=document.getElementById(table_id);
        this.tablebody = document.getElementById(table_id).getElementsByTagName('tbody')[0];
        this.contentrowcount=parseInt($("#"+this.id+">tbody>tr").length);
        this.currentRowIndex=0;
        return this;
    }
    selectRow(){
        $(this).addClass('info').siblings().removeClass('info');
        var index=$(this).attr("data-key");
        this.currentRowIndex=index;
    }
    /**
     * @description return row as an array
     * @param {integer} index
     * @returns {TableObject.table.rows}
     */
    row(index){
       return this.tablebody.rows[index]; 
    }
    /**
     * @description return rows as an aray
     * @returns {TableObject.table.rows}
     */
    rows(){
       return this.tablebody.rows;  
    }
    /**
     * 
     * @param {array} fields
     * @param {array} fieldsclass
     * @returns {tableobject.insertfooter.row|tableobject.insertfooter@pro;table@call;insertRow}
     */
    insertfooter(fields=[],fieldsclass=[]){
       var mtable=document.getElementById(this.id);
       var footer=mtable.createTFoot();
       var row=footer.insertRow(0);
        for (var i = 0; i < fields.length; i++) { 
            var cell = row.insertCell(i);
            if(fieldsclass[i]){//check if there is class for td
                cell.setAttribute("class", fieldsclass[i]);
            }
            cell.innerHTML=fields[i];
        }
        return row;
    }
   /**
    * 
    * @param {array} fields cell value
    * @param {array} fieldsclass class for td cell
    * @param {integer} index
    * @returns {TableObject.insertrow.row}
    */
    insertrow(fields=[],fieldsclass=[],index=-1){
        if(index<0){
            index=parseInt(this.tablebody.rows.length);
        }
        console.log(index);
        var row=this.tablebody.insertRow(index);
        row.setAttribute("class", "clickable-row");
        row.setAttribute("id","table_obj"+index);
        row.setAttribute("data_key",index);
        row.setAttribute("tabindex",index);//tabindex
        row.setAttribute("onClick", "selectRow(this)");//selectRow(this)
        row.setAttribute("onkeydown", "keydown(this)");
        for (var i = 0; i < fields.length; i++) { 
            var cell = row.insertCell(i);
            if(fieldsclass[i]){//check if there is class for td
                cell.setAttribute("class", fieldsclass[i]);
            }
            cell.innerHTML=fields[i];
        }
        return row;
    }
    /**
     * @description Removes all rows from the table
     * @returns {none}
     */
    truncaterow(){
        $("#"+this.id+" tbody>tr").remove(); 
    }
    /**
     * @description Removes selected row
     * @returns {none}
     */
    deletecurrentrow(){
        $("#table_obj"+this.currentRowIndex).remove();
    }
    /**
     * 
     * @param {integer} index
     * @returns {none}
     */
    deleterow(index){
        $("#table_obj"+index).remove();
    }
    /**
     * @description Converts the html table to json format
     * @returns {JSON Format}
     */
    rowsToJSON(){
        var table = $('#'+this.id).tableToJSON(); 
        return JSON.stringify(table);
    }
    /**
     * @description return the total rows on tbody
     * @returns {_$.length|$.length}
     */
    totalcontentrows(){
       return this.contentrowcount; 
    }  
};
