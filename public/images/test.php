<?php

echo phpinfo();

/*echo "Given Array";
echo "<br>";
$array=array(5,9,20,4,1,7,3,15);
print_r($array);
echo "<br><br>";



for($j = 0; $j < count($array); $j ++) {
    for($i = 0; $i < count($array)-1; $i ++){

        if($array[$i] > $array[$i+1]) {
            $temp = $array[$i+1];
            $array[$i+1]=$array[$i];
            $array[$i]=$temp;
        }       
    }
}

echo "Result Array";
echo "<br>";
print_r($array);*/







/*$date = new DateTime();
$timeZone = $date->getTimezone();
echo $timeZone->getName();
echo '<br>';

echo "The time is " . date("Y-m-d H:i:s").'<br>';

echo '<pre>';
print_r($_SERVER);
echo '</pre>';

echo phpinfo();*/

/*ini_set('max_execution_time', 0);

// assuming file.zip is in the same directory as the executing script.
$file = 'realestate-admin.zip';

// get the absolute path to $file
$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
  // extract it to the path we determined above
  $zip->extractTo($path);
  $zip->close();
  echo "WOOT! $file extracted to $path";
} else {
  echo "Doh! I couldn't open $file";
}*/
?>