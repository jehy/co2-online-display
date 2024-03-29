<?
require_once('db.php');
$limit = (int)$_REQUEST['limit'];
$sensorId = (int)$_REQUEST['sensorId'];
if(!$sensorId){
    $sensorId = 1;
}
if (!$limit)
{
    $limit = 60;
}
$maxlimit=60*24*30;
if($limit>$maxlimit)
{
    $limit=$maxlimit;
}

$dateFormat='%H:%i';
if($limit>60*24*1)
{
  $dateFormat='%H';
}
if ($_REQUEST['stat'] == 'ppm') {
    $sql = 'SELECT CEIL(AVG(ppm)) `ppm`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"'.$dateFormat.'")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute) and sensor_id=?
 GROUP BY DATE(added),DATE_FORMAT(added,"'.$dateFormat.'") ORDER BY added DESC';
} elseif ($_REQUEST['stat'] == 'ram') {

    $sql = 'SELECT MIN(ram) `ram`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"'.$dateFormat.'")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute) and sensor_id=?
 GROUP BY DATE(added),DATE_FORMAT(added,"'.$dateFormat.'") ORDER BY added DESC';
} elseif ($_REQUEST['stat'] == 'temp') {

    $sql = 'SELECT CEIL(AVG(temp)) `temp`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"'.$dateFormat.'")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute) and sensor_id=?
 GROUP BY DATE(added),DATE_FORMAT(added,"'.$dateFormat.'") ORDER BY added DESC';
} elseif ($_REQUEST['stat'] == 'humidity') {

    $sql = 'SELECT CEIL(AVG(humidity)) `humidity`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"'.$dateFormat.'")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute) and sensor_id=?
 GROUP BY DATE(added),DATE_FORMAT(added,"'.$dateFormat.'") ORDER BY added DESC';
} else die('Error: parameter unknown!');
$stmt = $mysqli->prepare($sql);
if(!$stmt)
    die("Error preparing query:" . $mysqli->error);
$r = $stmt->bind_param('ii', $limit, $sensorId);
$res=$stmt->execute();
if(!$res)
    die("Error executing query:" . $mysqli->error);
$result = $stmt->get_result();
$array = $result->fetch_all(MYSQLI_ASSOC);
header('Content-Type: application/json');
$json = json_encode($array);
echo $json;
// Free result set
mysqli_free_result($result);
$mysqli->close();
//mysqli_close($con);
?>
