<?php
/**
 * Created by PhpStorm.
 * User: Aymerick
 * Date: 30/12/2018
 * Time: 17:49
 */

require_once("../model/managers/SuperManager.class.php");
require_once('utils.ctrl.php');

$superManager = new SuperManager();

$type = DAO::ALBUM_TEMPLATE;
$keywords = array('template');
$topics = array('Testing');
$rateMin = 0;
$formats = array('Paysage', 'Portrait');
$sizes = array('S', 'M', 'L');

$templates = $superManager->getTemplatesFiltered($type, $keywords, $topics, $rateMin, $formats, $sizes);

var_dump($templates);

echo 'Après pagination :<br/>';

var_dump(paginator($templates, 2, 3));