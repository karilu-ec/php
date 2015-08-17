<?php

$date = new DateTime('2015-08-17 02:30 UTC');
echo $date->format('Y-m-d h:i');
echo"<br>";
echo $date->format('U');
echo"<br>";
echo $date->getTimestamp();
echo"<br>Date2:";echo"<br>";
$date2 = new DateTime('2015-08-17 02:30', new DateTimeZone('UTC'));
echo $date2->format('Y-m-d h:i:sP');
echo"<br>";
echo $date2->getTimestamp();
?>