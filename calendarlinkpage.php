<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

date_default_timezone_set('Australia/Melbourne');

$dompdf = new Dompdf();
$dompdf->set_option('chroot', '/calendarmelbpc');
$dompdf->set_option('isRemoteEnabled', true);
$dompdf->loadHtmlFile('calendar.html');
$dompdf->set_paper('A4', 'portrait');

$dompdf->render();
$dompdf->stream('document.pdf', array("Attachment" => false));