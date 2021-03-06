//Tipos de alertas -- "alert-error","alert-success","alert-info","alert-warning"
function mostrarMensaje(message, alerttype) {
    var type = "";
    switch(alerttype) {
        case "alert-danger":
            type = "Error:";
            break;
        case "alert-success":
            type = "Satisfactorio:";
            break;
        case "alert-info":
            type = "Info:";
            break;
        case "alert-warning":
            type = "Cuidado:";
            break; 
    }
    $('#alert_placeholder').html('<div id="alertdiv" class="alert ' + alerttype + '" role="alert"><a class="close" data-dismiss="alert">×</a><span><strong>'+type+'</strong> '+message+'</span></div>');
    setTimeout(function() { // se cierra automaticamente en 5 segundos
        $("#alertdiv").remove();
    }, 5000);
}   

function resetearFormulario() {
    $(':input')
      .removeAttr('checked')
      .removeAttr('selected')
      .not(':button, :submit, :reset, :hidden, :radio, :checkbox')
      .val('');            
}

//Tipo - vacio, numerico, fecha
function manejoMensajes(tipo, campo) {
    var mensaje = "";
    switch(tipo) {
        case "vacio":
            mensaje = "El campo "+campo+" no puede ser vacio"; 
            break;
        case "numerico":
            mensaje = "El campo "+campo+" debe ser numerico"; 
            break; 
        case "fecha":
            mensaje = "El campo "+campo+" debe ser una fecha, con formato Año/mes/dia"; 
            break;                    
    }
    return mensaje;
}

function isValidDate(s) {
    var bits = s.split('/');
    var d = new Date(bits[0], bits[1] - 1, bits[2]);
    return d && (d.getMonth() + 1) == bits[1];
}    

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function ordenamiento() {
    $("#th_order").removeClass();
    if($("#ordenamiento").val() == "") {
        $("#ordenamiento").val("SORT_ASC");
        $("#th_order").addClass("glyphicon glyphicon-triangle-top");
    }else if($("#ordenamiento").val() == "SORT_ASC") {
        $("#ordenamiento").val("SORT_DESC");
        $("#th_order").addClass("glyphicon glyphicon-triangle-bottom");
    }else {
        $("#ordenamiento").val("SORT_ASC");
        $("#th_order").addClass("glyphicon glyphicon-triangle-top");
    }
    return true;
}

function printDiv() {
    var divToPrint=document.getElementById('printDiv');
    var newWin=window.open('','Print-Window');
    newWin.document.open();
    newWin.document.write('<html> <script src="assets/js/jquery.min.js"></script> <link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" /> <body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
    newWin.document.close();
    setTimeout(function(){newWin.close();},10);
}   