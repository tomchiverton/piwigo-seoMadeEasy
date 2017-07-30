<?php
define('SEOMADEEASY_PHPWG_ROOT_PATH','../../');

#throws 'hacking attempt later'...
#define('PHPWG_ROOT_PATH','../../');
#include_once( SEOMADEEASY_PHPWG_ROOT_PATH.'include/common.inc.php' );

#include( SEOMADEEASY_PHPWG_ROOT_PATH.'include/functions.inc.php' );
#include( SEOMADEEASY_PHPWG_ROOT_PATH.'include/dblayer/functions_mysqli.inc.php' );

include( SEOMADEEASY_PHPWG_ROOT_PATH . 'include/config_default.inc.php');
include( SEOMADEEASY_PHPWG_ROOT_PATH. 'local/config/database.inc.php');

include( SEOMADEEASY_PHPWG_ROOT_PATH.'include/constants.php' );

seoMadeEasy_db_connect($conf['db_host'], $conf['db_user'],
                 $conf['db_password'], $conf['db_base']);


$pArr=explode('/',$_GET['p']);

$first=$pArr[1];

$sql = 'select id,name from '.CATEGORIES_TABLE.' where name like "'.seoMadeEasy_db_real_escape_string( $first ).'" and id_uppercat is null';

$resArr=seoMadeEasy_array_from_query($sql);

if( count( $resArr ) != 1 ){
        print "Too many albums matched";
        die('Too many albums matched');
}

$last_cat = $resArr[0]['id']; //id

print '1';
print $first;
print 'null';

?>

<hr>

<?php
for($i = 2; $i < count( $pArr) ; ++$i ){

        print $i;
        print $pArr[$i];
        print  $last_cat;

        $sql = 'select id,name from '.CATEGORIES_TABLE.' where name like "'.seoMadeEasy_db_real_escape_string( $pArr[$i] ).'" and id_uppercat="'.seoMadeEasy_db_real_escape_string( $last_cat ).'" ';

        $resArr=seoMadeEasy_array_from_query($sql);

        if( count( $resArr ) != 1 ){
                print "Too many albums matched";
                die('Too many albums matched');
        }

        $last_cat=$resArr[0]['id'];

        print '<br>';
}

?>
<hr>
in the end, got to 
<?php
var_dump($resArr[0]);
?>

pretend we were never here

<?php

//include_once( SEOMADEEASY_PHPWG_ROOT_PATH.'include/functions_user.inc.php');
//include_once( SEOMADEEASY_PHPWG_ROOT_PATH.'include/common.inc.php' );

//define('PHPWG_ROOT_PATH','./');

chdir('../../');

// TODO update with results of last $resArr 

$_SERVER['SCRIPT_URL']='/photos/index/category/193-together_17';
$_SERVER['SCRIPT_URI']='https://rachaelandtom.info/photos/index/category/193-together_17';
$_SERVER['PATH_INFO']='/category/193-together_17';
$_SERVER['REQUEST_URI']='/photos/index/category/193-together_17';
//include('index.php');
//didn't work b/c 
/*
 
Warning: require_once(PHPWG_ROOT_PATHthemes/bootstrapdefault/include/themecontroller.php): failed to open stream:
*/

//issue a redirect instead for now
//TODO majic path appears from nowhere
$ni = $resArr[0]['name'];
header( 'Location: https://'.$_SERVER["HTTP_HOST"].'/photos/index/category/'.$last_cat.'-'.$ni );
?>

<?php
function seoMadeEasy_db_connect($host, $user, $password, $database)
{
  global $seoMadeEasy_mysqli;

 $port = null;
  $socket = null;

  if (strpos($host, '/') === 0)
  {
    $socket = $host;
    $host = null;
  }
  elseif (strpos($host, ':') !== false)
  {
    list($host, $port) = explode(':', $host);
  }

  $seoMadeEasy_mysqli = new mysqli($host, $user, $password, $database, $port, $socket);
}

function seoMadeEasy_pwg_query($query){
        global $seoMadeEasy_mysqli;   
        $result = $seoMadeEasy_mysqli->query($query);
        return $result;
}

function seoMadeEasy_db_real_escape_string($s){
        global $seoMadeEasy_mysqli;
        return $seoMadeEasy_mysqli->real_escape_string($s);
}
function seoMadeEasy_array_from_query($query, $fieldname=false)
{
  if (false === $fieldname)
  {
                return seoMadeEasy_query2array($query);
  }
  else
  {
                return seoMadeEasy_query2array($query, null, $fieldname);
  }
}
function seoMadeEasy_query2array($query, $key_name=null, $value_name=null)
{
  $result = seoMadeEasy_pwg_query($query);
  $data = array();

  if (isset($key_name))
  {
    if (isset($value_name))
    {
      while ($row = $result->fetch_assoc())
        $data[ $row[$key_name] ] = $row[$value_name];
    }
    else
    {
      while ($row = $result->fetch_assoc())
        $data[ $row[$key_name] ] = $row;
    }
  }
  else
  {
    if (isset($value_name))
    {
      while ($row = $result->fetch_assoc())
        $data[] = $row[$value_name];
    }
    else
    {
      while ($row = $result->fetch_assoc())
        $data[] = $row;
    }
  }

  return $data;
}


?>
