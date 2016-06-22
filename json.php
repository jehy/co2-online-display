<?
require_once('db.php');
$limit = (int)$_REQUEST['limit'];
if (!$limit)
    $limit = 60;
$maxlimit=60*24*7;
if($limit>$maxlimit)
    $limit=$maxlimit;
if ($_REQUEST['stat'] == 'ppm') {
    $sql = 'SELECT CEIL(AVG(ppm)) `ppm`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"%H:%i")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute)
 GROUP BY DATE(added),DATE_FORMAT(added,"%H-%i") ORDER BY added DESC';
} elseif ($_REQUEST['stat'] == 'ram') {

    $sql = 'SELECT MIN(ram) `ram`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"%H:%i")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute)
 GROUP BY DATE(added),DATE_FORMAT(added,"%H-%i") ORDER BY added DESC';
} elseif ($_REQUEST['stat'] == 'temp') {

    $sql = 'SELECT CEIL(AVG(temp)) `temp`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"%H:%i")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute)
 GROUP BY DATE(added),DATE_FORMAT(added,"%H-%i") ORDER BY added DESC';
} elseif ($_REQUEST['stat'] == 'humidity') {

    $sql = 'SELECT CEIL(AVG(humidity)) `humidity`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"%H:%i")) `date` FROM data
where added>=DATE_SUB(NOW(), INTERVAL ? minute)
 GROUP BY DATE(added),DATE_FORMAT(added,"%H-%i") ORDER BY added DESC';
} else die('Error: parameter unknown!');
$stmt = $mysqli->prepare($sql);
if(!$stmt)
    die("Error preparing query:" . $mysqli->error);
$r = $stmt->bind_param('i', $limit);
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
