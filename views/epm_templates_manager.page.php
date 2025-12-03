<?php
        if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

        if ($_REQUEST['subpage'] != "manager") {
                echo "Pagina no valida!";
                return;
        }


        $product_list = "SELECT * FROM endpointman_product_list WHERE id > 0";
        $product_list =sql($product_list,'getAll', DB_FETCHMODE_ASSOC);

        $mac_list = "SELECT * FROM endpointman_mac_list";
        $mac_list =sql($mac_list, 'getAll', DB_FETCHMODE_ASSOC);

        if((!$product_list) && (!$mac_list)) {
                echo '<div class="alert alert-warning" role="alert">';
                echo '<strong>'._("Warning!").'</strong>'.(" Welcome to Endpoint Manager. You have no products (Modules) installed, click").' <a href="config.php?display=epm_config"><b>'._("here").'</b></a> '._(" to install some");
                echo '</div>';
                return;
        }
        elseif(!$product_list) {
                echo '<div class="alert alert-warning" role="alert">';
                echo '<strong>'._("Warning!").'</strong>'.(" Thanks for upgrading to version 2.0! Please head on over to ").' <a href="config.php?display=epm_config"><b>'._("Brand Configurations/Setup").'</b></a> '._(" to setup and install phone configurations");
                echo '</div>';
                return;
        }
        unset ($product_list);
        unset ($mac_list);


        echo load_view(__DIR__.'/epm_templates/manager.views.grid.php', array('request' => $_REQUEST));
        echo load_view(__DIR__.'/epm_templates/manager.views.new.modal.php', array('request' => $_REQUEST));

        // --- INYECCIÓN DE SCRIPTS / POLYFILLS PARA EVITAR ERRORES DE LOCALES ---
        // Ajustá la ruta base si tu instalación usa otra carpeta
        $base = '/admin/assets/endpointman/js/';

        // Polyfill jQuery.browser (evita 'd.browser is undefined' en plugins antiguos)
        echo '<script>';
        echo 'if (typeof jQuery !== "undefined" && typeof jQuery.browser === "undefined") {';
        echo '  jQuery.browser = {}; (function(){ var ua = navigator.userAgent.toLowerCase(); jQuery.browser.msie = /msie|trident/.test(ua); jQuery.browser.version = (ua.match(/(?:msie |rv:)(\d+(\.\d+)?)/) || [])[1] || ""; })();';
        echo '}';
        echo '</script>';

        // Cargar core y luego locales del ajax-bootstrap-select
        echo '<script src="'.$base.'ajax-bootstrap-select.js"></script>';
        echo '<script src="'.$base.'ajax-bootstrap-select.en-US.js"></script>';
        echo '<script src="'.$base.'ajax-bootstrap-select.es-ES.js"></script>';

        // Guard ligero para evitar que la falta del plugin aborte la ejecución
        echo '<script>';
        echo 'if (typeof jQuery === "undefined" || typeof jQuery.fn === "undefined" || typeof jQuery.fn.ajaxSelectPicker === "undefined") {';
        echo '    console.warn("ajaxSelectPicker no está disponible: algunos select locales pueden ser ignorados y ciertas funciones quedarían deshabilitadas.");';
        echo '}';
        echo '</script>';

        // Incluir js del módulo (si aplica)
        echo '<script src="'.$base.'epm_templates.js"></script>';
        // --- FIN INYECCIÓN ---
 
/*
 <script type="text/javascript" charset="utf-8">
 $(function(){
 $("select#model_class").change(function(){
 $.ajaxSetup({ cache: false });
 $.getJSON("config.php?type=tool&quietmode=1&handler=file&module=endpointman&file=ajax_select.html.php&atype=model_clone",{id: $(this).val()}, function(j){
 var options = '';
 for (var i = 0; i < j.length; i++) {
 options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
 }
 $("#model_clone").html(options);
 $('#model_clone option:first').attr('selected', 'selected');
 })
 })
 })
 </script>
 */
?>
