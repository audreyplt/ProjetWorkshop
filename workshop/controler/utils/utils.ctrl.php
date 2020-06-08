<?php
/**
 * Created by PhpStorm.
 * User: Aymerick
 * Date: 30/12/2018
 * Time: 13:47
 */

/**
 * Remove from the array all the privates templates.
 * @param array $templates
 */
function templatePrivatePurge(&$templates) {
  foreach ($templates as $template) {
    if (!$template->isPublic()) {
      unset($templates[array_search($template, $templates)]);
    }
  }
}

/**
 * @param Template $a
 * @param Template $b
 * @return int
 */
function cmpTemplatePopularity($a, $b)
{
  if ($a->getPopularityCoeff() == $b->getPopularityCoeff()) {
    return 0;
  }
  return ($a->getPopularityCoeff() < $b->getPopularityCoeff()) ? 1 : -1;
}

/**
 * @param Template $a
 * @param Template $b
 * @return int
 */
function cmpTemplatePubDate($a, $b)
{
  if ($a->getPubDate() == $b->getPubDate()) {
    return 0;
  }
  return ($a->getPubDate() < $b->getPubDate()) ? 1 : -1;
}

/**
 * @param Template $template
 * @return string
 */
function getStars($template)
{
    $avg = $template->getAvgRate();
    $nbStar = 0;
    $stringBuilder = '';
    while ($nbStar < 5 && $avg >= 1) {
      $stringBuilder .= '<img src="../view/resources/img/rate_stars/star.png" alt="" />' . "\n";
      $avg -= 1;
      $nbStar++;
    }
    if ($nbStar < 5 && $avg >= 0.5) {
      $stringBuilder .= '<img src="../view/resources/img/rate_stars/half-star.png" alt="" />' . "\n";
      $nbStar++;
    }
    while ($nbStar < 5) {
      $stringBuilder .= '<img src="../view/resources/img/rate_stars/empty-star.png" alt="" />' . "\n";
      $nbStar++;
    }
    return $stringBuilder;
}

/**
 * @param array $templates
 * @param int $first
 * @param int $nb
 * @return array
 */
function paginator($templates, $num_page, $nb)
{
  $part = array_slice($templates, ($num_page - 1) * $nb, $nb);
  return $part;
}
