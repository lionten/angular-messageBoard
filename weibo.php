<?php 
	session_start();
	if(!isset($_SESSION['num'])){
		$_SESSION['num'] = 1;
	}else{
		$_SESSION['num']++;
	}
	// echo  $_SESSION['num'];
	// 连接数据库
	mysql_connect("localhost","root",'');
	mysql_select_db('say');
	mysql_query("set names utf8");
	
	$act = $_GET['act'];
	$time = time();
	switch ($act){
		case 'get':
			$page = $_GET['page']-1;
			$startPage = $page*5;
		// 建立数据库
			$sql="SELECT * FROM say ORDER BY time DESC Limit $startPage,5 ";
			$res = mysql_query($sql);
			$arr = array();

			// 读取数据
			if($res){
				while ($res2 = mysql_fetch_assoc($res)) {
					array_push($arr, $res2);
				}
				print_r(json_encode($arr));
			}else{
				echo '[]';
			}
			break;
		case 'add':
			$content=$_GET['content'];
			// 把数据添加到数据库
			$sql ="INSERT INTO say(id,content,time,ding,cai) values (null,'$content',$time,0,0)";
			$res = mysql_query($sql);
			echo '{"error":0,"id":'.$_SESSION['num'].',"time":'.$time.'}';
			break;
		case 'ding':
			// 将对应id的数据++
			$id = $_GET['id'];
			$sql = "SELECT * FROM say where id = $id";
			$res = mysql_query($sql);
			$ding = mysql_fetch_assoc($res)['ding'];
			$ding = $ding+1;
			$sql = "UPDATE say set ding=$ding where id=$id";
			$res = mysql_query($sql);
			break;
		case 'cai':
			// 将对应id的数据++
			$id = $_GET['id'];
			$sql = "SELECT * FROM say where id = $id";
			$res = mysql_query($sql);
			$cai = mysql_fetch_assoc($res)['cai'];
			$cai = $cai+1;
			$sql ="UPDATE say set cai=$cai where id=$id";
			$res = mysql_query($sql);
			break;
		case 'get_page_count':
			$sql = "SELECT * FROM say";
			$res = mysql_query($sql);
			$num = mysql_num_rows($res);
			$pages = ceil($num/5);
			echo $pages;
			break;
		case 'cut':
			$id = $_GET['id'];
			$sql = "DELETE FROM say where id =$id ";
			$res = mysql_query($sql);
			break;
	}
 ?>

