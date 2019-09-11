/**
 * Seccion, sector, manzana, comuna, reemplazado, reemplazante
 * @since  02/10/2017
 */

$(document).ready(function () {
	
    $('#comuna').change(function () {
        $('#comuna option:selected').each(function () {
            var comuna = $('#comuna').val();
            if (comuna > 0 || comuna != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'encuesta/sectorList',
                    data: {'identificador': comuna},
                    cache: false,
                    success: function (data)
                    {
                        $('#sector').html(data);
						var borrar = '';
						$('#seccion').html(borrar);
						$('#manzana').html(borrar);
                    }
                });
            } else {
                var data = '';
                $('#sector').html(data);
            }
        });
    });
	
	
    $('#sector').change(function () {
        $('#sector option:selected').each(function () {
            var sector = $('#sector').val();
			var comuna = $('#comuna').val();
            if (sector > 0 || sector != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'encuesta/seccionList',
                    data: {'identificador': sector, 'comuna': comuna},
                    cache: false,
                    success: function (data)
                    {
                        $('#seccion').html(data);
						var borrar = '';
						$('#manzana').html(borrar);
                    }
                });
            } else {
                var data = '';
                $('#seccion').html(data);
            }
        });
    });
	
	
    $('#seccion').change(function () {
        $('#seccion option:selected').each(function () {
            var seccion = $('#seccion').val();
			var sector = $('#sector').val();
			var comuna = $('#comuna').val();
            if (seccion > 0 || seccion != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'encuesta/manzanaList',
                    data: {'identificador': seccion, 'sector': sector, 'comuna': comuna},
                    cache: false,
                    success: function (data)
                    {
                        $('#manzana').html(data);
                    }
                });
            } else {
                var data = '';
                $('#manzana').html(data);
            }
        });
    });


    $('#manzana').change(function () {
        $('#seccion option:selected').each(function () {
            var manzana = $('#manzana').val();
            var seccion = $('#seccion').val();
            var sector = $('#sector').val();
            var comuna = $('#comuna').val();
            if (manzana > 0 || manzana != '-') {
                $.ajax ({
                    type: 'POST',
                    url: base_url + 'reemplazo/reemplazosList',
                    data: {'identificador': manzana, 'seccion': seccion, 'sector': sector, 'comuna': comuna},
                    cache: false,
                    success: function (data)
                    {
                        $('#reemplazado').html(data);
                        $('#reemplazante').html(data);
                    }
                });
            } else {
                var data = '';
                $('#reemplazado').html(data);
                $('#reemplazante').html(data);
            }
        });
    });
    
});