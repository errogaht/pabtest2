<?php 

require_once("lib/lib.php");
require_once("lib/db.php");
require_once("lib/templates.php");

define('_city','msk');
$_ip = $_SERVER['REMOTE_ADDR'];

$xs = array(
  "subjs"=> "Преподаваемые предметы,<br>специализация",
  "edu"  => "Образование: вуз,<br>специальность, год окончания",
  "edu2" => "Степени, звания,<br>дипломы, награды и т.п.",
  "exp1" => "Опыт работы в<br>образовательных учреждениях",
  "exp2" => "Опыт частной репетиторской<br>деятельности",
  "wprc" => "Cтоимость и<br>продолжительность занятия",
  "mmtr" => "Место проведения занятий<br>«у себя» (метро, адрес)",
  "mreg" => "Возможность выезда<br>(города, районы, ветки метро)",
  "wishes" => "Другая информация",
);

if($_POST['agreed']) {

  $err="";  $q="";

  foreach(array_merge(array("fio"=>"ФИО","phone"=>"телефон","email"=>"email"),$xs) as $n=>$v) {
    $$n=SPCQA($_POST[$n]);
    if($q)$q.=", ";  $q.="$n='".mysql_real_escape_string($_POST[$n])."'";
  }
  
  if(!$fio || !$phone || !$email) { $err.="Поля контактной информации (ФИО, телефон и email) обязательны для заполнения.\n"; }
  
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
    <h1 id=TopText style='padding:16px 0 24px 0;'>Заявка на регистрацию принята (№ $g_id)</h1>
    <div style='font:normal 15px/19px arial;'>
    В ближайшее время мы свяжемся с вами по указанному номеру телефона, уточним необходимые детали вашей анкеты, расскажем о принципах сотрудничества с компанией и ответим на все вопросы.<br><br>
    </div><br>
    <input type='button' value='Отлично!' style='width:200; height:33px; font:bold 15px arial;' onclick='window.location.href=\"/\"'>
  ";
  
}
elseif($_GET['f']) {
  $f=intval($_GET['f']);  $sf0="";  $sf1="";
  if($f==1) {
    $sf0="<div style='font:italic 11px arial; padding:0 0 8px 0; text-align:right;'>Также вы можете <a href='?f=2' class=decor>заполнить резюме в свободном формате</a>.</div>";
    foreach($xs as $n=>$v) { $sf1.="<tr><td class=iltd1>$v</td><td><textarea class=inp05 name=$n>".$$n."</textarea></td></tr>"; }
  }
  elseif($f==2) {
    $sf0="<div style='font:italic 11px arial; padding:0 0 8px 0; text-align:right;'>Также вы можете <a href='?f=1' class=decor>заполнить подробную форму резюме</a>.</div>";
    $sf1="
      <tr><td colspan=2>Специальность, квалификация, условия, другая информация (или ссылка на полное резюме):</td>
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
      <tr><td>ФИО$s3        </td><td><input type=text name=fio value='$fio' class=inp05></td></tr>
      <tr><td>Телефон$s3    </td><td><input type=text name=phone value='$phone' class=inp05></td></tr>
      <tr><td>Email$s3      </td><td><input type=text name=email value='$email' class=inp05></td></tr>
      $sf1
      <tr><td>&nbsp;</td><td><br><input type=submit name=sbmt value='Зарегистрироваться' style='border:outset 1px #ddd; padding:4px 8px; background-color:#f0f0f0; font:bold 13px verdana,arial,sans-serif; color:#333;'></td></tr>
      </table><br>
    </form>
  ";
  
}
else {
  $PAGE->main.="
    <br><p style='font:normal 14px arial'>Первичная регистрация (до собеседования) занимает в среднем 10—15 минут.</p>
    <form action='?f=1' method=POST style='padding:0 0 0 4px;' onsubmit='this.sbmt.disabled=true;'>
    <input type=submit name=sbmt value='Зарегистрироваться' id=rg_sbmt1 style='border:outset 1px #ddd; padding:4px 8px; background-color:#f0f0f0; font:bold 13px verdana,arial,sans-serif; color:#333;'>
    </form>
  ";
}

MakePage();
