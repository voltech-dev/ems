function Generatefilter() {
    var divpart1 = '<tr><td width="200px"><select name="field[]" class="form-control form-control-sm" onchange=" rendersearchfield(this,this.options[this.selectedIndex].value)"><option> </option>';
    var divpart2;
    $("#thegrid thead tr th").each(function(i) {
        //var headName = this.innerHTML;
        var theadprop = new Array();
        theadprop.push($(this).data('dt'));
        theadprop.push($(this).data('type'));
        theadprop.push($(this).data('table'));       
        theadprop.push($(this).data('field'));        
        divpart2 += '<option value="' + theadprop + '">' + this.innerHTML + '</option>';
    });

    var divpart3 = ' </select></td><td width="200px"> <select name ="operator[]" class = "form-control form-control-sm " onchange="rendersearchfield_operator(this,this.options[this.selectedIndex].value)"> ' +
    '<option value="="> </option>' +
    '<option value="="> Equals </option>' +
    '<option value="like"> Like </option>' +
    '<option value = "!=" > Not Equals </option>' +
    '<option value=">"> Greater Than </option>' +
    '<option value="<"> Less Than </option>' +
    '<option value = ">=" > Greater Than Equals To </option>' +
    '<option value="<="> Less Than Equals To </option>' +
    '<option value="between"> Between </option>' +     
    '< /select >  </td><td width="500px"><input type ="text" name ="search[]" class = "ft-search form-control form-control-sm"/> </td>' +
    '<td><input class="extrafilterSubmit btn btn-sm btn-square btn-success px-6" type="button" value="Apply" /></td><td><input type="button" value="Remove" class="btn btn-sm removefilter" /></td></tr>';
    return divpart1 + divpart2 + divpart3;
}

function hideAllColunms() {
	$("#thegrid thead tr th").each(function(i){
		$("#thegrid td:nth-child("+ (i+1) +")").hide();
		$("#thegrid th:nth-child("+ (i+1) +")").hide();
	 });
}

function rendersearchfield(selectBox, val) { 
    $(selectBox).closest("tr").find("input[name^=search]").val('');
    $(selectBox).closest("tr").find("select[name^=operator]").val('');
    var filtertype = new Array();  
     filtertype = val.split(',');
    if(filtertype['1']=="date" || filtertype['1']=="datetime") {
        //remove datepicker and rangepicker
        $(selectBox).closest("tr").find('input[name^=search]').datepicker("destroy");

        if( $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker')) {
            $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker').remove();
          } 

        //assign between operator 
        $(selectBox).closest("tr").find("select[name^=operator]").val('between'); 

       //assign rangepicker
        $(selectBox).closest("tr").find('input[name^=search]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        
        $(selectBox).closest("tr").find('input[name^=search]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });
        $(selectBox).closest("tr").find('input[name^=search]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    }else {
        if( $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker')) {
            $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker').remove();
          } 
            $(selectBox).closest("tr").find('input[name^=search]').datepicker("destroy");
    }
}

function rendersearchfield_operator(selectBox, val) { 
    $(selectBox).closest("tr").find("input[name^=search]").val('');

    var filtertype = new Array();      

    filtertype = $(selectBox).closest("tr").find("select[name^=field]").val(); 
    filtertype = filtertype.split(',');    
    if(filtertype['1']=="date" || filtertype['1']=="datetime") {
        //remove datepicker and rangepicker
      if( $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker')) {
        $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker').remove();
      } 
        $(selectBox).closest("tr").find('input[name^=search]').datepicker("destroy");
        
            //assign datepicker and rangepicker
            if(val == "<=" || val == ">=" || val == "<" || val == ">" ||  val == "=") {                   
                $(selectBox).closest("tr").find('input[name^=search]').datepicker({ dateFormat: 'dd-mm-yy' });
            } 

            if(val == "between") {                    
            //assign rangepicker
                $(selectBox).closest("tr").find('input[name^=search]').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                });
                
                $(selectBox).closest("tr").find('input[name^=search]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                });
                $(selectBox).closest("tr").find('input[name^=search]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
            }
    } else {
        if( $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker')) {
            $(selectBox).closest("tr").find('input[name^=search]').data('daterangepicker').remove();
          } 
            $(selectBox).closest("tr").find('input[name^=search]').datepicker("destroy");
    }
}



$('#filterAdd').click(function(){
    $("#dsTable").append(Generatefilter());
});

$("#dsTable").on("click", ".removefilter", function() {
    $(this).closest("tr").remove();
 });

 $("#dsTable").on("click", ".extrafilterSubmit", function() {
    event.preventDefault();
    var arraydata = $("#filter").serializeArray();
    var arraydata_1 = $("#extrafilter").serializeArray();            
    $href = $("#pageurl").val();
   
    $.get($href, {
        'filter': arraydata,
        'extrafilter': arraydata_1
    }, function(response) {
        $('#thegrid').html(response);
        $("#showcolumn").trigger('click');
    });
 });

$(document).ready(function() {
    $("#thegrid thead tr th").each(function(i) {
        var hName = this.innerHTML;     
        var radioBtn = $('<div class="form-check form-check-inline">' +
         '<input class="form-check-input" type="checkbox"  name="chkbox" value="'+ (i+1)  +'" checked>' +
       '<label class="form-check-label" for="inlineCheckbox1">'+ hName+'</label></div>');
           radioBtn.appendTo('#checkboxarray');		  
          
     });

    $("#showcolumn").click(function(event) {
        hideAllColunms();       
		 var selectedItem = new Array();
            $("input:checkbox[name=chkbox]:checked").each(function() {             
			  selectedItem.push(this.value);
            }); 		
			if (selectedItem.length > 0) {
               for(var i=0; i<selectedItem.length; i++){
				var s = selectedItem[i];
				$("#thegrid th:nth-child("+ s +")").show();	
				$("#thegrid td:nth-child("+ s +")").show();				
				}
            }
    });

   $(document).on('click', '.pager a', function(event) {
        event.preventDefault();        
        var data_array = $("#filter").serializeArray();
        var data_array_1 = $("#extrafilter").serializeArray();
        var page = $(this).attr('href').split('page=')[1];        
        $href = $("#pageurl").val()+"?page=" + page;       
        $.get($href, {
            'filter': data_array,
            'extrafilter': data_array_1
        }, function(response) {
            $('#thegrid').html(response);
            $("#showcolumn").trigger('click');
        });
    });
   
   $("#filterSubmit").click(function(event) {
        event.preventDefault();
        var arraydata = $("#filter").serializeArray();
        var arraydata_1 = $("#extrafilter").serializeArray();            
        $href = $("#pageurl").val();
       
        $.get($href, {
            'filter': arraydata,
            'extrafilter': arraydata_1
        }, function(response) {
            $('#thegrid').html(response);
            $("#showcolumn").trigger('click');
        });
    });


    $("#export").click(function() {       
        $href = $("#exporturl").val();
        var arraydata = $("#filter").serializeArray();
        var arraydata_1 = $("#extrafilter").serializeArray();   

        var uncheckedarray = new Array();
        $("input:checkbox[name=chkbox]").each(function() {
            if(this.checked == false)             
            uncheckedarray.push(this.value);
          }); 
          
        var uncheckreverse = uncheckedarray.reverse();
        $.ajax({
            xhrFields: {
                responseType: 'blob',
            },          
            type: "post",
            url: $href,              
            data: {                              
                'filter': arraydata,
                'extrafilter': arraydata_1,
                'colVis': uncheckreverse
            },
    
            success: function(result, status, xhr) {
    
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'leads.xlsx');

               
                // The actual download
                var blob = new Blob([result], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
    
                document.body.appendChild(link);
    
                link.click();
                document.body.removeChild(link);
            },
    
        });
    });
    


});




