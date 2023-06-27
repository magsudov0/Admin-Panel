
<?php
function quick_sort($my_array)
{
   $loe = $gt = array();
   if(count($my_array) < 2)
   {
       return $my_array;
   }
   $pivot_key = key($my_array);
   $pivot = array_shift($my_array);
   foreach($my_array as $val)
   {
       if($val <= $pivot)
       {
           $loe[] = $val;
       }elseif ($val > $pivot)
       {
           $gt[] = $val;
       }
   }
   return array_merge(quick_sort($loe),array($pivot_key=>$pivot),quick_sort($gt));
}
$randomNumbers = range(-999999, 999999);
shuffle($randomNumbers );
$randomNumbers = array_slice($randomNumbers ,0,1000);


//$randomNumbers = array(6,3,448,15,3454,45,1,45,135,485,154,5468,741,594,84,5175,45,498,45,178,15,156,48,4561,68,45,-49,-4,-567,684,8,7498,-4789,-756,49,84,84,-9852,8,4,456158,4,568541,8,168,1658,489,1687,468541,68415,64817,85,48791564,48645,4185946845,186474,187564874,1856484,1864874,185647864,48467,18648,1678486,18674,41856,48,41684,8641,68,41896,486,468,489,4186,186,4168746,8546516,54685,4196874,5864,8947,168,57489,647,9684,48564,54,165,465,16,54,654,195641,561234,685471,65,16857421,4564,84,684,168,468,489,54684,565,165419,849,81,648,498,413,5156,84657,8135,3,46,4,684,9841,684,68,498,4,6816,84,68,16,87,4,8,5,4,6,5,4,1,6,8,54,6,8,4,6,16,8,5,4,68,4,98,4,9684,9,84,684,96,84,9,8,6416,854,6854,984,1,698,4968,485,124,685,41654,9865);

$tempArray = array();
$tempNumber = PHP_INT_MAX;
$tempNumber2 = 0;
$counter = 0;

$time_start = microtime(true); 
while(sizeof($randomNumbers)>0)
{
    $j = 0;
    while($j<sizeof($randomNumbers))
    {
        
		if($tempNumber>$randomNumbers[$j]){
            $tempNumber = $randomNumbers[$j];
		}
        ++$j;
	}
    
    $tempArray[$counter] = $tempNumber;
    array_splice($randomNumbers,array_search($tempNumber,$randomNumbers),1);
    ++$counter;
	$tempNumber = PHP_INT_MAX;
    

}
//$tempArray = quick_sort($randomNumbers);

$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
foreach($tempArray as $x){
    echo $x;
    echo "<br>";
}
echo $execution_time;
?>

