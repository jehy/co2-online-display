<?
require_once('db.inc');
$limit=(int)$_REQUEST['limit'];
if(!$limit)
    $limit=60;
if($_REQUEST['stat']=='ppm')
{
$sql='SELECT CEIL(AVG(ppm)) `ppm`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"%H:%i")) `date` FROM co2.data
where added>=DATE_SUB(NOW(), INTERVAL ? minute)
 GROUP BY DATE(added),DATE_FORMAT(added,"%H-%i") ORDER BY added DESC';
}
elseif($_REQUEST['stat']=='ram')
{
$sql='SELECT CEIL(AVG(ram)) `ram`, CONCAT(DATE(added)," ",DATE_FORMAT(added,"%H:%i")) `date` FROM co2.data
where added>=DATE_SUB(NOW(), INTERVAL ? minute)
 GROUP BY DATE(added),DATE_FORMAT(added,"%H-%i") ORDER BY added DESC';
}
else die('Error: parameter unknown!');
    $stmt = $mysqli->prepare($sql);
    $r = $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
#$result=$mysqli->query($sql);

$array=$result->fetch_all(MYSQLI_ASSOC);
// Fetch all
//mysqli_fetch_all($result,MYSQLI_ASSOC);

#print_R($array);
$json=json_encode($array);
header('Content-Type: application/json');
echo $json;
// Free result set
mysqli_free_result($result);

mysqli_close($con);
?>