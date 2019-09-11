<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>


<script type="text/javascript">

$(document).ready(function()
{
 /**
    *@desc- retrasa el evento keyup
    *@param fn - function
    *@param ms - milisegundos que queremos retrasar
    */
    $.fn.delayPasteKeyUp = function(fn, ms)
    {
        var timer = 0;
        $(this).on("keyup paste", function()
        {
            clearTimeout(timer);
            timer = setTimeout(fn, ms);
        });
    };
 
    $("input[name=nombre]").delayPasteKeyUp(function()
    {
        $.ajax({
        	type: "POST",
			url: base_url + 'busqueda/nombreList',
            data: "nombre="+$("input[name=nombre]").val(),
            success: function(data)
            {
            	if(data)
            	{
             var json = JSON.parse(data),
             html = '<div class="list-group">';
             if(json.res == 'full')
             {
             for(datos in json.data)
             {
             html+='<a href="#" onclick="info('+json.data[datos].id_establecimiento+',\''+json.data[datos].nombre_propietario+'\')" class="list-group-item">';
             //html+='<h4  class="list-group-item-heading">ID:' + json.data[datos].id_establecimiento;
             html+='<h4  class="list-group-item-heading">' + json.data[datos].nombre_propietario+'</h4>';
             html+='</a>';
             }
             }
             else
             {
             html+='<a href="#" class="list-group-item">';
         html+='<h4 class="list-group-item-heading">No se ha encontrado nada con '+$("input[name=nombre]").val()+'</h4>';
         html+='</a>';
             }
             html+='</div>';
             $("#busqueda").html("").append(html);
            	}
            }
        });
    }, 500);
 
 $(document).on("click", "a", function()
 {
 $("a").removeClass("active");
 $(this).addClass("active");
 })
});
 
//al pulsar en los enlaces muestra su información
function info(id,nombre)
{
		$("#nombre").val(nombre).val();
		//alert("ID: " + id + " Nombre: " + nombre);
} 
</script>




        <div id="page-wrapper">
			<br>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> BUSCAR
                        </div>
                        <div class="panel-body">
							<div class="alert alert-info">
								<strong>Nota:</strong> 
								Filtre por uno de los siguientes campos
							</div>
									<form  name="form" id="form" role="form" method="post" class="form-horizontal" >

									
							

									
									
									
									
									
                                        <div class="form-group">
											<div class="col-sm-1">
											
											<div class="row" align="center">
												<div style="width80%;" align="center">
	<br>												
<button type="submit" class="btn btn-primary" id='btnSubmit' name='btnSubmit'><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar </button>
													
												</div>
											</div>
											
												
											</div>
											<div class="col-sm-2">
												<label for="idEncuesta">No. Formulario:</label>
												<input type="text" id="idEncuesta" name="idEncuesta" class="form-control" placeholder="No. Formulario" >
											</div>
											<div class="col-sm-5">
												<label for="nombre">Nombre comercial, razón social o nombre del propietario :</label>
												<input type="search" id="nombre" name="nombre" class="form-control" placeholder="Nombre comercial, razón social o nombre del propietario " >
												 <div id="busqueda"></div>
											</div>
											<div class="col-sm-4">
												<label for="documento">No. Documento :</label>
												<input type="text" id="documento" name="documento" class="form-control" placeholder="No. Documento" >
											</div>
                                        </div>

										
                                    </form>

								</div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->