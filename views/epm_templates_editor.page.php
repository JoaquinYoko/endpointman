<?php
        if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

        if ($_REQUEST['subpage'] != "editor") {
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


        if ((! isset($_REQUEST['idsel'])) || (! isset($_REQUEST['custom'])))
        {
                echo '<div class="alert alert-warning" role="alert">';
                echo '<strong>'._("Warning!").'</strong>'.(" No select ID o Custom!");
                echo '</div>';
                return;
        }
        $dtemplate = FreePBX::Endpointman()->epm_templates->edit_template_display($_REQUEST['idsel'],$_REQUEST['custom']);

        echo load_view(__DIR__.'/epm_templates/editor.views.template.php', array('request' => $_REQUEST, 'dtemplate' => $dtemplate ));
        echo load_view(__DIR__.'/epm_templates/editor.views.dialog.cfg.global.php', array('request' => $_REQUEST));
        echo load_view(__DIR__.'/epm_templates/editor.views.dialog.edit.cfg.php', array('request' => $_REQUEST, 'dtemplate' => $dtemplate ));

        // --- INYECCIÓN DE SCRIPTS / POLYFILLS PARA EVITAR ERRORES DE LOCALES ---
        // Ajustá la ruta base si tu instalación usa una carpeta distinta
        $base = '/admin/assets/endpointman/js/';

        // Polyfill jQuery.browser (previene 'd.browser is undefined' en plugins viejos)
        echo '<script>';
        echo 'if (typeof jQuery !== "undefined" && typeof jQuery.browser === "undefined") {';
        echo '  jQuery.browser = {}; (function(){ var ua = navigator.userAgent.toLowerCase(); jQuery.browser.msie = /msie|trident/.test(ua); jQuery.browser.version = (ua.match(/(?:msie |rv:)(\d+(\.\d+)?)/) || [])[1] || ""; })();';
        echo '}';
        echo '</script>';

        // Intentar cargar core del plugin ajax-bootstrap-select primero
        echo '<script src="'.$base.'ajax-bootstrap-select.js"></script>';

        // Cargar ficheros de idioma (si el core no existe, añadimos guard abajo)
        echo '<script src="'.$base.'ajax-bootstrap-select.en-US.js"></script>';
        echo '<script src="'.$base.'ajax-bootstrap-select.es-ES.js"></script>';

        // Guard ligero que avisa si el plugin no está definido para evitar abortos
        echo '<script>';
        echo 'if (typeof jQuery === "undefined" || typeof jQuery.fn === "undefined" || typeof jQuery.fn.ajaxSelectPicker === "undefined") {';
        echo '    console.warn("ajaxSelectPicker no está disponible: algunos select locales pueden ser ignorados y ciertas funciones quedarían deshabilitadas.");';
        echo '}';
        echo '</script>';

        // Incluir el JS específico del módulo (epm_templates.js)
        echo '<script src="'.$base.'epm_templates.js"></script>';
        // --- FIN INYECCIÓN ---

        unset ($dtemplate);
?>
