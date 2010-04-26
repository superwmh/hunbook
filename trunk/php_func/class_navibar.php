<?php
/*
 * 導覽列 Navi bar (Breadcrumbs)
 */

//
Class NaviBar
{
  private $breadcrumbs = array();
  private $split = ' &raquo; ';

  public function add($name, $url = '') {
    if ($url == '')
      $this->breadcrumbs[] = $name;
    else
      $this->breadcrumbs[] = '<a href="'. $url .'">'. $name .'</a>';
  }

  public function export() {
    $rtn = '<div class="breadcrumbs">';
    $rtn .= join($this->split, $this->breadcrumbs);
    $rtn .= '</div>';
    return $rtn;
  }
}

?>