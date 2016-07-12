<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 11.07.16
 * Time: 19:20
 */

define ("DOC_ROOT", __DIR__."/..");
require DOC_ROOT."/vendor/autoload.php";

$api = new \Commander\Hub();

$result = $api->request('ts', 'updateFeed', [133026,[]]);

var_dump($result);