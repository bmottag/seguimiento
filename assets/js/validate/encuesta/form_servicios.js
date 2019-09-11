$( document ).ready( function () {

jQuery.validator.addMethod("campoCual", function(value, element, param) {
	var motivo = $('#motivo').val();
	if (motivo == 8 && value == "") {
		return false;
	}else{
		return true;
	}
}, "Este campo es requerido.");

jQuery.validator.addMethod("campoOtro", function(value, element, param) {
	var condiciones = $(param).is(":checked");
	if(condiciones && value == ""){
		return false;
	}else{
		return true;
	}
}, "Este campo es requerido.");

$("#cual_motivo").convertirMayuscula();
$("#cual_fortalecer").convertirMayuscula();
			
	$( "#form" ).validate( {
		rules: {
			motivo:					{ required: true },
			cual_motivo:			{ maxlength: 150, campoCual: "#motivo" },
			hddFortalecer:			{ required: true },
			cual_fortalecer:		{ maxlength: 150, campoOtro: "#otro" }
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
					url: base_url + "encuesta/save_form_servicios",	
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

							//var url = base_url + "encuesta/form_formalizacion/" + data.idFormulario;
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