<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>



</html>

<?php /* by onion @ 2016/02/25 */

set_time_limit(0);
	$pos="127.0.0.1";
	$user="root";
	$psw="1234";
	mysql_connect($pos,$user,$psw);
	mysql_select_db("test");//whitch database
	mysql_query("set names utf8");//設定utf8 中文字才不會出現亂碼

if(empty( $_POST["oth"]) ){
	
}else{
	//echo $_POST["oth"];
	$write='INSERT INTO `data_test2`( `oth`) VALUES (\''.$_POST["oth"].'\')';
	mysql_query($write);
}
if(empty( $_POST["chkitem"]) ){
	//echo "alert("error");";
}else{
	$item = array();
	$item=$_POST["chkitem"];
	$write='DELETE FROM `data_test2` WHERE ';
	for($cou=0;$cou<count($item);$cou++){
		if($cou == (count($item)-1)){
			$write= $write.'`id` = '.$item[$cou]	;	
		}else{
			$write= $write.'`id` = '.$item[$cou].' or ';
		}	
	}
	//echo $write;
	//echo "成功刪除資料！";
	mysql_query($write);
}

 



?>
<html>
<body>
<ul class="navigation">
            <li>
                <a href="">Link</a>
                <ul>
                    <li><a href="https://www.google.com.tw" target="_blank">前往google</a></li>
                    <li><a href="https://tw.yahoo.com/" target="_blank">前往雅虎</a></li>
                </ul>
            </li>

            <li><a href="">TTC</a>
                <ul>
                    <li><a href="http://www.ttc.org.tw/" target=>前往ttc</a></li>
                </ul>
            </li>

            <li><a href="">DataBase</a>
                <ul>
                    <li><a href="http://localhost/phpmyadmin/index.php?token=8c6195c261d32be8271ad827d0515da5">PHP MY Admin</a></li>
                </ul>
            </li>

            <li><a href="">選單內容 4</a>
                 <ul>
                    <li><a href="">選單內容 4 - 1</a></li>
                    <li><a href="">選單內容 4 - 2</a></li>
                    <li><a href="">選單內容 4 - 3</a></li>
                    <li><a href="">選單內容 4 - 4</a></li>
                </ul>
            </li>

            <li><a href="">選單內容 5</a>
                <ul>
                    <li><a href="">選單內容 5 - 1</a></li>
                    <li><a href="">選單內容 5 - 2</a></li>
                    <li><a href="">選單內容 5 - 3</a></li>
                </ul>
            </li>

            <li><a href="">選單內容 6</a>
                <ul>
                    <li><a href="">選單內容 6 - 1</a></li>
                    <li><a href="">選單內容 6 - 2</a></li>
                    <li><a href="">選單內容 6 - 3</a></li>
                    <li><a href="">選單內容 6 - 4</a></li>
                </ul>
            </li>

            

        </ul>
<br>
<div id="control">
<input type="button" value="新增" id="add" onclick="add()"/> <br>
<div id="hidetoolbar1"></div>
<input type="button" value="修改" id="update" onclick="update()"/><br> 
<div id="hidetoolbar2"></div>
</div>
</body>
</html>
<?php
	$getall = 'SELECT * FROM `data_test2` WHERE 1'; //取得資料庫所有資料
	$gettabinfo = 'SHOW COLUMNS FROM data_test2  FROM test' ; //取得資料表欄位資訊	
	//$adddata='INSERT INTO `data_test` (`id`, `acctime`) VALUES (NULL, CURRENT_TIMESTAMP);'; //建立紀錄
	//mysql_query($adddata) ;
	
	/*    取得欄位詳細資料    */
	$result = mysql_query($gettabinfo) ;
	$counter1=0;
	$field_name = array(); //欄位名稱
	$key = array(); //主鍵
	$default = array(); //設定
	while($row = mysql_fetch_array($result)){ 
		$field_name[$counter1] = $row['Field'];
		$key[$counter1] = $row['Key'];
		$default[$counter1] = $row['Default'];
		//echo $row['Field']." || ".$row['Key']." || ".$row['Default']."<br>"; //debug using
		//echo  $field_name[$counter1]." || ".$key[$counter1]." || ".$default[$counter1]."<br>"; //debug using
		$counter1++;
	}
	
	/*    取得欄位詳細資料    */

	/*    取得資料表內容並顯示在表格上    */	
	$result = mysql_query($getall) ;
	$counter=0;
	$lastdata="";
	echo '<form action="main.php" method="post"><input type="submit" value="刪除" id="del" onclick="del()"/> <table id="showdata"border=\"1\" ><tr id="tab_title"><td>選項</td><td>ID</td><td>時間</td><td>內容</td></tr>';
	while($row = mysql_fetch_array($result)){ 
		echo "<tr><td>";
		echo '<input type="checkbox" id="'.$row['id'].'"name="chkitem[]" value="'.$row['id'].'" onchange="chk('.$row['id'].')"/>';		
		echo '</td><td>';		
		echo $row['id']."</td><td>";
		$lastdata=$row['time'];
		echo $lastdata;
		$counter++;
		echo "</td> <td>".$row['oth']."</td></tr>";
	}
	echo "<div id=\"info\">最後新增資料時間：".$lastdata."<br>";
	echo "總共: ".$counter." 筆資料".'<br></div><br><div id="debug"/>';
	echo "</table></form>";
	
	/*    取得資料表內容並顯示在表格上    */
	/*    控制按紐 JavaScript    */
	echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script>
			
		var chary = new Array();
		function add(){
			document.getElementById("hidetoolbar1").innerHTML = "<form action=\"main.php\" method=\"post\">';
	for($htcounter=0;$htcounter<count($field_name);$htcounter++){
		if($key[$htcounter]=="PRI"){
			echo	$field_name[$htcounter].':<input type=\"text\" name=\"'.$field_name[$htcounter].'\"\" disabled> (此欄位為主鍵)<br>' ;  //判斷是否為主鍵
		}else if($default[$htcounter]=="CURRENT_TIMESTAMP"){
			echo $field_name[$htcounter].':<input type=\"text\" name=\"'.$field_name[$htcounter].'\"\" disabled> (此欄位為自動產生時間)<br>';//判斷是否為自動產生日期
		}else{
			echo $field_name[$htcounter].':<input type=\"text\" name=\"'.$field_name[$htcounter].'\"\"><br>';
		}	
	}
	echo '<input type=\"submit\" value=\"送出\" id=\"sent\" /> '; //新增選項內的送出及取消按鈕
	echo '</form> <!--<input type=\"button\" value=\"取消\" id=\"cancel\" onclick=\"clear()\" />-->";
		document.getElementById("hidetoolbar2").innerHTML = "";
		}
		function del(){		
			if(chary.length == 0){
				alert("請選擇要刪除的項目!");			
			}else{
				alert("run");
			}
			
		}
		function update(){
			document.getElementById("hidetoolbar1").innerHTML = "";
			document.getElementById("hidetoolbar2").innerHTML = "<form action=\"main.php\" method=\"post\">資料：<input type=\"textbox\" /></form>";
			 
			
		}
		function clear(){
			//alert("取消");
			//document.getElementById("hidetoolbar1").innerHTML = "";
		}
		function chk(chks){
			if(document.getElementById(chks).checked){
				chary.push(chks);
				for(var x=0;x<chary.length;x++){
					//chary[x];				
				}
				//document.getElementById("debug").innerHTML = chary.length;
				
			}else{
				var posoa=chary.indexOf(chks);
				if(posoa > -1){
					chary.splice(posoa, 1);			
				}
				//document.getElementById("debug").innerHTML = chary.length;
			}
		}
		</script>';
	/*    控制按紐 JavaScript    */
	/*$s = "<script>document.writeln(chary.length);</script>";
	echo $s;*/
?>







