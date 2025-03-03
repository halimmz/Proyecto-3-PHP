<?php
function render_template($template, $data = []) {
    // lógica para renderizar plantillas
    extract($data);
    include "templates/$template.php";
}