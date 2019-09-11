/**
 * Seccion, sector, manzana, comuna
 * @since  22/9/2017
 */

$(document).ready(function () {
	    
    $('#actividad').change(function () {
        $('#actividad option:selected').each(function () {
            var actividad = $('#actividad').val();
            if (actividad > 0 || actividad != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'encuesta/divisionList',
                    data: {'identificador': actividad},
                    cache: false,
                    success: function (data)
                    {
                        $('#division').html(data);
                    }
                });
            } else {
                var data = '';
                $('#division').html(data);
            }
        });
    });
	
	
	
	
    
});