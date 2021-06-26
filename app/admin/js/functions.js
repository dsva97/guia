function fncOcultarLoader() {
  $(".page-loader").fadeOut();
}

function fncMostrarLoader() {
  $(".page-loader").fadeIn();
}

function fncClearInputs(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      switch (this.type) {
        case "number":
          if (this.name.substring(0, 9) == "nCantidad") {
            $(this).val(1);
          } else {
            $(this).val(0);
          }

          break;
        case "select-one":
        case "select-multiple":
          if (this.name.substring(0, 7) == "nEstado"|| this.name.substring(0, 6) == "estado") {
            $(this).val(1);
          } else {
            $(this).val(0);
          }
          break;
        case "file":
          $(this).val("");
          var attr = $(this).attr("multiple");
          if (typeof attr !== typeof undefined && attr !== false) {
            $(this)
              .parent()
              .find(".custom-file-label")
              .html("Seleccione los archivos");
          } else {
            $(this)
              .parent()
              .find(".custom-file-label")
              .html("Selecciona un archivo");
          }
          break;
        case "email":
        case "password":
        case "text":
        case "date":
        case "time":
        case "tel":
        case "textarea":
          $(this).val("");
          break;
        case "checkbox":
        case "radio":
          this.checked = bFlag;
      }
    });
}

function fncAddDisabled(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(".modal-body")
    .find(":input")
    .each(function () {
      $(this).attr("disabled", "disabled");
    });

  $(sHtmlTag)
    .find(".modal-footer")
    .find(":input")
    .each(function () {
      $(this).attr("disabled", "disabled");
    });
}

function fncRemoveDisabled(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      $(this).removeAttr("disabled");
    });
}

function fncAddDisabledForm(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      $(this).attr("disabled", "disabled");
    });
}

function fncRemoveDisabledForm(sHtmlTag, bFlag = false) {
  $(sHtmlTag)
    .find(":input")
    .each(function () {
      $(this).removeAttr("disabled");
    });
}

function fncViewForm(sHtmlTag, sTitle) {
  $(sHtmlTag).find(".modal-dialog").find(".modal-title").html(sTitle);
  fncAddDisabled(sHtmlTag);
}

function fncEditForm(sHtmlTag, sTitle) {
  $(sHtmlTag).find(".modal-dialog").find(".modal-title").html(sTitle);
  fncRemoveDisabled(sHtmlTag);
}
 


function sp(input, pad = "00000000") {
  var str = "" + input;
  return pad.substring(0, pad.length - str.length) + str;
}



function pf(input) {
  return parseFloat(input).toFixed(2);
}



function fncGetNameMesById(nIdMes)
{
     var mes = "";
    nIdMes = parseInt(nIdMes);
    switch (nIdMes) {
        case "01":
        case 1:
            mes = "Enero";
            break;
        case "02":
        case 2:
            mes = "Febrero";
            break;
        case "03":
        case 3:
            mes = "Marzo";
            break;
        case "04":
        case 4:
            mes = "Abril";
            break;
        case "05":
        case 5:
            mes = "Mayo";
            break;
        case "06":
        case 6:
            mes = "Junio";
            break;
        case "07":
        case 7:
            mes = "Julio";
            break;
        case "08":
        case 8:
            mes = "Agosto";
            break;
        case "09":
        case 9:
            mes = "Septiembre";
            break;
        case "10":
        case 10:
            mes = "Octubre";
            break;
        case "11":
        case 11:
            mes = "Noviembre";
            break;
        case "12":
        case 12:
            mes = "Diciembre";
            break;
    }
    return mes;
}

function src(path = "") {
  return web_root_resource + "img/" + path;
}

 
function route(path = "") {
  return web_root + path;
}
