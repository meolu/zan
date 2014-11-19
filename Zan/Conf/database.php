<?php
/* *************************************************************************
 * File Name: database.php
 * Author: wushuiyong
 * mail: wushuiyong@huamanshu.com
 * Created Time: Sun 02 Nov 2014 06:34:12 PM
 * ************************************************************************/

####################### mysql ########################
// 起用db组

$db = [];
$db['default']['host'] = '127.0.0.1';
$db['default']['port'] = '3306';
$db['default']['user'] = 'wushuiyong';
$db['default']['passwd'] = 'wu@huang';
$db['default']['database'] = 'localdata';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

####################### mongo ########################

$db['mongo']['host'] = '127.0.0.1:27011';
$db['mongo']['user'] = 'wushuiyong';
$db['mongo']['passwd'] = 'wu@huang';
$db['mongo']['database'] = 'localdata';