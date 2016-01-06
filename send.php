<?

if(!$_REQUEST['data'])
    die(json_encode(['status'=>'error', 'msg'=>'no request data!']));

require_once('db.inc');
$data=$_REQUEST['data'];
$data=json_decode($data,1);
if(!$data)    
    die(json_encode(['status'=>'error', 'msg'=>json_last_error()]));
#file_put_contents('1.txt',var_export($_REQUEST,1)."\n\n\n".var_export($data,1)."\n\n".json_last_error());
$sql = 'INSERT INTO data(added,sensor_id,val,ppm,ssid,ram) VALUES(NOW(),?,?,?,?,?)';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iiisi', $data['id'],$data['val'],$data['ppm'],$data['SSID'],$data['FreeRAM']);
$res=$stmt->execute();
if(res)
    echo json_encode(['status'=>'ok']);
else
    echo json_encode(['status'=>'error', 'msg'=>$mysqli->error]);
?>