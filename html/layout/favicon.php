<?php
/*
 * Ícone do separador (favicon) com o logótipo ReservaJá.
 * Incluir dentro do <head> de todas as páginas.
 */
$faviconBase = $appBasePath ?? '';
?>
<link rel="icon" type="image/svg+xml" href="<?= $faviconBase ?>/asset/image/Img/logo.svg">
<link rel="icon" type="image/png" sizes="180x180" href="<?= $faviconBase ?>/asset/image/favicon.png">
<link rel="apple-touch-icon" href="<?= $faviconBase ?>/asset/image/favicon.png">
