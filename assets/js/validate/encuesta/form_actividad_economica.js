$( document ).ready( function () {

//nueva regla para terminar la encuesta
jQuery.validator.addMethod("campoTerminar", function(value, element, param) {
	var actividad = $('#actividad').val();
	if (actividad != 16 && actividad != 17 && actividad != 18 && value == "") {
		return false;
	}else{
		return true;
	}
}, "Este campo es requerido.");

//nueva regla para terminar la encuesta
jQuery.validator.addMethod("campoTerminar2", function(value, element, param) {
	var actividad = $('#actividad').val();
	var numero_personas = $('#numero_personas').val();
	if (actividad != 16 && actividad != 17 && actividad != 18 && numero_personas <= 9 && value == "") {
		return false;
	}else{
			return true;
	}
}, "Este campo es requerido.");

$("#numero_personas").bloquearTexto().maxlength(3);
$("#descripcion").convertirMayuscula();
			
	$( "#form" ).validate( {
		rules: {
			actividad:			{ required: true },
			division:			{ campoTerminar: "#actividad" },
			descripcion:		{ campoTerminar: "#actividad" },
			numero_personas:	{ campoTerminar: "#actividad", number: true, maxlength:3 },
			seguridad_social:	{ campoTerminar2: "#actividad, #numero_personas" },
			lugar:				{ campoTerminar2: "#actividad, #numero_personas" }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-8" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-8" ).addClass( "has-success" ).removeClass( "has-error" );
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
					url: base_url + "encuesta/save_form_actividad_economica",	
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