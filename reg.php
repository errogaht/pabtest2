<?php 

require_once("lib/lib.php");
require_once("lib/db.php");
require_once("lib/templates.php");

define('_city','msk');
$_ip = $_SERVER['REMOTE_ADDR'];

$xs = array(
  "subjs"=> "������������� ��������,<br>�������������",
  "edu"  => "�����������: ���,<br>�������������, ��� ���������",
  "edu2" => "�������, ������,<br>�������, ������� � �.�.",
  "exp1" => "���� ������ �<br>��������������� �����������",
  "exp2" => "���� ������� �������������<br>������������",
  "wprc" => "C�������� �<br>����������������� �������",
  "mmtr" => "����� ���������� �������<br>�� ����� (�����, �����)",
  "mreg" => "����������� ������<br>(������, ������, ����� �����)",
  "wishes" => "������ ����������",
);

if($_POST['agreed']) {

  $err="";  $q="";

  foreach(array_merge(array("fio"=>"���","phone"=>"�������","email"=>"email"),$xs) as $n=>$v) {
    $$n=SPCQA($_POST[$n]);
    if($q)$q.=", ";  $q.="$n='".mysql_real_escape_string($_POST[$n])."'";
  }
  
  if(!$fio || !$phone || !$email) { $err.="���� ���������� ���������� (���, ������� � email) ����������� ��� ����������.\n"; }
  
  if(!$err) {
    $q.=", addt=NOW(), ip='$_ip', city_id='"._city."'";  $errf="";
    mysql_query("INSERT INTO ri_pregs SET $q");  $id=mysql_insert_id();  if(!$id)dierr("#u8742765123");
    setcookie("sc_gid", "$id", 0, "/");
    header("Location: $_self?ok"); exit();
  }
  else {
    $PAGE->main.="<div style='background:#d00; color:#fff; padding:8px; font:bold 13px arial;'>".RN($err)."</div>";
  }
}
  
if($_SERVER['QUERY_STRING']=="ok") {
  
  $g_id=intval($_COOKIE['sc_gid']);
  if(!$g_id) { header("Location: $_self");  exit(); }
  
  $PAGE->type="reg_ok";
  
  $PAGE->toptext="";
  
  $PAGE->main.="
    <h1 id=TopText style='padding:16px 0 24px 0;'>������ �� ����������� ������� (� $g_id)</h1>
    <div style='font:normal 15px/19px arial;'>
    � ��������� ����� �� �������� � ���� �� ���������� ������ ��������, ������� ����������� ������ ����� ������, ��������� � ��������� �������������� � ��������� � ������� �� ��� �������.<br><br>
    </div><br>
    <input type='button' value='�������!' style='width:200; height:33px; font:bold 15px arial;' onclick='window.location.href=\"/\"'>
  ";
  
}
elseif($_GET['f']) {
  $f=intval($_GET['f']);  $sf0="";  $sf1="";
  if($f==1) {
    $sf0="<div style='font:italic 11px arial; padding:0 0 8px 0; text-align:right;'>����� �� ������ <a href='?f=2' class=decor>��������� ������ � ��������� �������</a>.</div>";
    foreach($xs as $n=>$v) { $sf1.="<tr><td class=iltd1>$v</td><td><textarea class=inp05 name=$n>".$$n."</textarea></td></tr>"; }
  }
  elseif($f==2) {
    $sf0="<div style='font:italic 11px arial; padding:0 0 8px 0; text-align:right;'>����� �� ������ <a href='?f=1' class=decor>��������� ��������� ����� ������</a>.</div>";
    $sf1="
      <tr><td colspan=2>�������������, ������������, �������, ������ ���������� (��� ������ �� ������ ������):</td>
      <tr><td colspan=2><textarea class=inp05 name=wishes style='width:100%; height:96px;'>".$wishes."</textarea></td></tr>
    ";
  }
  
  
  $s3=" <span style='color:#e00;'>*</span>";
  $PAGE->main.="

    <style>
    TABLE.iltb TD {padding:1px 5px 2px 1px; font:normal 11px tahoma;}
    TABLE.iltb TD .inp05 {font:normal 11px tahoma;}  TABLE.iltb TD TEXTAREA.inp05 {height:33px; width:500; padding:0; margin:0; overflow:visible;}  TABLE.iltb TD INPUT.inp05 {width:400;}
    TABLE.iltb TD.iltd1 {white-space:nowrap;}
    </style>
    
    $sf0
    
    <form action='?f=$f' method=POST name=MMform onsubmit='this.sbmt.disabled=true;'>
      <input type=hidden name=agreed value='10'>
      <table cellspacing=0 class=iltb>
      <tr><td>���$s3        </td><td><input type=text name=fio value='$fio' class=inp05></td></tr>
      <tr><td>�������$s3    </td><td><input type=text name=phone value='$phone' class=inp05></td></tr>
      <tr><td>Email$s3      </td><td><input type=text name=email value='$email' class=inp05></td></tr>
      $sf1
      <tr><td>&nbsp;</td><td><br><input type=submit name=sbmt value='������������������' style='border:outset 1px #ddd; padding:4px 8px; background-color:#f0f0f0; font:bold 13px verdana,arial,sans-serif; color:#333;'></td></tr>
      </table><br>
    </form>
  ";
  
}
else {
  $PAGE->main.="
    <br><p style='font:normal 14px arial'>��������� ����������� (�� �������������) �������� � ������� 10�15 �����.</p>
    <form action='?f=1' method=POST style='padding:0 0 0 4px;' onsubmit='this.sbmt.disabled=true;'>
    <input type=submit name=sbmt value='������������������' id=rg_sbmt1 style='border:outset 1px #ddd; padding:4px 8px; background-color:#f0f0f0; font:bold 13px verdana,arial,sans-serif; color:#333;'>
    </form>
  ";
}

MakePage();
