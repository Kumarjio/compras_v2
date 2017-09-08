(function( root, factory ) {
    if( typeof define === 'function' && define.amd ) {
        // AMD module
        define( factory );
    } else {
        // Browser global
        root.viajes = factory();
    }
}(this, function () {

	var Common = {
		/**
		 * Adds an event listener in a browser safe way.
		 */
		bindEvent: function( element, ev, fn ) {
			if( element.addEventListener ) {
				element.addEventListener( ev, fn, false );
			}
			else {
				element.attachEvent( 'on' + ev, function(){
					//En IE8 this hace referencia a la ventana. Por eso
					// hacemos este binding para que haga referencia al
					// elemento (target del evento)
					return fn.apply(element);
				} );
			}
		},

		/**
		 * Removes an event listener in a browser safe way.
		 */
		unbindEvent: function( element, ev, fn ) {
			if( element.removeEventListener ) {
				element.removeEventListener( ev, fn, false );
			}
			else {
				element.detachEvent( 'on' + ev, fn );
			}
		},

		$ : function(selector){
			var elements = document.querySelectorAll(selector);
			var cuantos = elements.length;
			if (cuantos == 1){
				return elements[0];
			}else if (cuantos > 1){
				return elements;
			}else{
				return false;
			}
		},

		html : function(content){
			//TODO
		}


	};

	var MyModal = { 
		create : function (options){
			return (function(){
				if(!options && !options.element){
					throw "Debe especificar el elemento que usará como modal";
				}

				var is_open = false;

				var dom = {
					contentDivId: "#meny-content",
					el : options.element
				};

				function open(){
					if(!is_open){
						$(dom.el).animate({"left": "+=600px"}, "fast");
						is_open = true;
					}
					//dom.el.style.marginLeft = '0';
				}

				function close(){
					if(is_open){
						$(dom.el).animate({"left": "-=600px"}, "fast");
						is_open = false;	
					}
					
					
				}

				function configure(){
					$(dom.el).bind('mousewheel DOMMouseScroll', function(e) {
					    var scrollTo = null;

					    if (e.type == 'mousewheel') {
					        scrollTo = (e.originalEvent.wheelDelta * -1);
					    }
					    else if (e.type == 'DOMMouseScroll') {
					        scrollTo = 40 * e.originalEvent.detail;
					    }

					    if (scrollTo) {
					        e.preventDefault();
					        $(this).scrollTop(scrollTo + $(this).scrollTop());
					    }
					});
				}

				return {
					content: dom.contentDivId,
					configure: configure,
					open: open,
					close: close
				}
			})();
		}
	};

	/*
	* input_sel : Input selector
	* results_sel : Div to contain de results div
	* on_select : Function to be attached on the returned elements to select one of them
	*/
	var MyComplete = function(input_sel, results_sel, on_select){
		var currentRequest = null;

		if (!input_sel || !results_sel || !on_select){
			throw "Error creating the complete element";
		}
		var el = Common.$(input_sel);
		if(el){
			Common.bindEvent(el, "keyup", function(){
				if(currentRequest){
					currentRequest.abort();
				}
				var input = this;

				currentRequest = $.ajax({
                    url: input.getAttribute("data-url") + "/query/"+ input.value,
                    type: "get",
                    dataType: "json"
                }).done(function (data) {
                    currentRequest = null;
                    $(results_sel).html(data.content);
                    on_select();
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    //alert("No hay conexion con el servicio");
                });
					
			});
		}

	}

	return {
		MyModal : MyModal,
		MyComplete : MyComplete,
		Common: Common
	};
}));
