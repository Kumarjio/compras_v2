 jQuery.fn.forceNumeric = function () {

     return this.each(function () {
	 $(this).keydown(function (e) {
	     var key = e.which || e.keyCode;

	     if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
		      // numbers   
			  key >= 48 && key <= 57 ||
		      // Numeric keypad
			  key >= 96 && key <= 105 ||
		      // comma, period and minus, . on keypad
			 key == 190 || key == 188 || key == 109 || key == 110 ||
		      // Backspace and Tab and Enter
			 key == 8 || key == 9 || key == 13 ||
		      // Home and End
			 key == 35 || key == 36 ||
		      // left and right arrows
			 key == 37 || key == 39 ||
		      // Del and Ins
		 key == 46 || key == 45)
		 return true;

	     return false;
	 });
     });
 }

function alSalir(){

    $(window).on("beforeunload", function(e){
	if($("#form_saved").val() != "" || me_puedo_ir){return;}
	var e = e || window.event;
	e.returnValue = "La información ingresada no se ha guardado. Si abandona esta página, la información se perderá. Que quiere hacer?";
	return "La información ingresada no se ha guardado. Si abandona esta página, la información se perderá. Que quiere hacer?";
    });

}




function syncFields2(){

    $(':input').live({
	click: function(){
	    if(this.type == "text"){
		$(this).attr("data-sync", false);
	    }
	},
	change: function(){
	    if(this.type == "select-one" || this.id.match(/OrdenSolicitud_fechaentrega_\d/)){
		$(this).attr("data-sync", false);
	    }
	},
	keyup: function(){
	    if(this.type == "text" || this.type == "textarea"){
		$(this).attr("data-sync", false);
	    }
	}
    });

}


function autoSaveSol(id){
    var forma = $(':input').filter(function() {
        return this.id.match(/Orden_*/);
    }).serialize();


    $(":input").live("blur",function(e){
	if(this.id.match(/Orden_\w/)){
	    var forma = $(':input').filter(function() {
		var is_orden =  this.id.match(/Orden_\w/)
		var is_unsync = false;
		
		try { is_unsync = $(this).attr("data-sync").match(/false/); }catch(e){}
		return is_unsync && is_orden;
	    }).serialize();
	    var input_ev = this;
	    jQuery.ajax(
		{
		    url:'/index.php/orden/autosave/id/'+id,
		    type : 'post',
		    data: forma,
		    success: function(data) {
			$(input_ev).attr("data-sync",true);
		    }
		}
	    );
	}
	
    });
}

function autoSaveProd(){
    $(":input").live({
	blur: function(){
	    if(this.id.match(/OrdenSolicitud_*/)){
		    $("div").filter(function(){
			return this.id.match(/orden-solicitud-\d/);
		    }).each(function(n,el){

			var the_div = el;
			var id_parts = el.id.split("-");
			var campos = $("#"+el.id+" :input").filter(function(){
			    try{ return $(this).attr("data-sync").match(/false/) } catch (e){ return false; };
			});

			if(campos.length){
			    var forma = campos.serialize();
			    jQuery.ajax(
				{
				    url:'/index.php/orden/autosavesol/id/'+id_parts[2],
				    type : 'post',
				    data: forma,
				    success: function(data) {
					$("#"+the_div.id+" :input").attr("data-sync",true);
				    }
				}
			    );

			}
		    });
		}
	}
	});
}


function catchBackspace(){
    $(document).keydown(function(e){
	var key = e.which || e.keyCode;
	var elid = $(document.activeElement).is("input:focus, textarea:focus");
	if(e.keyCode === 8 && !elid){ 
	    return false; 
	}
    });
}

$(function(){
    $(".numeric").live("keydown", function (e) {
	     var key = e.which || e.keyCode;

	     if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
		      // numbers   
			  key >= 48 && key <= 57 ||
		      // Numeric keypad
			  key >= 96 && key <= 105 ||
		      // comma, period and minus, . on keypad
			 key == 190 || key == 188 || key == 109 || key == 110 ||
		      // Backspace and Tab and Enter
			 key == 8 || key == 9 || key == 13 ||
		      // Home and End
			 key == 35 || key == 36 ||
		      // left and right arrows
			 key == 37 || key == 39 ||
		      // Del and Ins
		 key == 46 || key == 45)
		 return true;

	     return false;
    });
});

function showProductsWithErrors(){
	$('.accordion-body.collapse.in').collapse('hide');
	setTimeout(function(){$('.accordion-body.collapse .alert-error').parents().filter(function(){try{return $(this).attr("class").match(/collapse/);}catch(e){return false;}}).collapse('show');}, 2000);
}

function updateProductNumber(){
	$('.numero-producto').each(function(i, e){$(e).html(i+1);});
}

function resetGridView(id){
	$('#'+id+' input').val('');
	var data = $('#'+id+' input').serialize();
	$('#' + id).yiiGridView('update', {data: data});
}

$(function(){
	$('.filter-container input').live("keydown",function(event){ 
		if(event.keyCode == 13){
			var divid = $(this).parents().filter(function(){ 
					try{return $(this).attr("class").match(/grid-view/);} 
					catch(e){ return false; } 
				}).attr("id");
			var data = $("#"+divid+" :input").serialize();
			$('#' + divid).yiiGridView('update', {data: data});
			//$('#'+divid).yiiGridView.update(divid);
		} 
	});
	if($('.accordion-body.collapse').size() > 1){
		$('.accordion-body.collapse').collapse('hide');
	}
	
	updateProductNumber();
});