let xam = "fun", a = "sw", z = "ctions", br = "ap.", zar = "php";
let xet =  xam + z + '/' + a;

$body = $("body");

$(document).on({
	ajaxStart: function () { $body.addClass("loading"); },
	ajaxStop: function () { $body.removeClass("loading"); }
});

function rldescend(cv){
	let htp = xet + br + zar;
	$.post(htp,{exec:cv} , function(data){
		$("#main-content").html(data).show();
		$body.removeClass("loading");
	});
}

function nuovoVeic(cv){
	let htp = xet + br + zar;
	$.post(htp,{exec:cv} , function(data){
		$("#nuovomezzo").html(data).show();
		$body.removeClass("loading");
	});
}

function dAzN(pag){
  // var dada = document.getElementById("dataDa").value;
  // var daa = document.getElementById("dataA").value;
  if (typeof intervallo !== "undefined") {
    clearInterval(intervallo);
  }
  // rldescend({ "fxf": "pp", "c1": pag, "pag": pag, "da": dada, "a": daa});
  rldescend({ "fxf": "pp", "c1": pag, "pag": pag});
  if ($(window).width() < 560) {
    document.getElementById('nav-accordion').style.display = 'none';
  }
}

function clearR(){
  if ($(window).width() < 560) {
    document.getElementById('nav-accordion').style.display = 'none';
  }
}

function dAzNid(pag, id){
  rldescend({"fxf" : "pid", "c1":pag, "pag": pag, "id": id});
}

function dAzNids(pag, id, cosa) {

  var r = confirm('Eliminare ' + cosa + '?');
  if(r){
    rldescend({
      fxf: "full",
      c1: "cancella",
      pag: "cancella",
      id: id,
      cosa: cosa
    });
  }
}

function dAzNidsV2(pag, id, progressivo, cosa) {

  var r = confirm('Eliminare la data di uscita del ' + cosa + '?');
  if(r){
    rldescend({
      fxf: "full",
      c1: pag,
      pag: pag,
      progressivo: progressivo,
      id: id,
      cosa: cosa
    });
  }
}

function activatepag(pag) {
  var dada = document.getElementById("dataDa").value;
  var daa = document.getElementById("dataA").value;
  rldescend({ "fxf": "pp", "c1": pag, "da": dada, "a": daa }); return false;
}

function activate() {
  var dada = document.getElementById("dataDa").value;
  var daa = document.getElementById("dataA").value;
  rldescend({ "fxf": "pp", "c1": "tabella", "da": dada, "a": daa }); return false;
}

function activateS(sede) {
  var dada = document.getElementById("dataDa").value;
  var daa = document.getElementById("dataA").value;
  rldescend({ "fxf": "pp", "c1": "tabellasede", "sede": sede, "da": dada, "a": daa });
  if ($(window).width() < 560) {
    document.getElementById('nav-accordion').style.display = 'none';
  }
  return false;
}

function activateOp(operatore) {
  var dada = document.getElementById("dataDa").value;
  var daa = document.getElementById("dataA").value;
  rldescend({ "fxf": "pp", "c1": "tabellaoperatore", "operatore": operatore, "da": dada, "a": daa });
}

function activateP(dax, daax) {
  document.getElementById("dataDa").value = dax;
  document.getElementById("dataA").value = daax;
  rldescend({ "fxf": "pp", "c1": "home", "da": dax, "a": daax }); return false;
}

function activatePs(sede, dax, daax) {
  // document.getElementById("dataDa").value = dax;
  // document.getElementById("dataA").value = daax;
	rldescend({ "fxf": "pp", "c1": "tabellasede", "sede": sede, "da": dax, "a": daax }); return false;
}

function selectMenu(page){
  var gg = page.charAt(0).toUpperCase() + page.slice(1);
  var par = $('li.active');
  par.removeClass("active");
  $('a.dcjq-parent.active').removeClass("active");
  $("li > a:contains("+ gg +")").parent().addClass("active");
  $("li > a:contains("+ gg +")").removeClass("active");

  setTimeout(function(){
    var par = $('li.active');
    var x = par[0].offsetParent.children[0];
    x.className += " active";
  }, 500);
}
