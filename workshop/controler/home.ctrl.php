<?php

// CONSTANTS ///////////////////////////////////////////////////////////////////////////////////////////////////////////
define('NB_TEMPLATES_SLIDES', 3);

// BODY ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$templates = $superManager->getAllTemplates();
// remove private templates
templatePrivatePurge($templates);

$templatesPopularity = array();
$templatesPubDate = array();

foreach ($templates as $template) {
  array_push($templatesPopularity, $template);
  array_push($templatesPubDate, $template);
}
// descending sorting by popularity
usort($templatesPopularity, "cmpTemplatePopularity");
// only the first ones
$templatesPopularity = paginator($templatesPopularity, 1, NB_TEMPLATES_SLIDES);

// sorting: the most recent templates
usort($templatesPubDate, "cmpTemplatePubDate");
// only the first ones
$templatesPubDate = paginator($templatesPubDate, 1, NB_TEMPLATES_SLIDES);

?>
