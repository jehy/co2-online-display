<?
if(!file_exists('db_data.php'))
    die(json_encode(array('error'=>'database settings not found')));

require_once('db_data.php');

class DataBase extends DbData
{
function connect()
{
    global $mysqli;
    $mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);

    if (mysqli_connect_errno()) {
        $status=array();
	$status['error'][]="Error: Unable to connect to MySQL." . PHP_EOL;
        $status['error'][]="Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        $status['error'][]="Debugging error: " . mysqli_connect_error() . PHP_EOL;
        echo json_encode($status);
	exit;
    }
}
}
$db=new DataBase();
$db->connect();
?>