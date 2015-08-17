<?php
$handle = @fopen("MRHO1.txt", "r");
$file = "MRH01.json";
if ($handle) {
    $i=0;
    $keys = [];
    $weatherData = [];
    $point = [];
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
        if ($i == 1) {
            $i++;
            continue;
        }
        $row = preg_split("/\s+/", $data);
        $dateString = $row[0] . "-" . $row[1] . "-" . $row[2] . " " . $row[3]  . ":" . $row[4]." UTC";//YYY MM DD HH:MM        
        $dateObj = new DateTime($dateString);
        $ts = $dateObj->format("U");
        array_splice($row, 0 , 5, $ts);
       // print_r( $row );
       // exit;
        array_push($point, $row);
    }
   // print_r($point);
    
    
    foreach($point as $rowArray) {
        foreach($rowArray as $idx => $value) {
            $indexValue = $keys[$idx];
            if($idx == 0) {
                $line[$indexValue] =  $value ;//date
            } else {
                if($value == "MM") {
                    $value = null;
                }
                 $line[$indexValue] =  $value ; 
            }
            
            
        }
      array_push($weatherData, $line);  
    }
    $out = array_values($weatherData);
    $jsonData = json_encode($out, JSON_NUMERIC_CHECK);
    //echo $jsonData;
    file_put_contents($file, $jsonData);
    
    fclose($handle);
}
?>