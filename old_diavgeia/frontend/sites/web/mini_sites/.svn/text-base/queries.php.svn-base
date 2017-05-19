<?php

if (isset($_GET['list_for_search_signer'])) {
    require_once('config.php');
    $to_return = jquery_update_signers($_GET['list_for_search_signer']);
    
    echo $to_return;
}

if (isset($_GET['list_for_search_thema'])) {
    require_once('config.php');
    $to_return = jquery_update_thema($_GET['list_for_search_thema']);
    
    echo $to_return;
}

if (isset($_GET['list_for_search_eidos'])) {
    require_once('config.php');
    $to_return = jquery_update_eidos($_GET['list_for_search_eidos']);
    
    echo $to_return;
}

function jquery_update_signers ($foreas) {
    $to_ret = '';
    
    $query = "SELECT ypografontes.ID,ypografontes.pb_id,
                    ypografontes.firstname, ypografontes.lastname, ypografontes_types.name AS type_name
                  FROM ypografontes,ypografontes_types,apofaseis FORCE INDEX(idx_apofaseis_ypografwn)
                  WHERE ypografontes.type_id=ypografontes_types.ID
                  AND apofaseis.telikos_ypografwn = ypografontes.ID
                  AND ypografontes.en_energeia='1'
                  AND apofaseis.lastlevel = \"$foreas\"
                  GROUP BY (apofaseis.telikos_ypografwn)
                  ORDER BY ypografontes_types.importance";
    
    $res = mysql_query($query) or die (mysql_error());
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
        $id = $row['ID'];
        $label = get_signer_signature($row);
        $pbid = $row['pb_id'];
        $to_ret.= "<option value=\"$id\">$label</option>";
    }
    
    return $to_ret;
}



function jquery_update_thema ($foreas) {
    $to_ret = '';
    $query = "SELECT * FROM thematikes";
    $res = mysql_query($query);
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
        $id = $row['ID'];
        $name = $row['name'];
        $ret_test['rows'][$id] = array('id' => $id,
            'label' => $name);
    }
    mysql_free_result($res);

    $query = "SELECT distinct(thematiki)
                FROM apofaseis use index(idx_per_thema)
                WHERE lastlevel=\"$foreas\"
                AND apofaseis.status='active'
                AND apofaseis.thematiki != ''
                AND apofaseis.thematiki NOT LIKE '%##%'
                GROUP BY thematiki";

    $res = mysql_query($query) or die(mysql_error());

        $i = 0;
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
        $thematikes_list = db_to_list($row['thematiki']);
        foreach ($thematikes_list as $id) {
            if (!array_key_exists($id, $ret_test['rows'])) {
                continue;
            }
            $thematiki_name[$id] = $ret_test['rows'][$id]['label'];
        }
        $i++;
    }
    foreach ($thematiki_name as $them=>$value) {
        $id = $them;
        $label = $value;
        $to_ret.= "<option value=\"$id\">$label</option>";
    }
    mysql_free_result($res);
    
    return $to_ret;
}



function jquery_update_eidos ($foreas) {
    $to_ret = '';
    
    $query = "SELECT eidos_apofasis,
                           (SELECT name FROM eidi_apofaseon 
                           WHERE ID = eidos_apofasis) as name
                           FROM apofaseis FORCE INDEX(idx_find_per_eidos)
                           WHERE lastlevel =\"$foreas\"
                           AND status='active'
                           GROUP BY eidos_apofasis order by name ";

    $res = mysql_query($query) or die(mysql_error());
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
        $id = $row['eidos_apofasis'];
        $label = $row['name'];
        $to_ret.= "<option value=\"$id\">$label</option>";
    }
    mysql_free_result($res);
    
    return $to_ret;
}


/* Initial configuration code */

function get_foreas_latin_name_from_url() {
  if (!isset($_REQUEST['fid'])) {
    // TODO: redirect to global site
    return 'ypes';
  } else {
    $ret = mysql_escape_string($_REQUEST['fid']);
    return $ret;
  }
}

function foreas_not_found() {
  global $config;
  return array_key_exists('not_found', $config['foreas']) && $config['foreas']['not_found'];
}

function get_all_tables() {
  $tables = array();
  $q = "SELECT pb_id, table_name, ypourgeio_label FROM ypourgeia
		  GROUP BY table_name";
  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $tables[] = array('yp_pb_id' => $row['pb_id'],
        'name' => $row['table_name'],
        'label' => $row['ypourgeio_label']);
  }
  return $tables;
}

function get_foreas_account_data($pb_id, $column) {
  static $names;
  if (!isset($names)) {
    $names = array();
    $q = "SELECT DISTINCT( foreas_pb_id ), foreas_latin_name,
			  diefthinsi, arithmos, TK
			  FROM oda_members_master
			  WHERE status=1
			  GROUP BY foreas_pb_id";
    $res = mysql_query($q);
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      $id = $row['foreas_pb_id'];
      $latin_name = $row['foreas_latin_name'];
      if (strpos($latin_name, "/") !== false)
        continue;
      $names[$id] = array('latin_name' => $latin_name,
          'address' => format_address(
                  $row['diefthinsi'], $row['arithmos'], $row['TK']
      ));
    }
  }
  if (!array_key_exists($pb_id, $names))
    return false;
  return $names[$pb_id][$column];
}

function get_foreas_latin_name($pb_id) {
  return get_foreas_account_data($pb_id, 'latin_name');
}

function get_foreas_address($pb_id) {
  return get_foreas_account_data($pb_id, 'address');
}

function get_foreas_table($pb_id) {
  static $tables;
  static $ret;
  if (!isset($tables)) {
    $tables = get_all_tables();
  }
  if (!isset($ret)) {
    $ret = array();
  }
  if (array_key_exists($pb_id, $ret)) {
    return $ret[$pb_id];
  }

  foreach ($tables as $table) {
    $yp_pb_id = $table['yp_pb_id'];
    $name = $table['name'];
    $label = $table['label'];
    $q = "SELECT * FROM $name WHERE pb_id='$pb_id'";
    $res = mysql_query($q);
    if (mysql_num_rows($res) == 0)
      continue;
    $row = mysql_fetch_assoc($res);
    mysql_free_result($res);
    $ret[$pb_id] = array(
        'latin_name' => get_foreas_latin_name($pb_id),
        'yp_pb_id' => $yp_pb_id,
        'table_name' => $name,
        'table_label' => $label,
        'foreas_row' => $row);
    return $ret[$pb_id];
  }
  return false;
}

function get_thematiki($thid) {
  static $ret = array();
  if (count($ret) == 0) {
    $q = "SELECT ID, name FROM thematikes";
    $res = mysql_query($q);
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      $id = $row['ID'];
      $name = $row['name'];
      $ret[$id] = $name;
    }
  }
  return array_key_exists($thid, $ret) ? $ret[$thid] : "ERROR: $thid";
}

function read_all_foreas_info() {
  $ret = array(
      'pb_id' => 0,
      'table_name' => '',
      'latin_name' => 'all',
      'is_ministry' => false,
      'eid' => 0,
      'name' => 'Όλοι οι φορείς'
  );
  return $ret;
}

function read_foreas_info($latin_name) {
  $ret = array();
  $not_found = array('not_found' => true);

  $latin_name = mysql_escape_string($latin_name);
  if ($latin_name == 'all')
    return read_all_foreas_info();
  if (!is_numeric($latin_name)) {
    $latin_name = mysql_escape_string($latin_name);
    $q = "SELECT foreas_pb_id FROM oda_members_master
			  WHERE foreas_latin_name='$latin_name'";
    $res = mysql_query($q);
    $row = mysql_fetch_assoc($res);
    if ($row === false)
      return $not_found;
    $fid = $row['foreas_pb_id'];
  }
  else {
    $fid = $latin_name;
  }

  $table = get_foreas_table($fid);
  if ($table === false)
    return $not_found;
  $table_name = $table['table_name'];

  $ret['pb_id'] = $fid;
  $ret['table_name'] = $table_name;
  $ret['latin_name'] = $latin_name;

  if ($table_name == 'yp_xwris_ypourgeio' || $table_name == 'foreis_mt') {
    $ret['is_ministry'] = false;
    $ret['eid'] = $fid;
  } else {
    $ret['is_ministry'] = true;
    $ret['eid'] = $table['yp_pb_id'];
  }

  // We use effective ID to get name
  $eid = mysql_escape_string($ret['eid']);
  $q = "SELECT * FROM $table_name WHERE pb_id='$eid'";
  $res = mysql_query($q);
  $row = mysql_fetch_assoc($res);
  if ($row === false)
    return $not_found;
  mysql_free_result($res);

  $ret['name'] = $row['name'];
  return $ret;
}

/* Misc  */

function get_total_found_rows() {
  $res = mysql_query("SELECT FOUND_ROWS()");
  $row = mysql_fetch_array($res);
  return $row[0];
}

function get_query_count($res) {
  $row = mysql_fetch_row($res);
  if ($row === false)
    return 0;
  return $row[0];
}

function format_date($db_date) {
  if ($db_date == '')
    return '';
  list( $date, $time ) = explode(' ', $db_date);
  list( $year, $month, $day ) = explode('-', $date);
  $str = "" . "$day/$month/$year";
  if ($time)
    $str .= " $time";
  return $str;
}

function format_address($addr_street, $addr_number, $addr_tk) {
  $ret = $addr_street;
  if ($addr_number != '' && $addr_number != '0' &&
          $addr_number != 'ΑΝΕΥ' && $addr_number != '-') {
    $ret .= " $addr_number";
  }
  if ($addr_tk != '')
    $ret .= " $addr_tk";
  return $ret;
}

# RSS

function get_rss_title() {
  global $config;
  if (all_orgs()) {
    return "RSS XML - Όλες οι αποφάσεις";
  } else {
    return "RSS - XML - " . $config['foreas']['name'];
  }
}

function get_rss_limit() {
  global $SITE_RSS_LIMIT;
  if (isset($SITE_RSS_LIMIT))
    return $SITE_RSS_LIMIT;
  else
    return 100;
}

function get_top_expenses_limit() {
  global $SITE_TOP_EXPENSES_LIMIT;
  if (isset($SITE_TOP_EXPENSES_LIMIT))
    return $SITE_TOP_EXPENSES_LIMIT;
  else
    return 0;  // in order to explicitly enable it
}

function get_pages_size() {
  global $SITE_PAGES_SIZE;
  if (isset($SITE_PAGES_SIZE))
    return $SITE_PAGES_SIZE;
  else
    return 8;
}

function get_search_pages_size() {
  global $SITE_SEARCH_PAGES_SIZE;
  if (isset($SITE_SEARCH_PAGES_SIZE))
    return $SITE_SEARCH_PAGES_SIZE;
  else
    return 10;
}

function get_last_rss_build($db_time) {
  list( $date, $time ) = explode(' ', $db_time);
  list( $year, $month, $day ) = explode('-', $date);
  list( $hour, $minute, $second ) = explode(':', $time);
  $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
  return date("D, d M Y H:i:s O", $timestamp);
}

function cdata($str) {
  return '<![CDATA[' . $str . ']]>';
}

function get_rss_envelope($rows, $criteria = array()) {
  global $config;
  $foreas = $config['foreas'];

  $rss_url = $config['rss_url'];
  $description = "XML output";
  if (count($criteria) > 0) {
    $description .= ' - ';
    $description .= get_criteria_string($criteria);
  }
  $managing_editor = "email@domain.name";
  $webMaster = "email@domain.name";

  # Get date of last submission
  $now = date("D, d M Y H:i:s O");
  $last_build_date = $now;
  if (count($rows) == 0) {
    $last_build_date = $now;
  } else {
    $last_timestamp = $rows[0]['apofaseis_time'];
    $last_build_date = get_last_rss_build($last_timestamp);
  }

  $xml = new SimpleXMLElement(get_xml_header() . '<rss version="2.0"></rss>');
  $channel = $xml->addChild('channel');
  $channel->addChild('title', hh(get_rss_title()));
  $channel->addChild('link', hh($rss_url));
  $channel->addChild('description', hh($description));
  $channel->addChild('pubDate', hh($last_build_date));
  $channel->addChild('lastBuildDate', hh($last_build_date));
  $channel->addChild('docs', hh($rss_url));
  $channel->addChild('managingEditor', hh($managing_editor));
  $channel->addChild('webMaster', hh($webmaster));
  return $xml;
}

function get_rss_items($xml, $rows) {
  global $config;

  $channels = $xml->xpath('/rss/channel');
  $channel = $channels[0];
  foreach ($rows as $row) {
    $title = $row['thema'];
    $foreas_name = get_foreas_name($row['lastlevel']);
    $link = $config['site_url'] . '/ada/' . htmlspecialchars($row['ada']);
    $description = '<b>Θέμα: </b>' . clean_xml($row['thema']) . '<br/>';
    $description .= '<b>Ημ/νια: </b>' . format_date($row['apofaseis_time']) . '<br/>';
    $description .= '<b>Φορέας: </b>' . htmlspecialchars($foreas_name) . '<br/>';
    $description .= '<b>Kωδικός </b>' . $row['ada'] . '<br/>';

    $item = $channel->addChild('item');
    $item->addChild('title', hh(clean_xml($title)));
    $item->addChild('link', hh($link));
    $item->addChild('description', hh(clean_xml($description)));
  }
  return $xml;
}

function sort_by_count_desc($a, $b) {
  if ($b['count'] == $a['count'])
    return strcmp($a['label'], $b['label']);
  return $b['count'] - $a['count'];
}

function sort_by_label_desc($a, $b) {
  return strcmp($a['label'], $b['label']);
}

function array_to_db($arr) {
  return '(' . implode(',', $arr) . ')';
}

function get_excluded_ids() {
  global $SITE_EXCLUDE_IDS;
  if (isset($SITE_EXCLUDE_IDS) && is_array($SITE_EXCLUDE_IDS) &&
          count($SITE_EXCLUDE_IDS) > 0) {
    return array_to_db($SITE_EXCLUDE_IDS);
  }
  return false;
}

function get_foreas_query($foreas, $table = 'apofaseis') {
  global $SITE_EXCLUDE_IDS;

  $eid = $foreas['eid'];
  if ($eid == 0) {
    $q = " $table.status='active' ";
    if (isset($SITE_EXCLUDE_IDS) &&
            is_array($SITE_EXCLUDE_IDS) &&
            count($SITE_EXCLUDE_IDS) > 0) {
      $q = " ( $q AND $table.lastlevel NOT IN " . array_to_db($SITE_EXCLUDE_IDS) . " ) ";
    }
  } else if ($foreas['is_ministry']) {
    $q = " $table.lastlevel = '$eid' ";
  } else {
    $q = " $table.lastlevel = '$eid' ";
  }
  return $q;
}

function get_foreas_name($pb_id, &$latin_name = null) {
  static $ret;
  if (!isset($ret))
    $ret = array();
  if (!array_key_exists($pb_id, $ret)) {
    $q = "SELECT A.foreas_latin_name, B.name
			FROM oda_members_master A, foreis B
			WHERE A.foreas_pb_id='$pb_id'
			AND B.pb_id='$pb_id'";
    $res = mysql_query($q);
    $row = mysql_fetch_assoc($res);
    $ret[$pb_id] = array(
        'name' => $row['name'],
        'latin_name' => $row['foreas_latin_name']
    );
    mysql_free_result($res);
  }
  if (!is_null($latin_name))
    $latin_name = $ret[$pb_id]['latin_name'];
  return $ret[$pb_id]['name'];
}

function get_search_url($args) {
  global $config;
  $url = $config['search_url'];
  foreach ($args as $k => $v) {
    if (is_array($v))
      $v = implode(',', $v);
    $v = str_replace('/', '', $v);
    $url .= '/' . urlencode($k) . ':' . urlencode($v);
  }
  return $url;
}

function get_last_submission_time($foreas) {
  $q = "SELECT MAX( submission_timestamp ) FROM apofaseis
		  WHERE " . get_foreas_query($foreas);
  $res = mysql_query($q);
  $row = mysql_fetch_array($res);
  if ($row === false)
    return false;
  return $row[0];
}

function init_ajax_pagination() {
  global $config;

  $str = '';
  $str .= '<script language="javascript">';
  $str .= "site_url = '" . $config['site_url'] . "'";
  $str .= ';';
  $str .= '</script>';
  echo $str;
}

function update_ajax_pagination($type, $pagination) {
  $str = '';
  $str .= '<script language="javascript">';
  $str .= "pagination[ '$type' ][ 'total' ] = ";
  $str .= $pagination['total'];
  $str .= ';';
  $str .= '</script>';
  return $str;
}

function print_ajax_pagination_buttons($type) {
  global $config;
  if (!$config['ajax_pagination'])
    return;
  echo '<button class="pagination_button pagination_button_left" id="btn_type_', $type, '_prev">&lt;&lt;</button>';
  echo '<button class="pagination_button" id="btn_type_', $type, '_next">&gt;&gt;</button>';
}

/* ret[ 'rows' ] contains ALL rows! */

function add_pagination_info(&$ret, $from, $limit) {
  $total_count = count($ret['rows']);
  $ret['pagination']['from'] = $from;
  $ret['pagination']['limit'] = $limit;
  $ret['pagination']['total'] = $total_count;
  if ($from || $limit !== false) {
    if ($limit) {
      $ret['rows'] = array_slice($ret['rows'], $from, $limit);
      if ($limit < $total_count - $from)
        $ret['pagination']['has_more'] = true;
    }
    else {
      $ret['rows'] = array_slice($ret['rows'], $from);
    }
  }
  return $ret;
}

function get_signer_signature($row, $full = false) {
  $str = $row['type_name'] . ' - ' . $row['firstname'] . ' ' . $row['lastname'];
  if ($full)
    $str .= ' - ' . $row['title_name'];
  return $str;
}

function apofaseis_per_thema($foreas, $from = 0, $limit = false) {
  $ret = array('rows' => array(), 'pagination' => array('has_more' => false));
  $query = "SELECT * FROM thematikes";
  $res = mysql_query($query);
  $total_count = mysql_num_rows($res);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $id = $row['ID'];
    $name = $row['name'];
    $ret['rows'][$id] = array('id' => $id,
        'url' => get_search_url( array( 'thid' => $id ) ),
        'label' => $name,
        'count' => 0);
  }
  mysql_free_result($res);

  if ($limit == false)
    $limit = $total_count;
 
  $query = "SELECT thematiki, count(id) as total
		FROM apofaseis force index(idx_per_thema)        
		WHERE lastlevel=" . $foreas['eid'] . "
                AND apofaseis.status='active'
		GROUP BY thematiki
		ORDER BY total DESC
		LIMIT $from, $limit";

  $res = mysql_query($query);
  
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $total = $row['total'];
    $thematikes_list = db_to_list($row['thematiki']);
    foreach ($thematikes_list as $id) {
      if (!array_key_exists($id, $ret['rows']))
        continue;
      $ret['rows'][$id]['count'] += $total;
    }
  }

  mysql_free_result($res);
  $ret['rows'] = array_values($ret['rows']);
  usort($ret['rows'], 'sort_by_count_desc');
  add_pagination_info($ret, $from, $limit);
  
  return $ret;
}

function apofaseis_per_eidos($foreas, $from = 0, $limit = false) {
  $ret = array('rows' => array(), 'pagination' => array('has_more' => false));
  $query = "SELECT * FROM eidi_apofaseon";
  $res = mysql_query($query);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $id = $row['ID'];
    $name = $row['name'];
    $query2 = "SELECT COUNT(*) FROM apofaseis 
				   WHERE eidos_apofasis='$id'
				   AND apofaseis.status='active' AND " .
            get_foreas_query($foreas);
    $res2 = mysql_query($query2);
    if (( $count = get_query_count($res2) ) == 0)
      continue;
    if ($count == 0)
      continue;
    $ret['rows'][] = array('id' => $id,
        'url' => get_search_url(array('eia' => $id)),
        'label' => $name,
        'count' => $count);
    mysql_free_result($res2);
  }
  mysql_free_result($res);
  usort($ret['rows'], 'sort_by_count_desc');
  add_pagination_info($ret, $from, $limit);
  return $ret;
}

function apofaseis_per_monada($foreas, $from = 0, $limit = false) {
  $ret = array('rows' => array(), 'pagination' => array('has_more' => false));
  $query = "SELECT count( apofaseis.id ) as total, 
			  monades.ID as id, monades.name as name
			  FROM apofaseis, monades
			  WHERE apofaseis.monada = monades.ID AND "
          . get_foreas_query($foreas) .
          "GROUP BY monades.name";
  $res = mysql_query($query);
  $total_count = mysql_num_rows($res); /* OTS */
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $id = $row['id'];
    $name = $row['name'];
    $count = $row['total'];
    if ($count == 0)
      continue;
    $ret['rows'][] = array('id' => $id,
        'url' => get_search_url(array('unit' => $id)),
        'label' => $name,
        'total_occ' => $total_count,
        'count' => $count);
  }
  mysql_free_result($res);
  usort($ret['rows'], 'sort_by_count_desc');
  add_pagination_info($ret, $from, $limit);
  return $ret;
}

function apofaseis_per_signer($active_only, $foreas, $from = 0, $limit = false, $total_signers = 0) {
  $ret = array('rows' => array(), 'pagination' => array('has_more' => false));
  $eid = $foreas['eid'];
  $restriction = '';
  $ordering = '';
  if ($active_only) {
    $restriction = " AND ypografontes.en_energeia='1' ";
	$ordering = 'ypografontes_types.importance';
  } else {
	$ordering = "ypografontes.en_energeia desc, ypografontes_types.importance";
  }
  $query = "SELECT ypografontes.ID,ypografontes.en_energeia,ypografontes.firstname,ypografontes.lastname,
                   ypografontes.title_name,ypografontes_types.name AS type_name,
                  COUNT( apofaseis.id ) as num
                  FROM ypografontes,ypografontes_types,apofaseis FORCE INDEX(idx_apofaseis_ypografwn)
                  WHERE ypografontes.type_id=ypografontes_types.ID
                  AND apofaseis.telikos_ypografwn = ypografontes.ID
                         $restriction
                  AND  apofaseis.lastlevel = " . $eid . "
                  GROUP BY (apofaseis.telikos_ypografwn)
                  ORDER BY ".$ordering;

  $res = mysql_query($query);
  $total_count = mysql_num_rows($res);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $id = $row['ID'];
    $ret['rows'][] = array('id' => $id,
        'url' => get_search_url(array('ypogid' => $id)),
        'label' => get_signer_signature($row),
        'active' => $row['en_energeia'],
        'total_occ' => $total_count,
        'count' => $row['num']);
  }
  mysql_free_result($res);
  add_pagination_info($ret, $from, $limit);
  return $ret;
}

function apofaseis_latest($foreas, $limit_s, $limit_l) {
  $ret = array('rows' => array(), 'pagination' => array());
  $table = $foreas['table'];
  if (isset($_REQUEST['rescount'])) {
    $total = $_REQUEST['rescount'];
  } else {
   $q = "SELECT COUNT( * ) FROM apofaseis
		  WHERE apofaseis.status='active' AND " . get_foreas_query($foreas);
   $res = mysql_query($q);
   $row = mysql_fetch_array($res);
   $total = $row[0];
   mysql_free_result($res);
  }
  
  

  $ret['pagination']['from'] = $limit_s;
  $ret['pagination']['limit'] = $limit_l;
  $ret['pagination']['total'] = $total;

  $q = "SELECT apofaseis.id as id, 
				apofaseis.ada as ada, 
				apofaseis.thema as thema,
				apofaseis.lastlevel as lastlevel,
				apofaseis.submission_timestamp as apofaseis_time,
				apofaseis.apofasi_date as apofasi_date,
				eidi_apofaseon.name as eidos_apofasis
				FROM apofaseis LEFT JOIN eidi_apofaseon ON ( apofaseis.eidos_apofasis = eidi_apofaseon.ID)
				WHERE apofaseis.status='active' AND
				" . get_foreas_query($foreas) .
          " ORDER BY apofaseis_time DESC LIMIT $limit_s, $limit_l";

  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $ret['rows'][] = $row;
  }
  mysql_free_result($res);
  return $ret;
}

function apofaseis_latest2($foreas, $limit_s, $limit_l) {

  $ret = array('rows' => array(), 'pagination' => array());
  $table = $foreas['table'];
  $q = "SELECT COUNT( * ) FROM apofaseis
		  WHERE apofaseis.status='active' AND " . get_foreas_query($foreas);
  $res = mysql_query($q);
  $row = mysql_fetch_array($res);
  $total = $row[0];
  mysql_free_result($res);

  $ret['pagination']['from'] = $limit_s;
  $ret['pagination']['limit'] = $limit_l;
  $ret['pagination']['total'] = $total;

  $q = "SELECT apofaseis.id as id, 
				apofaseis.ada as ada, 
				apofaseis.thema as thema,
				apofaseis.lastlevel as lastlevel,
				apofaseis.submission_timestamp as apofaseis_time,
				apofaseis.apofasi_date as apofasi_date,
				eidi_apofaseon.name as eidos_apofasis
				FROM apofaseis LEFT JOIN eidi_apofaseon ON ( apofaseis.eidos_apofasis = eidi_apofaseon.ID)
				WHERE apofaseis.status='active' AND
				" . get_foreas_query($foreas) .
          " ORDER BY apofaseis_time DESC LIMIT $limit_s, $limit_l";

  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $ret['rows'][] = $row;
  }
  mysql_free_result($res);

  return $ret;
}

/*
 * RETREIVE LISTINGS FOR ADVANCED SEARCH ---- OTS VERSION
 */

function list_for_search_thema($foreas = '') {
  $ret = array('rows' => array(), 'pagination' => array('has_more' => false));

  if ((!isset($foreas['eid'])) || ($foreas['eid'] != 0)) {
    $query = "SELECT * FROM thematikes
                WHERE hidden !=1";
    $res = mysql_query($query);
    $total_count = mysql_num_rows($res);
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      $id = $row['ID'];
      $name = $row['name'];
      $ret_test['rows'][$id] = array('id' => $id,
          'label' => $name,
          'count' => 0);
    }
    mysql_free_result($res);

    $query = "SELECT thematiki
                    FROM apofaseis 
                    WHERE lastlevel=" . $foreas['eid'] . "
                    AND apofaseis.status='active'
                    GROUP BY thematiki";

    $res = mysql_query($query) or die(mysql_error());

    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      $total = $row['total'];
      $thematikes_list = db_to_list($row['thematiki']);
      foreach ($thematikes_list as $id) {
        if (!array_key_exists($id, $ret_test['rows']))
          continue;
        $thematiki_name = $ret_test['rows'][$id]['label'];
        $ret_test['rows'][$id]['count'] += $total;
      }
      $ret['rows'][$id] = array('id' => $ret_test['rows'][$id]['id'],
          'url' => get_search_url(array('thid' => $ret_test['rows'][$id]['id'])),
          'label' => $ret_test['rows'][$id]['label'],
          'total_occ' => $total_count,
          'count' => $ret_test['rows'][$id]['count']);
    }
    mysql_free_result($res);
    $ret['rows'] = array_values($ret['rows']);
    usort($ret['rows'], 'sort_by_count_desc');
    add_pagination_info($ret, $from, $limit);
  } else {
    $query = "SELECT * FROM thematikes
                WHERE hidden !=1";
    $res = mysql_query($query);
    $total_count = mysql_num_rows($res);

    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      $id = $row['ID'];
      $name = $row['name'];
      $ret['rows'][$id] = array('id' => $id,
          'url' => get_search_url(array('thid' => $id)),
          'label' => $name,
          'total_occ' => $total_count);
    }

    mysql_free_result($res);
    $ret['rows'] = array_values($ret['rows']);
    usort($ret['rows'], 'sort_by_label_desc');
  }


  return $ret;
}

function list_for_search_signer($foreas = '') {
  $ret = array('rows' => array(), 'pagination' => array('has_more' => false));

  if ((!isset($foreas['eid'])) || ($foreas['eid'] != 0)) {
    $query = "SELECT ypografontes.ID,ypografontes.en_energeia,ypografontes.pb_id, ypografontes.title_name,
                    ypografontes.firstname, ypografontes.lastname, ypografontes_types.name AS type_name
                  FROM ypografontes,ypografontes_types,apofaseis FORCE INDEX(idx_apofaseis_ypografwn)
                  WHERE ypografontes.type_id=ypografontes_types.ID
                  AND apofaseis.telikos_ypografwn = ypografontes.ID
                  AND ypografontes.en_energeia='1'
                  AND apofaseis.lastlevel = " . $foreas['eid'] . "
                  GROUP BY (apofaseis.telikos_ypografwn)
                  ORDER BY ypografontes_types.importance";
  } else {
    $query = "SELECT distinct(ypografontes.ID),ypografontes.en_energeia, ypografontes.pb_id,
                    ypografontes.firstname, ypografontes.lastname, ypografontes_types.name AS type_name
                  FROM ypografontes FORCE INDEX(idx_enenergeia_typeid),
                  ypografontes_types FORCE INDEX(importance)
                  WHERE ypografontes.type_id=ypografontes_types.ID
                  AND ypografontes.en_energeia='1'
                  AND ypografontes.firstname != ''
                  AND ypografontes.lastname != ''
                  ORDER BY ypografontes_types.importance";
  }

  $res = mysql_query($query);
  $total_count = mysql_num_rows($res);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $id = $row['ID'];
    $ret['rows'][] = array('id' => $id,
        'url' => get_search_url(array('ypogid' => $id)),
        'pbid' => $row['pb_id'],
        'label' => get_signer_signature($row),
        'active' => $row['en_energeia'],
        'total_occ' => $total_count,
        'count' => $row['num']);
  }
  mysql_free_result($res);
  $ret['rows'] = array_values($ret['rows']);

  return $ret;
}

/* Listings */

function list_for_thema($foreas, $id = false) {
  $ret = apofaseis_per_thema($foreas);
  usort($ret['rows'], 'sort_by_label_desc');
  return $ret;
}

function list_for_eidos($foreas, $id = false) {
  $ret = apofaseis_per_eidos($foreas);
  usort($ret['rows'], 'sort_by_label_desc');
  return $ret;
}

function list_for_signers($foreas, $id = false) {
  $ret = apofaseis_per_signer(false, $foreas);
  usort($ret['rows'], 'sort_by_label_desc');
  return $ret;
}

/* Dictionary values */

function get_thema_name($id) {
  $id = mysql_escape_string($id);
  $query = "SELECT name FROM thematikes WHERE ID='$id'";
  $res = mysql_query($query);
  $row = mysql_fetch_assoc($res);
  return ( $row === false ? '' : $row['name'] );
}

function get_eidos_name($id) {
  $id = mysql_escape_string($id);
  $query = "SELECT name FROM eidi_apofaseon WHERE ID='$id'";
  $res = mysql_query($query);
  $row = mysql_fetch_assoc($res);
  return ( $row === false ? '' : $row['name'] );
}

function get_monada_name($id) {
  $id = mysql_escape_string($id);
  $query = "SELECT name FROM monades WHERE ID='$id'";
  $res = mysql_query($query);
  $row = mysql_fetch_assoc($res);
  return ( $row === false ? '' : $row['name'] );
}

function get_signer_name($id, $full = false) {
  $id = mysql_escape_string($id);
  $query = "SELECT ypografontes.*, ypografontes_types.name as type_name
			  FROM ypografontes, ypografontes_types
			  WHERE ypografontes.ID='$id'
			  AND ypografontes.type_id = ypografontes_types.ID";
  $res = mysql_query($query);
  $row = mysql_fetch_assoc($res);
  if ($row === false)
    return '';
  mysql_free_result($res);
  return get_signer_signature($row, $full);
}

/* Search */

function empty_args($args) {
  $special_args = array('from', 'limit', 'out');
  $total = 0;
  foreach ($special_args as $arg) {
    if (array_key_exists($arg, $args))
      $total++;
  }
  if (count($args) - $total == 0)
    return true;
  return false;
}

function add_to_criteria(&$criteria, $label, $value) {
  $criteria[] = array('label' => $label, 'value' => $value);
}

function get_search_query($args) {
  global $config;
  global $INDEXER;
  $from = 0;
  $limit = get_search_pages_size();
  $criteria = array();
    if ((isset($_POST['field_foreas']))) {
//        $temp = mysql_query("SELECT pb_id FROM foreis WHERE foreis.name = \"".$_POST['field_foreas']."\"");
//        $temp = mysql_fetch_row($temp);
//        $foreas_eid = $temp[0];
        $config['foreas']['eid'] = $_POST['field_foreas_id'];
        $config['foreas']['name'] = $_POST['field_foreas'];
        $foreas = $config['foreas'];
    } else {
        $foreas = $config['foreas'];
    }
  $full_details = array_key_exists('out', $args) &&
          $args['out'] == 'xml';
  $rss = array_key_exists('out', $args) &&
          $args['out'] == 'rss';
  $table = 'apofaseis';
  $deleted = false;

  /* Special handling for deleted decisions */
  if (array_key_exists('ada', $args)) {
    $ada = mysql_escape_string($args['ada']);
    $q = "SELECT id FROM apofaseis_deleted WHERE ada='$ada'";
    $res = mysql_query($q);
    if (mysql_num_rows($res) > 0) {
      $table = 'apofaseis_deleted';
      $deleted = true;
    }
  }

  if ($full_details || $rss) {
    if (array_key_exists('limit', $args) && $args['limit'] > 200) {
      $args['limit'] = 200;
    }
  }

  if (empty_args($args) && !$full_details) {
    return array('from' => 0, 'limit' => 0, 'query' => " SELECT SQL_CALC_FOUND_ROWS * FROM $table WHERE 0", 'criteria' => array());
  }

  $q_select = $q_from = $q_restriction = $q_joins = "";
  if ($full_details) {
    $url = mysql_escape_string($config['site_url']) . '/ada/';
    $q_select .= ", CONCAT( '$url', $table.ada ) AS url ";

    $url = mysql_escape_string(get_dl_url(""));
    $q_select .= ", CONCAT( '$url', $table.ada ) AS pdf_url ";

    $foreas_name = mysql_escape_string($config['foreas']['name']);
    $q_select .= ", '$foreas_name' AS foreas_name";

    $q_select .= ", ypografontes.title_name as signer_title
					  , ypografontes.firstname as signer_firstname
					  , ypografontes.lastname as signer_lastname
					  , ypografontes.en_energeia as signer_active";

    $q_joins .= " LEFT JOIN ypografontes ON $table.telikos_ypografwn = ypografontes.ID ";
  }
  if ($full_details && array_key_exists('any', $args)) {

    $q_joins .= " LEFT JOIN monades ON $table.monada = monades.ID ";
  } else if (array_key_exists('any', $args)) {
    $q_joins .= " LEFT JOIN ypografontes ON $table.telikos_ypografwn = ypografontes.ID ";
    $q_joins .= " LEFT JOIN monades ON $table.monada = monades.ID ";
  }
  if ($INDEXER) {
    $q_select .= ", files_text.content as pdf ";
    $q_joins .= " LEFT JOIN files_text ON $table.ada = files_text.ada ";
  }
  if (isset($_REQUEST['rescount'])) {
    $query = "SELECT ";
  } else {
    $query = "SELECT SQL_CALC_FOUND_ROWS ";
  }
  $query .=
          " $table.ada as ada, $table.thema as thema, $table.lastlevel as lastlevel,$table.submission_timestamp as apofaseis_time, ";
  if ($full_details) {
    $query .=" $table.arithmos_protokolou as arithmos_protokolou, $table.apofasi_date as apofasi_date, $table.submission_timestamp as submission_timestamp,
               eidi_apofaseon.name as eidos_apofasis,$table.thematiki as thematiki,";
  } else if ($rss) {
    $query .="  $table.apofasi_date as apofasi_date, ";
  } else {
    $query .=" $table.id as id,  eidi_apofaseon.name as eidos_apofasis, ";
  }

  if (array_key_exists('ada', $args)) {
    $query .=" $table.user as user, $table.thematiki as thematiki, $table.arithmos_protokolou as arithmos_protokolou, $table.ET_FEK,
                    $table.ET_FEK_tefxos, $table.telikos_ypografwn as telikos_ypografwn,$table.apofasi_date as apofasi_date,
              $table.submission_timestamp as submission_timestamp, monades.name as monada_name,$table.related_ADAs,sha2.sha2 as sha2, ";
  }
  if (!$deleted) {
    $query .= " $table.is_orthi_epanalipsi, 0 as deleted ";
  } else {
    $query .= " 1 as deleted, $table.deletion_reason ";
  }
  $query .=
          " $q_select
  FROM $q_from $table ";

  $query .=" LEFT JOIN eidi_apofaseon on $table.eidos_apofasis=eidi_apofaseon.ID ";
  if ((!array_key_exists('any', $args)) && (array_key_exists('ada', $args))) {
    $query .=" 
  LEFT JOIN monades ON $table.monada = monades.ID
  LEFT JOIN sha2 ON $table.ada = sha2.ada ";
  }


  $query .= $q_joins . "
  WHERE 1
  $q_restriction
  AND $table.status='active' AND " . get_foreas_query($foreas, $table);

  foreach ($args as $k => $v) {
    switch ($k) {
      case 'any':
       
        $query .= "
					AND (
						$table.ada = '%$v%'
						OR $table.thema LIKE '%$v%'
						OR ypografontes.firstname LIKE '%$v%'
						OR ypografontes.lastname LIKE '%$v%'
						OR ypografontes.title_name LIKE '%$v%'
						OR eidi_apofaseon.name LIKE '%$v%'
						OR monades.name LIKE '%$v%'
					)
				";
        add_to_criteria($criteria, "Οποιοδήποτε πεδίο περιέχει", $v);
        break;
      case 'foreas':
        add_to_criteria($criteria, "Φορέας", $v);
        break;
      case 'ada':
        $query .= " AND $table.ada='$v'";
        add_to_criteria($criteria, "Μοναδικός αριθμός", $v);
        break;
      case 'protocol':
        $query .= " AND $table.arithmos_protokolou='$v'";
        add_to_criteria($criteria, "Αρ. Πρωτ.", $v);
        break;
      case 'ada_like':
        $query .= " AND $table.ada LIKE '%$v%'";
        add_to_criteria($criteria, "Ο ΑΔΑ περιέχει", $v);
        break;
      case 'subj':
        $query .= " AND $table.thema LIKE '%$v%'";
        add_to_criteria($criteria, "Το Θέμα περιέχει", $v);
        break;
      case 'thid':
        if (is_array($v)) {
          $query .= " AND ( 0 ";
          foreach ($v as $tmp) {
            $query .= " OR $table.thematiki LIKE '%#$tmp#%' ";
            add_to_criteria($criteria, "Θεματική", get_thema_name($tmp));
          }
          $query .= " )";
        } else {
          $query .= " AND $table.thematiki LIKE '%#$v#%'";
          add_to_criteria($criteria, "Θεματική", get_thema_name($v));
        }
        break;
      case 'unit':
        $query .= " AND $table.monada='$v'";
        add_to_criteria($criteria, "Μονάδα", get_monada_name($v));
        break;
      case 'eia':
        $query .= " AND $table.eidos_apofasis='$v'";
        add_to_criteria($criteria, "Είδος Απόφασης", get_eidos_name($v));
        break;
      case 'ypogid':
        $query .= " AND telikos_ypografwn='$v'";
        add_to_criteria($criteria, "Τελικός Υπογράφων", get_signer_name($v));
        break;
      case 'since':

        $query .= " AND $table.submission_timestamp >= '" . $v . "'";
        add_to_criteria($criteria, "Από", format_date($v));
        break;
      case 'until':
        $query .= " AND $table.submission_timestamp <= DATE_ADD('" . $v . "', INTERVAL 1 DAY)";
        add_to_criteria($criteria, "Έως", format_date($v));
        break;
      case 'from':
        $from = $v;
        break;
      case 'limit':
        $limit = $v;
        break;
    }
  }
  #$query .= " GROUP BY $table.ID ";
  $query .= " ORDER BY apofaseis_time DESC ";
  $query .= " LIMIT $from, $limit ";
 #echo "query=" . $query;
  #die( $query );
  return array('from' => $from, 'limit' => $limit,
      'query' => $query, 'criteria' => $criteria);
  
  
}

function db_to_list($str) {
  $row = explode('#', $str);
  $ret = array();
  foreach ($row as $id) { 
    if ($id == ',') {
        continue;
    }
      
    if ($id != '')
      $ret[] = $id;
  }
  return $ret;
}

function get_spending_types() {
  $q = "SELECT eidi_apofaseon_ID
		  FROM apofaseis_dynamic_fields_list
		  WHERE fieldname = 'poso_dapanis'";
  $res = mysql_query($q);
  $row = mysql_fetch_row($res);
  mysql_free_result($res);
  $row = explode('#', $row[0]);
  $ret = array();
  foreach ($row as $id) {
    if ($id != '')
      $ret[] = $id;
  }
  return $ret;
}

function get_spending_fields() {
  $q = "SELECT ID, fieldname, label 
		  FROM apofaseis_dynamic_fields_list
		  WHERE fieldname IN ( 'eponimia_anadoxou', 'perigrafi_antikeimenou', 'poso_dapanis' )
		  ORDER BY ID";
  $res = mysql_query($q);
  $ret = array();
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $ret[$row['fieldname']] = $row;
  }
  mysql_free_result($res);
  return $ret;
}

function get_spending_query($do_sort = true) {
  global $config;
  $foreas = $config['foreas'];
  $spending_fields = get_spending_fields();
  #$types = get_spending_types();
  #$types_db = array_to_db( $types );
  $q = "SELECT A.ada, A.lastlevel, A.apofasi_date, A.submission_timestamp ";
  $tableid = 'B';
  foreach ($spending_fields as $field_name => $field) {
    $field_name_number = $field_name . "_number";
    $q .= " , $tableid.field_value AS $field_name ";
    $q .= " , $tableid.field_value_number AS $field_name_number ";
    $tableid = chr(ord($tableid) + 1);
  }
  $q .= " FROM apofaseis A ";
  $tableid = 'B';
  foreach ($spending_fields as $field_name => $field) {
    $q .= " LEFT JOIN apofaseis_dynamic_fields_values $tableid 
				ON $tableid.ada = A.ada ";
    $tableid = chr(ord($tableid) + 1);
  }
  #$q .= " WHERE A.eidos_apofasis IN $types_db ";
  $q .= " WHERE A.eidos_apofasis = 27";
  $tableid = 'B';
  foreach ($spending_fields as $field_name => $field) {
    $field_id = $field['ID'];
    $q .= " AND $tableid.dynamic_field_ID = '$field_id' ";
    $tableid = chr(ord($tableid) + 1);
  }
  $q .= " AND " . get_foreas_query($foreas, 'A');
  if ($do_sort) {
    $q .= " ORDER BY A.lastlevel, A.submission_timestamp DESC ";
  }
  return array('query' => $q, 'fields' => $spending_fields);
}

function get_foreas_apc_var($str) {
  global $config;
  return $str . '_' . $config['foreas']['eid'];
}

function normalized_cost($cost) {
  return number_format($cost, 2, ',', '.');
}

function utf8chr($i) {
  return iconv('UCS-4LE', 'UTF-8', pack('V', $i));
}

function clean_xml($matches) {
  // This part handles the callback.
  if (is_array($matches)) {
    if (isset($matches[1]) && $matches[1] !== '') {
      // Compatibility characters.
      // Return as-is for now, but could map it to another character.
      return $matches[1];
    } elseif (isset($matches[2]) && $matches[2] !== '') {
      // Valid UTF-8 for XML
      return $matches[2];
    } elseif (isset($matches[3]) && $matches[3] !== '') {
      // Invalid single-byte characters.
      // Instead of removing these, we can assume they are another character set and map them.
      // Assume they are ISO8859-1 for now, but this could be parameterized.
      return iconv('ISO-8859-1', 'UTF-8', $matches[3]);
    } elseif (isset($matches[4]) && $matches[4] !== '') {
      // Control characters - no mappings - so return a replacement character.
      // You may wish to return something different, or nothing at all.
      return '?';
    }
  }

  // This part handles the first instance.
  if (is_string($matches)) {
    return preg_replace_callback('/'
            // Ranges recommended to avoid - "compatibility characters".
            // See http://www.w3.org/TR/REC-xml/ for the character ranges.
            . '([\x7F-\x84]|[\x86-\x9F]|[\xFD][\xD0-\xEF]|[\x1F\x2F\x3F\x4F\x5F\x6F\x7F\x8F\x9F\xAF\xBF\xCF\xDF\xEF\xFF\x10][\xFF][\xFE\xFF])'

            // Broad valid UTF-8 multi-byte ranges.
            . '|([\x09\x0A\x0D]|[\x20-\x7F]|[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF]{2}|[\xF0-\xF7][\x80-\xBF]{3})'

            // Invalid single-byte characters which are likely to be extended ASCII and may be convertable to UTF-8 equivalents.
            . '|([\x80-\xBF]|[\xC0-\xFF])'

            // Fall-through - whatever is left, which should be single-byte control characters.
            . '|(.)'

            // If this is used as a static method, then replace __FUNCTION__ with __CLASS__ . '::' . __METHOD__
            . '/', __FUNCTION__, $matches
    );
  }
}

/* NOTE: We assume that most recent decisions are returned first. This lets as
  handle corrected decision without adding them to the query */

function get_xml_spending($spending) {
  global $config;
  global $SITE_MAX_SPENDING;
  $header = '<?xml version="1.0" encoding="utf-8"?>';
  $xml = new SimpleXMLElement(get_xml_header() . "<diaugeia></diaugeia>");
  $q = $spending['query'];
  #die( $q );
  $fields = $spending['fields'];
  $res = mysql_query($q);
  if (!all_orgs()) {
    $xml->addChild('institution', hh($config['foreas']['name']));
  }
  $node_spending = $xml->addChild('spending');
  $lastOrgId = '';
  $orthes = array();
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $orthi = $row['is_orthi_epanalipsi'];
    $orthi = str_replace('ΑΔΑ:', '', $orthi);
    $orthi = trim($orthi);
    $orthes[$orthi] = true;
    if (array_key_exists($row['ada'], $orthes))
      continue;
    if ($row['eponimia_anadoxou'] == '' &&
            $row['perigrafi_antikeimenou'] == '' &&
            $row['poso_dapanis'] == '') {
      continue;
    }
    $latin_name = '';
    $foreas = get_foreas_name($row['lastlevel'], $latin_name);
    $orgId = $row['lastlevel'];
    if ($orgId != $lastOrgId) {
      $node_foreas = $node_spending->addChild('institution');
      $lastOrgId = $orgId;
      $node_foreas->addChild('name', hh($foreas));
      $node_foreas->addChild('orgId', hh($orgId));
      if ($latin_name !== false) {
        $foreas_url = $config['base_url'] . '/' . $latin_name . '/spending';
        $node_foreas->addChild('url', hh($foreas_url));
      }
      $items = $node_foreas->addChild('items');
      $count = 0;
      $show_more = true;
    } else if ($count == $SITE_MAX_SPENDING && all_orgs()) {
      if ($show_more) {
        $item = $items->addChild('item');
        $item->addChild('moreurl', hh($foreas_url));
        $show_more = false;
      }
      continue;
    }
    $item = $items->addChild('item');
    $url = $config['site_url'] . '/ada/' . $row['ada'];
    $item->addChild('ada_url', hh($url));
    $anadoxos = clean_xml($row['eponimia_anadoxou']);
    $ch = utf8chr(30);
    $anadoxos = str_replace($ch, "", $anadoxos);
    $item->addChild('anad', hh($anadoxos));
    $description = clean_xml($row['perigrafi_antikeimenou']);
    $item->addChild('desc', hh($description));
    $item->addChild('c_value', hh($row['poso_dapanis_number']));
    #$item->addChild( 'cost', normalized_cost( $row[ 'poso_dapanis_number' ] ) );
    $item->addChild('c_orig', hh($row['poso_dapanis']));
    $item->addChild('date', hh(format_date($row['apofasi_date'])));
    #$item->addChild( 'timestamp', hh( format_date( $row[ 'submission_timestamp' ] ) ) );
    $count++;
  }
  mysql_free_result($res);
  return $xml;
}

function get_stats_for_all($day = false) {
  global $config;
  $foreas = $config['foreas'];
  $orgs = get_all_orgs();
  $restriction = "";

  if ($day !== false) {
    $day = mysql_escape_string($day);
    $restriction = " AND DATE(submission_timestamp) = '$day' ";
  }

  $q = "SELECT A.lastlevel, count(A.id) as total, 
	  	MAX(A.submission_timestamp) as latest 
	  	FROM apofaseis A WHERE " .
          get_foreas_query($foreas, 'A') . $restriction .
          " GROUP BY A.lastlevel";


  $res = mysql_query($q);
  $ret = array();
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    if (($row['lastlevel'] == 0) || ($row['lastlevel'] == 90116785)) {
        continue;
    }
    $pb_id = $row['lastlevel'];
    $latin_name = '';
    $foreas = get_foreas_name($row['lastlevel'], $latin_name);
    if (!array_key_exists($foreas, $ret)) {
      $ret[$foreas] = array('count' => 0, 'sub_count' => 0,
          'latin' => false, 'latest' => $row['latest']);
    }
    $ret[$foreas]['count'] += $row['total'];
    $ret[$foreas]['latin'] = $latin_name;
    $ret[$foreas]['orgId'] = $row['lastlevel'];
  }
  mysql_free_result($res);
  ksort($ret, SORT_STRING);
  return $ret;
}

function get_stats_for_subs($pb_id, $day = false) {
  global $config;
  $orgs = get_all_orgs();
  $foreas = $config['foreas'];
  $pb_id = mysql_escape_string($pb_id);
  $pb_id_req = $pb_id;
  $excl = get_excluded_ids();
  if ($excl !== false)
    $restriction = " AND A.foreas_pb_id NOT IN $excl ";
  else
    $restriction = '';
  $q = "SELECT A.foreas_pb_id, A.foreas_latin_name, 
		  B.name as name,
		  COUNT(D.id) as total, MAX(D.submission_timestamp) as latest
		  FROM oda_members_master A
		  LEFT JOIN 
		  ( 
			SELECT pb_id, name FROM foreis WHERE pb_id IN 
			( SELECT DISTINCT( foreas_pb_id ) FROM oda_members_master )
		  )
		  B ON A.foreas_pb_id = B.pb_id
		  LEFT JOIN apofaseis D ON 
			( A.foreas_pb_id = D.lastlevel AND D.status = 'active' )
		  WHERE A.status = '1' 
		  $restriction
		  AND ( A.foreas_pb_id = '$pb_id' OR A.ypourgeio_to_check = '$pb_id' )
		  GROUP BY A.foreas_pb_id
		 ";
  $res = mysql_query($q);
  $ret = array();
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $pb_id = $row['foreas_pb_id'];
    $foreas = $row['name'];
    $ret[$foreas] = array('count' => 0, 'latin' => false, 'latest' => $row['latest']);
    $ret[$foreas]['count'] += $row['total'] / $orgs[$pb_id]['repeats'];
    $ret[$foreas]['latin'] = $row['foreas_latin_name'];
    $ret[$foreas]['orgId'] = $row['foreas_pb_id'];
    $ret[$foreas]['supervised'] = ( $row['foreas_pb_id'] != $pb_id_req ? 1 : 0 );
  }
  mysql_free_result($res);
  ksort($ret, SORT_STRING);
  return $ret;
}

function get_stats($day) {
  global $config;
  global $SITE_DEVEL;
  $foreas = $config['foreas'];

  if (all_orgs()) {
    return get_stats_for_all($day);
  } else {
    return get_stats_for_subs($foreas['pb_id'], $day);
  }
}

function hh($str) {
  return htmlspecialchars(str_replace('\"', '"', $str));
}

function get_xml_stats($stats, $day = false) {
  global $config;
  $header = get_xml_header();
  $xml = new SimpleXMLElement("$header<diaugeia></diaugeia>");
  $total_supervised = false;
  if (!all_orgs()) {
    $xml->addChild('institution', hh($config['foreas']['name']));
  }
  $node_stats = $xml->addChild('stats');
  if ($day !== false) {
    $node_stats->addChild('day', $day);
    $node_stats->addChild('day_text', " - " . hh(format_date($day)));
  }
  foreach ($stats as $foreas_name => $data) {
    $count = $data['count'];
    $sub_count = $data['sub_count'];
    $latin_name = $data['latin'];
    $latest = $data['latest'];
    $inst = $node_stats->addChild('institution');
    if (!all_orgs()) {
      $inst->addChild('supervised', $data['supervised']);
      if ($total_supervised === false)
        $total_supervised = 0;
      else
        $total_supervised++;
    }
    $inst->addChild('orgId', $data['orgId']);
    $inst->addChild('name', hh($foreas_name));
    $inst->addChild('count', hh($count));
    $inst->addChild('sub_count', hh($sub_count));
    $inst->addChild('latest', hh(format_date($latest)));
    if ($latin_name !== false) {
      $url = $config['base_url'] . '/' . $latin_name;
      $inst->addChild('url', hh($url));
      if ($sub_count > 0) {
        $sub_url = $url . "/stats";
        $inst->addChild('sub_orgs_stats_url', hh($sub_url));
      }
    }
  }
  if ($total_supervised !== false && $total_supervised == 0) {
    $xml->addChild('show_table', 0);
  } else {
    $xml->addChild('show_table', 1);
  }
  return $xml;
}

function get_html_stats_all($stats, $day = false) {

  global $config;
  $html = '';
  $total_supervised = false;
  /*
    if ( !all_orgs() ) {
    //$xml->addChild( 'institution', hh($config[ 'foreas' ][ 'name' ]) );
    }
   */
  //$node_stats = $xml->addChild( 'stats' );
  if ($day !== false) {
    //	$node_stats->addChild( 'day', $day );
    //	$node_stats->addChild( 'day_text', " - " . hh( format_date( $day ) ) );
  }
  foreach ($stats as $foreas_name => $data) {
    $html.='        <tr>
		';
    $count = $data['count'];
    $sub_count = $data['sub_count'];
    $latin_name = $data['latin'];
    $latest = $data['latest'];
    //$inst = $node_stats->addChild( 'institution' );
    /*
      if ( !all_orgs() ) {
      //$inst->addChild( 'supervised', $data[ 'supervised' ] );
      if ( $total_supervised === false ) $total_supervised = 0;
      else $total_supervised++;
      }
     */
    //$inst->addChild( 'orgId', $data[ 'orgId' ] );
    //$inst->addChild( 'name', hh( $foreas_name ) );
    //$inst->addChild( 'count', hh( $count ) );
    //$inst->addChild( 'sub_count', hh( $sub_count ) );
    //$inst->addChild( 'latest', hh( format_date( $latest ) ) );
    if ($latin_name !== false) {
      $url = $config['base_url'] . '/' . $latin_name;
      //$inst->addChild( 'url', hh($url ) );
      if ($sub_count > 0) {
        $sub_url = $url . "/stats";
        //$inst->addChild( 'sub_orgs_stats_url', hh( $sub_url ) );
      }
    }

    $html.='
		<td><a href="' . $url . '" target="_blank">' . hh($foreas_name) . '</a></td>
          <td>' . hh(format_date($latest)) . '</td>
          <td class="center"><a title="Γραφήματα αναρτήσεων" href="' . $url . '/chart">' . hh($count) . '</a>
		</td>
		';

    $html.='        </tr>
		';
  }
  /*
    if ( $total_supervised !== false && $total_supervised == 0 ) {
    //$xml->addChild( 'show_table', 0 );
    }
    else {
    //$xml->addChild( 'show_table', 1 );
    }

   */

  return $html;
}

function print_rss_results($args) {
  global $config;
  // override limit
  $args['limit'] = get_rss_limit();
  $ret = get_search_query($args);
  
    $res = mysql_query($ret['query']);
  
    $criteria = $ret['criteria'];
    $rows = array();
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      $rows[] = $row;
    }
    mysql_free_result($res);
    $xml = get_rss_envelope($rows, $criteria);
    $xml = get_rss_items($xml, $rows);
    header("Content-type: text/xml");
    echo $xml->asXML();
  
  exit();
}

function print_xml_results($args) {
  global $config;

  $ret = get_search_query($args);
  
  $res = mysql_query($ret['query']);
 
    $total = get_total_found_rows();
    $header = '<?xml version="1.0" encoding="utf-8"?>';
    $xml = new SimpleXMLElement("$header<diaugeia></diaugeia>");
    $decisions = $xml->addChild('decisions');
    $fetched = 0;
    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      $fetched++;
      $decision = $decisions->addChild('decision');
      if (all_orgs()) {
        $decision->addChild('institution', hh(get_foreas_name($row['lastlevel'])));
      } else {
        $decision->addChild('institution', hh($row['foreas_name']));
      }
      $decision->addChild('ada', $row['ada']);
      $decision->addChild('protocol_number', hh($row['arithmos_protokolou']));
      $decision->addChild('date', hh($row['apofasi_date']));
      $decision->addChild('submission_date', hh($row['submission_timestamp']));
      $decision->addChild('subject', hh($row['thema']));
      $decision->addChild('type', hh($row['eidos_apofasis']));
      $categories = $decision->addChild('categories');

      // Explode thematikes
      $arr = explode(',', $row['thematiki']);
      foreach ($arr as $th) {
        $th = str_replace('#', '', $th);
        if ($th == '')
          continue;
        $categories->addChild('category', hh(get_thematiki($th)));
      }

      $decision->addChild('url', hh($row['url']));
      $decision->addChild('pdf_url', hh($row['pdf_url']));
      $signer = $decision->addChild('signed_by');
      $signer->addChild('title', hh($row['signer_title']));
      $signer->addChild('last_name', hh($row['signer_lastname']));
      $signer->addChild('first_name', hh($row['signer_firstname']));
      $signer->addChild('active', hh($row['signer_active']));
    }
    $info = $xml->addChild('info');
    $info->addChild('fetched_decisions', $fetched);
    $info->addChild('total_decisions', $total);
    mysql_free_result($res);
    header('Content-Type: text/xml');
    echo $xml->asXML();
  
  exit();
}

function get_criteria_string($criteria) {
  $str = '';
  foreach ($criteria as $crit) {
    if ($str != '')
      $str .= ' - ';
    $str .= hh($crit['label']) . ': ';
    $str .= hh($crit['value']);
    return $str;
  }
}

function print_criteria($args, $criteria) {
  global $config;

  if (count($criteria) == 0)
    return;
  echo '<div class="search_criteria">';
  echo '<h1>Κριτήρια Αναζήτησης:</h1>';
  echo '<ul>';
  foreach ($criteria as $crit) {
    echo '<li>';
    echo '<b>', $crit['label'], ': </b>';
    echo '<i>', htmlspecialchars($crit['value']), '</i>';
    echo '</li>';
  }
  echo '</ul>';

  echo '</div>';
}

function print_search_results($args) {
  global $config;
  global $INDEXER;

  $ret = get_search_query($args);

  
    
    $from = $ret['from'];
    $limit = $ret['limit'];
    $query = $ret['query'];
    $criteria = $ret['criteria'];
    $res = mysql_query($query);
  
  if (isset($_REQUEST['rescount'])) {
    $total = $_REQUEST['rescount'];
  
  } else {
    $total = get_total_found_rows();
  
  }

  if (array_key_exists('ada', $args)) {
    //$row = mysql_fetch_assoc( $res );
    if ($INDEXER) {
      include 'lib/print_decision_indexer.php';
    } else {
      include 'lib/print_decision.php';
    }
  } else {
    $shown = 0;
    print_criteria($args, $criteria);

    while (( $row = mysql_fetch_assoc($res) ) !== false) {
      echo get_decision_div($row);
      $shown++;
    }
    mysql_free_result($res);
    echo "<b>Σύνολο: </b>$shown / $total";
    if ($total > 0 && $limit > 0) {
      $page_current = (int) ( $from / $limit ) + 1;
      $page_total = (int) ($total / $limit );
      if ($total % $limit > 0)
        $page_total++;
      echo "<span style=\"float:right;\"><b>Σελίδα: </b>$page_current / $page_total</span>";
    }
    $pagination = array('from' => $from, 'limit' => $limit, 'total' => $total);
    $pagination['find_args'] = $args;
    echo get_pagination_optimized($pagination, $limit, $total);
  }
}

function get_rest_args() {
  $multivalues = array('thid');
  $ret = array();
  $arr = explode('/', $_REQUEST['args']);
  $max = count($arr);
  foreach ($arr as $item) {
    $index = strpos($item, ':');
    if ($index === false) {
      $item = strtolower($item);
      $ret[$item] = true;
    } else {
      $key = strtolower(substr($item, 0, $index));
      $value = substr($item, $index + 1);
      if (in_array($key, $multivalues)) {
        $arr = explode(',', $value);
        if (count($arr) > 1) {
          $ret[$key] = $arr;
          continue;
        }
      }
      $ret[$key] = $value;
    }
  }
  return $ret;
}

function get_search_args() {
  $args = array();
  $field_map = array(
      'include_foreas' => array('f' => 'field_foreas',
          's' => 'foreas'),
      'include_ada' => array('f' => 'field_ada',
          's' => 'ada'),
      'include_protocol' => array('f' => 'field_protocol',
          's' => 'protocol'),
      'include_dsdf' => array('f1' => 'field_apofasi_date_start',
          's1' => 'since',
          'f2' => 'field_apofasi_date_finish',
          's2' => 'until'),
      'include_th' => array('f' => 'field_thema',
          's' => 'subj'),
      'include_thid' => array('f' => 'field_thematiki_enotita',
          's' => 'thid'),
      'include_eia' => array('f' => 'field_eidos_apofasis',
          's' => 'eia'),
      'include_unit' => array('f' => 'field_monada',
          's' => 'unit'),
      'include_ypogid' => array('f' => 'field_telikos_ypografwn',
          's' => 'ypogid'),
      'include_any' => array('f' => 'field_any',
          's' => 'any')
  );
  foreach ($field_map as $check => $data) {
    if ($check === 'include_dsdf') {
      if (array_key_exists($check, $_REQUEST)) {
        $field1 = $data['f1'];
        $arg_type1 = $data['s1'];
        $field2 = $data['f2'];
        $arg_type2 = $data['s2'];
        if (!array_key_exists($field1, $_REQUEST) ||
                $_REQUEST[$field1] == '') {
          continue;
        }
        if (!array_key_exists($field2, $_REQUEST) ||
                $_REQUEST[$field2] == '') {
          continue;
        }
        $value1 = convertGreekDateToMYSQLDate($_REQUEST[$field1]);
        $args[$arg_type1] = mysql_real_escape_string($value1);
        $value2 = convertGreekDateToMYSQLDate($_REQUEST[$field2]);
        $args[$arg_type2] = mysql_real_escape_string($value2);
      }
    }
    if (array_key_exists($check, $_REQUEST)) {
      $field = $data['f'];
      $arg_type = $data['s'];
      if (!array_key_exists($field, $_REQUEST) ||
              $_REQUEST[$field] == '') {
        continue;
      }
      $value = $_REQUEST[$field];
      if (strpos($field, 'date') != false) {
        $value = convertGreekDateToMYSQLDate($value);
      }
      $args[$arg_type] = mysql_escape_string($value);
    }
  }
  return $args;
}

function get_ministries() {
  $ministries = array(
      'ypes',
      'minfin',
      'mfa',
      'ypetha', 'ypean',
      'ypothin', 'ypeka', 'minedu', 'yme', 'ypakp',
      'yyka', 'ypaat', 'ministryofjustice', 'yptp', 'yppot');
  $q = "SELECT foreas_pb_id, foreas_latin_name
		  FROM oda_members_master
		  WHERE foreas_latin_name IN " . array_to_db($ministries);
  $res = mysql_query($q);
}

function get_top_level_orgs() {
  $ret = array();
  $excl = get_excluded_ids();
  if ($excl !== false)
    $restriction = " AND A.foreas_pb_id NOT IN $excl ";
  else
    $restriction = '';
  $q = "SELECT A.foreas_pb_id, A.ypourgeio_to_check 
		  FROM oda_members_master A
		  WHERE A.status='1' 
		  $restriction
		  AND A.foreas_pb_id = A.ypourgeio_to_check";
  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $ret[] = $row['foreas_pb_id'];
  }
  mysql_free_result($res);
  return $ret;
}

function get_all_orgs() {
  static $ret;
  if (!isset($ret))
    $ret = array();
  if (count($ret) != 0)
    return $ret;
  $excl = get_excluded_ids();
  if ($excl !== false)
    $restriction = " AND A.foreas_pb_id NOT IN $excl ";
  else
    $restriction = '';

  $q = "SELECT A.foreas_pb_id, A.ypourgeio_to_check, 
		  COUNT( A.foreas_pb_id ) as repeats
		  FROM oda_members_master A
		  WHERE A.status='1'
		  $restriction
		  GROUP BY A.foreas_pb_id";
  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $pb_id = $row['foreas_pb_id'];
    $ret[$pb_id] = array('pb_id' => $row['foreas_pb_id'],
        'parent_pb_id' => $row['ypourgeio_to_check'],
        'repeats' => (int) ($row['repeats'] ));
  }
  mysql_free_result($res);
  return $ret;
}

function get_ministry_children_decisions_count($pb_id) {
  $orgs = get_all_orgs();
  $excl = get_excluded_ids();
  if ($excl !== false)
    $restriction = " AND A.foreas_pb_id NOT IN $excl ";
  else
    $restriction = '';
  $q = "SELECT A.foreas_pb_id, COUNT(B.id) as total
		  FROM oda_members_master A
		  LEFT JOIN apofaseis B ON 
			( A.foreas_pb_id = B.lastlevel AND B.status = 'active' )
		  WHERE A.status = '1' AND A.ypourgeio_to_check = '$pb_id'
		  AND A.foreas_pb_id != '$pb_id'
		  $restriction
		  GROUP BY A.foreas_pb_id
		 ";
  $res = mysql_query($q);
  $total = 0;
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $pb_id = $row['foreas_pb_id'];
    $total += $row['total'] / $orgs[$pb_id]['repeats'];
  }
  mysql_free_result($res);
  return $total;
}

function has_children($pb_id) {
  if ($pb_id <= 0)
    return false;
  $q = "SELECT A.foreas_pb_id FROM oda_members_master A
		  WHERE A.ypourgeio_to_check='$pb_id'
		  AND A.status=1";
  $res = mysql_query($q);
  $row = mysql_fetch_assoc($res);
  mysql_free_result($res);
  return $row !== false;
}

function get_ministry_children($pb_id) {
  $ret = array('rows' => array());
  $orgs = get_all_orgs();
  $pb_id = mysql_escape_string($pb_id);
  $excl = get_excluded_ids();
  if ($excl !== false)
    $restriction = " AND A.foreas_pb_id NOT IN $excl ";
  else
    $restriction = '';
  $q = "SELECT A.foreas_pb_id, A.foreas_latin_name, A.diefthinsi, A.arithmos, A.TK,
		  B.name as mt_name, C.name as xy_name, 
		  COUNT(D.id) as total
		  FROM oda_members_master A
		  LEFT JOIN foreis_mt B ON A.foreas_pb_id = B.pb_id
		  LEFT JOIN yp_xwris_ypourgeio C ON A.foreas_pb_id = C.pb_id
		  LEFT JOIN apofaseis D ON 
			( A.foreas_pb_id = D.lastlevel AND D.status = 'active' )
		  WHERE A.status = '1' AND A.ypourgeio_to_check = '$pb_id'
		  $restriction
		  GROUP BY A.foreas_pb_id
		 ";
  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    if (is_null($row['mt_name']) && is_null($row['xy_name'])) {
      continue;
    }
    $name = is_null($row['mt_name']) ? $row ['xy_name'] : $row['mt_name'];
    if ($row['latin_name'] == '')
      $row['latin_name'] = $row['foreas_pb_id'];
    $address = format_address($row['diefthinsi'], $row['arithmos'], $row['TK']);
    $ret['rows'][] = array(
        'id' => $row['foreas_pb_id'],
        'label' => $name,
        'total' => $row['total'] / $orgs[$row['foreas_pb_id']]['repeats'],
        'latin_name' => $row['foreas_latin_name'],
        'address' => $address
    );
  }
  mysql_free_result($res);
  usort($ret['rows'], 'sort_by_label_desc');
  return $ret;
}

/*
 * OTS - get_ranged_foreis OTS Version
 */

function get_ranged_foreis_ots($id_from, $id_to, $table_name) {
  $ret = array('rows' => array());
  $orgs = get_all_orgs();
  $pb_id = mysql_real_escape_string($pb_id);
  $excl = get_excluded_ids();
  if ($excl !== false)
    $restriction = " AND A.foreas_pb_id NOT IN $excl ";
  else
    $restriction = '';
  if ($table_name === 'apofaseis_ana_dimo')
    $pb = 'dimos_id';
  else
    $pb = 'perifereia_id';
  $q = "select foreas_pb_id, foreas_latin_name, diefthinsi, arithmos, TK,
            (SELECT name FROM foreis WHERE pb_id = foreas_pb_id) as name,
            (select arithmos_apofaseon
                    from $table_name 
                    where $pb = foreas_pb_id) as total
            from oda_members_master
            where status = '1'
            AND foreas_pb_id >= $id_from AND foreas_pb_id <= $id_to
            $restriction
            GROUP BY foreas_pb_id";
  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $name = $row['name'];
    if ($row['latin_name'] == '')
      $row['latin_name'] = $row['foreas_pb_id'];
    $address = format_address($row['diefthinsi'], $row['arithmos'], $row['TK']);
    $ret['rows'][] = array(
        'id' => $row['foreas_pb_id'],
        'label' => $name,
        'total' => $row['total'] / $orgs[$row['foreas_pb_id']]['repeats'],
        'latin_name' => $row['foreas_latin_name'],
        'address' => $address
    );
  }
  mysql_free_result($res);
  return $ret;
}

function get_ranged_foreis($id_from, $id_to) {
  $ret = array('rows' => array());
  $orgs = get_all_orgs();
  $pb_id = mysql_escape_string($pb_id);
  $excl = get_excluded_ids();
  if ($excl !== false)
    $restriction = " AND A.foreas_pb_id NOT IN $excl ";
  else
    $restriction = '';
  $q = "SELECT A.foreas_pb_id, A.foreas_latin_name, A.diefthinsi, A.arithmos, A.TK,
		  B.name as name
		  FROM oda_members_master A
		  LEFT JOIN foreis B
		  ON A.foreas_pb_id = B.pb_id
		  WHERE A.status = '1' 
		  AND A.foreas_pb_id >= $id_from AND A.foreas_pb_id <= $id_to
		  $restriction
		  GROUP BY A.foreas_pb_id
		  ORDER BY B.name
		 ";
  $res = mysql_query($q);
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $name = $row['name'];
    if ($row['latin_name'] == '')
      $row['latin_name'] = $row['foreas_pb_id'];
    $address = format_address($row['diefthinsi'], $row['arithmos'], $row['TK']);
    $ret['rows'][] = array(
        'id' => $row['foreas_pb_id'],
        'label' => $name,
        'total' => $row['total'] / $orgs[$row['foreas_pb_id']]['repeats'],
        'latin_name' => $row['foreas_latin_name'],
        'address' => $address
    );
  }
  mysql_free_result($res);
  return $ret;
}

function get_prefectures() {
  return get_ranged_foreis(6001, 6325);
}

function get_perifereies() {
  return get_ranged_foreis(5001, 5013);
}

function get_top_expenses() {
  global $config;
  $limit = get_top_expenses_limit();
  $fields = get_spending_fields();
  $field_cost_id = $fields['poso_dapanis']['ID'];
  $field_anadoxos_id = $fields['eponimia_anadoxou']['ID'];
  $field_desc_id = $fields['perigrafi_antikeimenou']['ID'];

  $restriction = '';
  $q = "SELECT A.ada, A.field_value_number AS cost,
		  B.lastlevel AS lastlevel,
		  C.field_value AS anadoxos,
		  D.field_value AS description
		  FROM apofaseis_dynamic_fields_values A
		  LEFT JOIN apofaseis B ON A.ada = B.ada
		  LEFT JOIN apofaseis_dynamic_fields_values C ON A.ada = C.ada
		  LEFT JOIN apofaseis_dynamic_fields_values D ON A.ada = D.ada
		  WHERE A.dynamic_field_ID='$field_cost_id'
		  AND C.dynamic_field_ID='$field_anadoxos_id'
		  AND D.dynamic_field_ID='$field_desc_id'
		  AND " . get_foreas_query($config['foreas'], 'B') . "
		  ORDER BY A.field_value_number DESC
		  LIMIT 0, $limit";
  $res = mysql_query($q);
  $ret = array();
  while (( $row = mysql_fetch_assoc($res) ) !== false) {
    $ret[] = $row;
  }
  mysql_free_result($res);

  foreach ($ret as &$row) {
    $latin_name = '';
    $name = get_foreas_name($row['lastlevel'], $latin_name);
    $row['cost'] = normalized_cost($row['cost']);
    $row['org_name'] = $name;
    $row['org_latin_name'] = $latin_name;
  }
  reset($ret);
  return $ret;
}

function get_fek_issue_name($issue_id) {
  $id = mysql_escape_string($issue_id);
  $q = "SELECT name FROM et_fek_tefxos_names WHERE ET_FEK_tefxos_ID='$id'";
  $res = mysql_query($q);
  $row = mysql_fetch_assoc($res);
  return ( $row === false ? $issue_id : $row['name'] );
}

function list_for_eidos_optimized($foreas) {
  $ret = list_eidi_apofaseon($foreas);
  usort($ret['rows'], 'sort_by_label_asc');
  return $ret;
}

function list_eidi_apofaseon($foreas) {
  $ret = array('rows' => array(), 'pagination' => array("has_more" => false));
  $eid = $foreas['eid'];
  if ($eid == 0) {
    $query = "select e.id,e.name label from  eidi_apofaseon e order by label ";
  } else {
    $query = "select distinct e.id id,e.name label from apofaseis a, eidi_apofaseon e where e.id=a.eidos_apofasis and a.lastlevel=" . $eid." order by label";
  }
  $result = mysql_query($query);

  if (!$result) {
    return $ret;
  }
  if (mysql_num_rows($result) == 0) {
    return $ret;
  }
  while (($row = mysql_fetch_assoc($result)) != false) {
    array_push($ret['rows'], $row);
  }

  mysql_free_result($result);
  return $ret;
}

function convertGreekDateToMYSQLDate($dateStr) {
  $dateObj = date_create_from_format('d/m/Y', $dateStr);
  if ($dateObj != false) {
    $convertedDate = date_format($dateObj, 'Y-m-d');
    return $convertedDate;
  } else {
    return $dateStr;
  }
}

?>
