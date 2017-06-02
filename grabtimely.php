<?php

$ics = file_get_contents('http://mohankumargupta.com/melbpcwordpressmultisite/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events&no_html=true');
echo($ics);