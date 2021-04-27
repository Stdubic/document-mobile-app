<?php

$state = $value ? 'success' : 'danger';
$label = $value ? 'Yes' : 'No';

?>

<span class="m-badge m-badge--{{ $state }} m-badge--wide">{{ $label }}</span>