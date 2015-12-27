<?

if($_REQUEST)
{
    require_once('db.inc');
    $data=$_REQUEST['data'];
    $data=json_decode($data,1);
    #file_put_contents('1.txt',var_export($_REQUEST,1)."\n\n\n".var_export($data,1)."\n\n".json_last_error());

        $sql = 'INSERT INTO data(added,sensor_id,val,ppm,ssid) VALUES(NOW(),?,?,?,?)';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('iiis', $data['id'],$data['val'],$data['ppm'],$data['SSID']);
        $stmt->execute();

}
?>