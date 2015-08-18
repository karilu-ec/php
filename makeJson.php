<?php
ini_set("memory_limit","512M");
//$handle = @fopen("mrho1h2014.txt", "r");
//$file = "MRH01-2014.json";
$handle = fopen("MRHO1.txt", "r");
$file = "MRH01-alt.json";
if ($handle) {
    $i=0;
    $keys = [];
    $weatherData = [];
    $obsData = [];
    while (($data = fgets($handle)) !== FALSE) {
        $data = rtrim($data);
        if ($i == 0) {
            $keys = preg_split("/\s+/", $data);
            array_splice($keys, 0, 5, "Date");
           // print_r($keys);
            //echo "<br >". count($keys);
            $i++;
            continue;
        }
        if ($i == 1) {//metrics desc
            $i++;
            continue;
        }
        $row = preg_split("/\s+/", $data);
        $dateString = $row[0] . "-" . $row[1] . "-" . $row[2] . " " . $row[3]  . ":" . $row[4];//YYY-MM-DD HH:MM in UTC.
        //echo $dateString;
        //exit;
        $dateObj = new DateTime($dateString, new DateTimeZone('UTC'));
        $datetime = $dateObj->format('Y/m/d h:i:s P');
        array_splice($row, 0 , 5, $datetime);
      //  print_r( $row );
      //  exit;
        array_push($obsData, $row);
    }
  
    
    foreach($obsData as $rowArray) {
        foreach($rowArray as $idx => $value) {
            $indexValue = $keys[$idx];
            if($value == "MM") {
                $value = null;
            }
             $line[$indexValue] =  $value; 
        }
      array_push($weatherData, $line); 
    }
    
    
    $out = array_values($weatherData);
    $jsonData = json_encode($out, JSON_NUMERIC_CHECK);
    //echo $jsonData;
    file_put_contents($file, $jsonData);
    
    fclose($handle);
} else {
    echo "error handle";
    }
?>