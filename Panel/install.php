<?
include_once('modules/config/config.php');

$sqlf = file_get_contents('db.sql');
$result = $mysqli->query($sqlf);

if(!($result)){
echo 'Installed';
}

?>