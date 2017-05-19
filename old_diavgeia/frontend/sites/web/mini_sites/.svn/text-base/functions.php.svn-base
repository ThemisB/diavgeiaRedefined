<?php

require_once('queries.php' );

function get_xml_header() {
  return '<?xml version="1.0" encoding="utf-8"?>';
}

function get_row_url($row) {
  global $site_url;
  $str = '<li><a href="' . $row['url'] . '">' . $row['label'];
  if ($row['count'] !== false) {
    $str .= ' (<span>' . $row['count'] . '</span>)</a></li>';
  } else {
    $str .= '</a></li>';
  }
  return $str;
}

function get_org_base_url($org_latin_name) {
  global $config;
  return $config['base_url'] . '/' . $org_latin_name;
}

function get_dl_url($ada) {
  global $get_doc_url;
  if (strrpos($get_doc_url, ".php") === strlen($get_doc_url) - strlen(".php")) {
    return $get_doc_url . "?ada=$ada";
  } else {
    return $get_doc_url . "/" . $ada;
  }
}

function get_decision_url($ada, $label = false) {
  global $config;
  if ($label === false)
    $label = hh($ada);
  $url = $config['site_url'] . '/ada/' . $ada;
  return "<a href=\"$url\">$label</a>";
}

function get_more_ajax_results_url($id, $url) {
  return '';
  $str = '<a onclick="get_more_results( \'' . $id . '\', \'' . $url . '\' class="ajax_pagination" href="">More&gt;&gt;</a>';
  return $str;
}

function get_more_results_url($url) {
  return '<a class="moredocs" href="' . $url . '">Περισσότερα &raquo;</a>';
}

function get_per_signers($active_only, $from, $limit, &$pagination = null) {
  global $config;

  $arr = apofaseis_per_signer($active_only, $config['foreas'], $from, $limit);
  $result = '<ul class="per_type_list">';
  foreach ($arr['rows'] as $row) {
    $result .= get_row_url($row);
  }
  $result .= '</ul>';
  if ($from > 0 || $arr['pagination']['has_more']) {
    $url = $config['site_url'] . '/list.php?l=signer';
    $result .= get_more_results_url($url);
  }
  if (!is_null($pagination))
    $pagination = $arr['pagination'];
  $result .= update_ajax_pagination('signer', $arr['pagination']);
  return $result;
}

/* Get Per Type 
  Used In: index.php
 */

function get_per_type($from, $limit, &$pagination = null) {
  global $config;

  $arr = apofaseis_per_eidos($config['foreas'], $from, $limit);
  $result = '<ul class="per_type_list">';
  foreach ($arr['rows'] as $row) {
    $result .= get_row_url($row);
  }
  $result .= '</ul>';
  if ($from > 0 || $arr['pagination']['has_more']) {
    $url = $config['site_url'] . '/list.php?l=dtypes';
    $result .= get_more_results_url($url);
  }
  if (!is_null($pagination))
    $pagination = $arr['pagination'];
  $result .= update_ajax_pagination('type', $arr['pagination']);
  return $result;
}

/* Get Per Thema
  Used In: index.php
 */

function get_per_thema($from, $limit, &$pagination = null) {
  global $config;

  $arr = apofaseis_per_thema($config['foreas'], $from, $limit);
  $result = '<ul class="per_type_list">';
  foreach ($arr['rows'] as $row) {
    $result .= get_row_url($row);
  }
  $result .= '</ul>';
  if ($from > 0 || $arr['pagination']['has_more']) {
    $url = $config['site_url'] . '/list.php?l=themes';
    $result .= get_more_results_url($url);
  }
  if (!is_null($pagination))
    $pagination = $arr['pagination'];
  $result .= update_ajax_pagination('thema', $arr['pagination']);
  return $result;
}

function all_orgs() {
  global $config;
  return ( $config['foreas']['eid'] == 0 );
}

function get_decision_div($row) {
  global $config;
  global $SITE_PREVIEW;

  $latin_name = '';
  $name = '';

  $result = '<div class="doc"><div class="doctitle">';
  $result .= get_decision_url($row['ada'], hh($row['thema']));

  /* preview */
  if ($SITE_PREVIEW) {
    $ada = $row['ada'];
    $id = $row['id'];
    for ($i = 1; $i <= 3; $i++) {
      $url = $config['site_url'] . "/preview.php?p=$i&ada=$ada";
      $img_url = $config['site_url'] . "/images/preview.png";
      $class = ( $i == 1 ? 'preview' : 'preview invis' );
      $alt = "Προεπισκόπιση των τριών πρώτων σελίδων της πράξης.";
      if ($i == 1) {
        $result .= "<a title=\"$alt\" href=\"$url\" rel=\"d_$id\" class=\"$class\">";
        $result .= "<img src=\"$img_url\">";
        $result .= "</a>";
      } else {
        $result .= "<a href=\"$url\" rel=\"d_$id\" class=\"$class\"></a>";
      }
    }
  }

  /* end of preview */
  $result .= '</div>';

  if (all_orgs()) {
    $result .= '<div class="foreasinfo">';
    $result .= '<span style="clear:both;" class="foreas">Φορεάς: ';
    $name = get_foreas_name($row['lastlevel'], $latin_name);
    if ($latin_name) {
      $result .= '<a href="' . get_org_base_url($latin_name) . '">' . $name . '</a></span>';
    } else {
      $result .= '<strong>' . $name . '</strong></span>';
    }
    $result .= '</div><div style="clear:both"></div>';
  }
  $result .= '<div class="docinfo">';
  $result .= '<span class="date">ΗΜΕΡΟΜΗΝΙΑ: ';
  $result .= '<strong>' . format_date($row['apofaseis_time']) . '</strong></span>';
  $result .= '<span class="ada">ΜΟΝΑΔΙΚΟΣ ΑΡΙΘΜΟΣ: <strong>' . $row['ada'] . '</strong></span></div>';
  $result .= '<div class="doctype"><span class="type">';
  //$result .= '<strong>' . hh($row['eidos_apofasis']) . '</strong></span>';
  $result .= '</div></div>';

  //$result .= '<a class="getdoc" href="' . get_dl_url($row['ada']) . '">Μεταφόρτωση</a></div></div>';
  return $result;
}

/* Get Latest Decisions
  Used In: index.php
 */

function get_latest_decisions($limit) {
  global $config;

  if (!isset($_REQUEST['s'])) {
    $_REQUEST['s'] = 0;
  }
  if (!isset($_REQUEST['l'])) {
    $_REQUEST['l'] = $limit;
  }
  $_REQUEST['s'] = urlencode($_REQUEST['s']);
  $_REQUEST['l'] = urlencode($_REQUEST['l']);

  $arr = apofaseis_latest($config['foreas'], $_REQUEST['s'], $_REQUEST['l']);
  $rows = $arr['rows'];
  if (count($rows) == 0) {
    $config['foreas']['no_decisions'] = true;
    return '<div class="not_found">Δεν υπάρχουν σχετικά έγγραφα για τον φορέα</div>';
  }
  $pagination = $arr['pagination'];
  $count = count($rows);
  $total = $pagination['total'];

  foreach ($rows as $row) {
    $result .= get_decision_div($row);
  }

  $result .= "<span><b>Σύνολο: </b>$count / $total</span>";
  if ($total > 0) {
    $page_current = (int) ($pagination['from'] / $pagination['limit']) + 1;
    $page_total = (int) ($total / $pagination['limit']);
    if ($total % $pagination['limit'] > 0)
      $page_total++;
    $result .= "<span style=\"float:right;\"><b>Σελίδα: </b>$page_current / $page_total</span>";
  }
  //$result .= get_pagination($pagination, $limit);
  $result .=get_pagination_optimized($pagination, $limit, $total);
  return $result;
}

/* Get Latest Decisions
  Used In: index2.php
 */

function get_latest_decisions2($limit) {
  global $config;

  if (!isset($_REQUEST['s'])) {
    $_REQUEST['s'] = 0;
  }
  if (!isset($_REQUEST['l'])) {
    $_REQUEST['l'] = $limit;
  }
  $_REQUEST['s'] = urlencode($_REQUEST['s']);
  $_REQUEST['l'] = urlencode($_REQUEST['l']);

  $arr = apofaseis_latest2($config['foreas'], $_REQUEST['s'], $_REQUEST['l']);
  /*
    ["rows"]=>
    array(8) {
    [0]=>
    array(7) {
    ["id"]=>
    string(7) "3782276"
    ["ada"]=>
    string(14) "45ΠΜΗ-ΧΧ3"
    ["thema"]=>
    string(81) "ΑΠΟΦΑΣΗ ΔΕΣΜΕΥΣΗΣ ΠΙΣΤΩΣΗΣ 231/0899 ΠΟΣΟΥ 1242,00 Ε"
    ["lastlevel"]=>
    string(2) "15"
    ["apofaseis_time"]=>
    string(19) "2011-10-05 13:43:05"
    ["apofasi_date"]=>
    string(10) "2011-10-03"
    ["eidos_apofasis"]=>
    string(67) "ΛΟΙΠΕΣ ΑΤΟΜΙΚΕΣ ΔΙΟΙΚΗΤΙΚΕΣ ΠΡΑΞΕΙΣ"
    }
   */
  $rows = $arr['rows'];
  if (count($rows) == 0) {
    $config['foreas']['no_decisions'] = true;
    return '<div class="not_found">Δεν υπάρχουν σχετικά έγγραφα για τον φορέα</div>';
  }
  $pagination = $arr['pagination'];
  $count = count($rows);
  $total = $pagination['total'];

  foreach ($rows as $row) {
    $result .= get_decision_div($row);
  }

  $result .= "<span><b>Σύνολο: </b>$count / $total</span>";
  if ($total > 0) {
    $page_current = (int) ($pagination['from'] / $pagination['limit']) + 1;
    $page_total = (int) ($total / $pagination['limit']);
    if ($total % $pagination['limit'] > 0)
      $page_total++;
    $result .= "<span style=\"float:right;\"><b>Σελίδα: </b>$page_current / $page_total</span>";
  }
  $result .= get_pagination($pagination, $limit);

  return $result;
}

/* Get Pagination
  Used In: index.php / get_latest_decisions()
 */

function get_pagination_url($s, $limit, $find_args = null) {
  global $config;
  if ($find_args) {
    $find_args['from'] = $s;
    $find_args['limit'] = $limit;
    $url = get_search_url($find_args);
    return $url;
  }
  $url = $config['site_url'] . "/index.php?";
  return $url . "s=$s&l=$limit";
}

function get_pagination($pagination, $limit) {
  global $search_url;
  global $site_url;

  $result .= '<div class="paginator">';
  $find_args = array_key_exists('find_args', $pagination) ? $pagination['find_args'] : null;
  if ($pagination['from'] > 0) {
    $url = get_pagination_url($pagination['from'] - $limit, $limit, $find_args);
    $result .= '<a class="moredocs moredocsleft" href="' . $url . '">';
    $result .= '&laquo; Προηγούμενη Σελίδα</a>';
  }

  if ($pagination['from'] + $pagination['limit'] < $pagination['total']) {
    $url = get_pagination_url($pagination['from'] + $limit, $limit, $find_args);
    $result .= '<a class="moredocs" href="' . $url . '">';
    $result .= 'Επόμενη Σελίδα &raquo;</a>';
  }
  $result .= '</div>';
  return $result;
}

function printPaginationForm($url, $rescount,$formName) {
  echo "<form id=\"".$formName."\" method=\"POST\" action=\"" . $url . "\" >";
  echo "<input type=\"hidden\" name=\"rescount\" id=\"rescount\" value=\"" . $rescount . "\" />";
  echo "</form>";
}

function get_pagination_optimized($pagination, $limit, $rescount) {
  global $search_url;
  global $site_url;

  $result .= '<div class="paginator">';
  $find_args = array_key_exists('find_args', $pagination) ? $pagination['find_args'] : null;

  if ($pagination['from'] > 0) {
    $url = get_pagination_url($pagination['from'] - $limit, $limit, $find_args);
    printPaginationForm($url, $rescount,"resPrevForm");
    $result .= '<a class="moredocs moredocsleft" href="javascript:document.getElementById(\'resPrevForm\').submit()">';
    $result .= '&laquo; Προηγούμενη Σελίδα</a>';
  }

  if ($pagination['from'] + $pagination['limit'] < $pagination['total']) {
    $url = get_pagination_url($pagination['from'] + $limit, $limit, $find_args);
    printPaginationForm($url, $rescount,"resNextForm");
    $result .= '<a class="moredocs"  href="javascript:document.getElementById(\'resNextForm\').submit()">';
    $result .= 'Επόμενη Σελίδα &raquo;</a>';
  }
  $result .= '</div>';
  return $result;
}

/* Get Listed Items
  Used In: list.php
 */

function get_listed_items($type, $from = 0, $limit = false) {
  global $config;

  if ($type == 'themes') {
    $arr = apofaseis_per_thema($config['foreas'], 0, $limit);
  } else if ($type == 'dtypes') {
    $arr = apofaseis_per_eidos($config['foreas'], 0, $limit);
  } else if ($type == 'signer') {
    $arr = apofaseis_per_signer(true, $config['foreas'], 0, $limit);
  } else if ($type == 'allsigner') {
    $arr = apofaseis_per_signer(false, $config['foreas'], 0, $limit);
  } else if ($type == 'monades') {
    $arr = apofaseis_per_monada($config['foreas'], 0, $limit);
  } else {
    echo "Invalid type: $type";
    exit();
  }

  $active_signer = true;
  $result = '<ul class="per_type_list">';
  foreach ($arr['rows'] as $row) {
    if ($type == 'allsigner') {
      if ($active_signer && $row['active'] == '0') {
        $result .= '</ul>';
        $result .= '<div class="latest_docs">';
        $result .= 'Παλαιότεροι υπογράφοντες πράξεων';
        $result .= '</div>';
        $result .= '<ul class="per_type_list">';
        $active_signer = false;
      }
    }
    $result .= get_row_url($row);
  }
  $result .= '</ul>';
  return $result;
}

/* Get More Search Types
  Used In: ap_sidebar.php
 */

function get_more_search_types() {

  global $search_url;
  global $ministry_id;

  $query = "SELECT * from eidi_apofaseon limit 100";
  $results = mysql_query($query);
  if (mysql_num_rows($results) > 0) {
    $result = '<ul>';
    while (($row = mysql_fetch_assoc($results) ) !== false) {
      $result .= '<li><a href="' . $search_url . '/apservice.php?pb_id=' . $ministry_id . '&eia=' . $row['ID'] . '">' . $row['name'] . "</a></li>";
    }
    $result .= '</ul>';
    return $result;
  }
}

/* Get Single Options
  Used In: ap_single_sidebar.php
 */

function get_single_options() {
  $result = '<ul>';
  $result .= '<li>Aποστολή με email</li>';
  $result .= '<li>Διαμοιρασμός</li>';
  $result .= '</ul>';
  return $result;
}

/* Get Single Breadcrump
  Used In: lib/print_cesicion.php
 */

function get_single_breadcrump($subject) {
  global $config;
  global $site_url;
  global $ministry_id;
  global $INDEXER;

  if ($INDEXER)
    return "";
  if (!all_orgs()) {
    $result = '<div class="breadcrumb"><a href="' . $site_url . '/">Αρχική</a> &raquo;  ';
  } else {
    $result = '<div class="breadcrumb">';
  }
  $result .= htmlspecialchars($subject);
  $result .= '</div>';
  return $result;
}

?>
