<?php
function retJson($data) {
    header('content-type: application/json');
    print json_encode($data);
    exit;
}

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method==="post") {
	$ret = array('Status'=>'OK', 'NOW'=>round(microtime(true) * 1000), 'YOU'=>$_SERVER['REMOTE_ADDR']);
        retJson($ret);

}else{

	$ret =array('Status'=>'FAIL', 'NOW'=>round(microtime(true) * 1000), 'YOU'=>$_SERVER['REMOTE_ADDR']);
	retJson($ret);
}
?>

