
<?php 
/*==== CONFIG AREA ====*/
error_reporting(0);
define('HERE', 'https://www.kolyma.org');
define('LIVE_ROOT', 'https://live.netmode.ru/');
define('USE_RSS', false);
define("title", "Kolyma Network");
/* END CONFIG AREA */
?><style>* {margin: 0; padding: 0;

	font-family: arial, helvetica, sans-serif;
	font-size: 10pt;

	}
	
a,
a:visited {
	text-decoration: none;
	color: #c3672a;
}
	
</style>
<center><marquee direction="right"><?php newsarea('news4tech', 'newsplus'); ?></marquee></center>
<?php
function newsarea($board, $name='') {
  $json = @file_get_contents(LIVE_ROOT.$board.'/koko.php?mode=module&load=mod_api');
  if (!$json) {
    echo '';
      return;
  }
  $threads = json_decode($json, true);
  if (!is_array($threads)) {
    echo '';
      return;
  }
  usort($threads, function($a, $b) { return intval($a['tim']) < intval($b['tim']); });
  for ($i=0; $i<3 && $i<count($threads); $i++) {
    extract($threads[$i]);
    if ($i==0) $sub = "<font>$sub</font>";
    else $sub = "<font size=\"3px;\">$sub</font>";
    $ary_category = explode(',', str_replace('&#44;', ',', $category)); $ary_category = array_map('trim', $ary_category);
    $cats = '';
    foreach ($ary_category as $cat) {
          if (!$cat) continue;
        $cats.= " <b class=\"cat\">$cat</b>";
    }
    echo "<a target=\"_blank\" href=\"".LIVE_ROOT."$board/koko.php?res=$no\">$sub</a> - &nbsp;";
  }
}
?>

