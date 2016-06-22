<?

if (!$_REQUEST['data'])
    die(json_encode(['status' => 'error', 'msg' => 'no request data!']));

require_once('db.php');
$data = $_REQUEST['data'];
$data = json_decode($data, 1);
if (!$data)
    die(json_encode(['status' => 'error', 'msg' => json_last_error()]));
#file_put_contents('1.txt',var_export($_REQUEST,1)."\n\n\n".var_export($data,1)."\n\n".json_last_error());
$sql = 'INSERT INTO data(added,sensor_id,ppm,ssid,ram,temp,humidity) VALUES(NOW(),?,?,?,?,?,?)';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iisiii', $data['id'], $data['ppm'],
    $data['SSID'], $data['FreeRAM'], $data['temp'], $data['humidity']);
$res = $stmt->execute();
if($stmt->error)
    die(json_encode(['status' => 'error', 'msg' => 'mysql error:'.$stmt->error]));
if ($res)
    echo json_encode(['status' => 'ok']);
else
    echo json_encode(['status' => 'error', 'msg' => $mysqli->error]);
?>
