<?php
$menu_title = SW_PROJECT_TITLE;
$menu = array (
	array ( "language" => "en_gb", "report" => ".*\.xml", "title" => "<AUTO>" )
	);
?>
<?php
$menu_title = SW_PROJECT_TITLE;
$menu = array (
	array ( "report" => "<p>En el menú superior encuentra los reportes que se pueden generar para verlos en pantalla, descargarlos a PDF, o CSV.</p><p><a style=\"text-decoration: underline !important\"  target=\"_self\" href=\"https://www.ceiv-ccv.com\">Regresar</a></p>", "title" => "TEXT" ),
	);

$admin_menu = $menu;


$dropdown_menu = array(
                    array ( 
                        "project" => "CEIV-CCV",
                        "title" => "Reportes",
                        "items" => array (
                            array ( "reportfile" => "Encuestas.xml" )//,
							//array ( "reportfile" => "Lista_establecimientos.xml" ),
                            )
                        ),
                );

?>
