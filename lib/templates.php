<?php

$PAGE = new StdClass;

function MakePage()
{
  global $PAGE;
  echo "<html>
    <head>
      <meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>
    </head>
    <body style='font:normal 14px arial'>
      <table style='width:100%;'>
      <tr>
      <td style='width:300px;'></td>
      <td style='padding-right:100px;'>$PAGE->main</td>
      </tr>
      </table>
    </body>
    </html>
  ";
}