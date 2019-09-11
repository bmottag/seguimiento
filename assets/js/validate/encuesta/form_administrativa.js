$( document ).ready( function () {
			
jQuery.validator.addMethod("campoCual", function(value, element, param) {
	var porqueno = $('#porqueno').val();
	if (porqueno == 6 && value == "") {
		return false;
	}else{
		return true;
	}
}, "Este campo es requerido.");

jQuery.validator.addMethod("campoPorqueno", function(value, element, param) {
	var matricula = $('#matricula').val();
	if (matricula != 1 && value == "") {
		return false;
	}else{
		return true;
	}
}, "Este campo es requerido.");

jQuery.validator.addMethod("campoTerminar", function(value, element, param) {
	var estado_actual = $('#estado_actual').val();
	if (estado_actual == 1 && value == "") {
		return false;
	}else{
		return true;
	}
}, "Este campo es requerido.");

jQuery.validator.addMethod("campoTerminar2", function(value, element, param) {
	var estado_actual = $('#estado_actual').val();
	var establecimiento = $('#establecimiento').val();
	if (estado_actual == 1 && value == "" && (establecimiento == 1 || establecimiento == 2 )) {
		return false;
	}else{
		return true;
	}
}, "Este campo es requerido.");

$("#cual").convertirMayuscula();
			
	$( "#form" ).validate( {
		rules: {
			visible:			{ required: true },
			aviso:				{ required: true },
			matricula:			{ required: true },
			porqueno:			{ campoPorqueno: "#matricula" },
			cual:				{ maxlength: 120, campoCual: "#porqueno" },
			establecimiento:	{ campoTerminar: "#estado_actual" },
			tiempo:				{ campoTerminar2: "#estado_actual, #establecimiento" },
			rut:				{ campoTerminar2: "#estado_actual, #establecimiento" }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});
	
			
	$("#btnSubmit").click(function(){		
	
		if ($("#form").valid() == true){
		
				//Activa icono guardando
				$('#btnSubmit').attr('disabled','-1');
				$("#div_guardado").css("display", "none");
				$("#div_error").css("display", "none");
				$("#div_msj").css("display", "none");
				$("#div_cargando").css("display", "inline");

			
				$.ajax({
					type: "POST",	
					url: base_url + "encuesta/save_form_administrativa",	
					data: $("#form").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
						if( data.result == "error" )
						{
							//alert(data.mensaje);
							$("#div_cargando").css("display", "none");
							$('#btnSubmit').removeAttr('disabled');							
							
							$("#span_msj").html(data.mensaje);
							$("#div_msj").css("display", "inline");
							return false;
						
						} 

						
										
						if( data.result )//true
						{	                                                        
							$("#div_cargando").css("display", "none");
							$("#div_guardado").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');

							var url = base_url + "encuesta/" + data.redireccionamiento;
							$(location).attr("href", url);
						}
						else
						{
							alert('Error. Reload the web page.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error. Reload the web page.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmit').removeAttr('disabled');
					}
					
		
				});	
		
		}//if			
	});

});