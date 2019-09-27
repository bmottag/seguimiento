$( document ).ready( function () {
	
	$("#numeroPuesto").bloquearTexto().maxlength(12);
	$("#nombrePuesto").convertirMayuscula();
	$("#idLocalidad").bloquearTexto().maxlength(5);
	$("#localidad").convertirMayuscula();
	$("#numeroMesas").bloquearTexto().maxlength(12);
	$("#circunscripcion").bloquearTexto().maxlength(3);
	
	$( "#form" ).validate( {
		rules: {
			numeroPuesto:		{ required: true, minlength: 3, maxlength:12 },
			nombrePuesto:		{ required: true, minlength: 3, maxlength:120 },
			depto:				{ required: true },
			mcpio:				{ required: true },
			idLocalidad:		{ required: true, minlength: 1, maxlength:5 },
			localidad:			{ required: true, minlength: 3, maxlength:120 },
			numeroMesas:		{ required: true, number: true, minlength: 1, maxlength:10 },
			circunscripcion:	{ required: true, minlength: 1, maxlength:3 }
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			// Add the `help-block` class to the error element
			error.addClass( "help-block" );
			error.insertAfter( element );

		},
		highlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-error" ).removeClass( "has-success" );
		},
		unhighlight: function (element, errorClass, validClass) {
			$( element ).parents( ".col-sm-6" ).addClass( "has-success" ).removeClass( "has-error" );
		},
		submitHandler: function (form) {
			return true;
		}
	});
	
	$("#btnSubmit").click(function(){		
	
		if ($("#form").valid() == true){
		
				//Activa icono guardando
				$('#btnSubmit').attr('disabled','-1');
				$("#div_error").css("display", "none");
				$("#div_load").css("display", "inline");
			
				$.ajax({
					type: "POST",	
					url: base_url + "admin/save_puesto",	
					data: $("#form").serialize(),
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
						if( data.result == "error" )
						{						
								$("#div_load").css("display", "none");
								$("#div_error").css("display", "inline");
								$("#span_msj").html(data.mensaje);
								$('#btnSubmit').removeAttr('disabled');
								alert(data.mensaje);
								return false;							
						} 

						if( data.result )//true
						{	                                                        
							$("#div_load").css("display", "none");
							$('#btnSubmit').removeAttr('disabled');

							var url = base_url + "admin/puestos";
							$(location).attr("href", url);
						}
						else
						{
							alert('Error. Reload the web page.');
							$("#div_load").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnSubmit').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error. Reload the web page.');
						$("#div_load").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnSubmit').removeAttr('disabled');
					}
					
		
				});	
		
		}//if			
	});
});