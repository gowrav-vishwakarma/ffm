<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Created on Jun 8, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

function checkExisting($Field1, $Table, $Name, $id = 0, $Field2= '') {
    $CI = & get_instance();
    $CI->db->where($Field1, $Name);
    if ($id != 0)
        $CI->db->where($Field2 . ' != ', $id);
    $result = $CI->db->get($Table);
    if ($result->num_rows() > 0)
        return true;
    else
        return false;
}

function getNow($format="Y-m-d H:i:s") {
    date_default_timezone_set('Asia/Calcutta');
    $timeStamp = strtotime('now');
    $timeStamp = date($format, $timeStamp);
//		return $timeStamp;
//		echo date_default_timezone_get();
    $CI = & get_instance();
    if ($currDate = $CI->session->userdata('currdate'))
        return $currDate;
    else
        return $timeStamp;
}

function inp($var) {
    $CI = & get_instance();
    return $CI->input->post($var);
}

function my_date_diff($d1, $d2) {
    $d1 = (is_string($d1) ? strtotime($d1) : $d1);
    $d2 = (is_string($d2) ? strtotime($d2) : $d2);

    $diff_secs = abs($d1 - $d2);
    $base_year = min(date("Y", $d1), date("Y", $d2));

    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
    return array(
        "years" => date("Y", $diff) - $base_year,
        "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
        "months" => date("n", $diff) - 1,
        "days_total" => floor($diff_secs / (3600 * 24)),
        "days" => date("j", $diff) - 1,
        "hours_total" => floor($diff_secs / 3600),
        "hours" => date("G", $diff),
        "minutes_total" => floor($diff_secs / 60),
        "minutes" => (int) date("i", $diff),
        "seconds_total" => $diff_secs,
        "seconds" => (int) date("s", $diff)
    );
}

function formatDrCr($DR, $CR) {
    $html = '<table width="100%" border="1">
                  <tr class="ui-widget-header">
                    <th colspan="2"><div align="center">Debit Acocunts</div></th>
                    <th colspan="2"><div align="center">Credit Accounts</div></th>
                  </tr>
                  <tr>
                    <th>Account</th>
                    <th>Amount</th>
                    <th>Account</th>
                    <th>Amount</th>
                  </tr>';
    $DRKeys = array_keys($DR);
    $DRVals = array_values($DR);

    $CRKeys = array_keys($CR);
    $CRVals = array_values($CR);
    for ($i = 0; $i < max(count($DR), count($CR)); $i++) {

        $html .='<tr class="ui-widget-contents">
                    <td>' . ((isset($DRKeys[$i])) ? $DRKeys[$i] : "&nbsp;") . '</td>
                    <td>' . ((isset($DRKeys[$i])) ? $DRVals[$i] : "&nbsp;") . '</td>
                    <td>' . ((isset($CRKeys[$i])) ? $CRKeys[$i] : "&nbsp;") . '</td>
                    <td>' . ((isset($CRKeys[$i])) ? $CRVals[$i] : "&nbsp;") . '</td>
                  </tr>';
    }
    $html .='</table>';
    return $html;
}

function printTable($records, $title) {
    $ci = & get_instance();
    $ci->load->library("table");
    $ci->table->set_heading($title);

    foreach ($records as $r) {
        $ci->table->add_row(array_values($r));
    }

    return $ci->table->generate($data);
}

function makeoperator($val, $whatis='') {
    $val = trim($val);
    while (strpos($val, "  ")) {
        $val = str_replace("  ", " ", $val);
    }
    switch (substr($val, 0, 2)) {
        case "= ":
            $val = "= '" . trim(substr($val, strpos($val, " "))) . "'";
            break;
        case "> ":
            $val = "> '" . trim(substr($val, strpos($val, " "))) . "'";
            break;
        case "< ":
            $val = "< '" . trim(substr($val, strpos($val, " "))) . "'";
            break;
        case ">=":
            $val = ">= '" . trim(substr($val, strpos($val, " "))) . "'";
            break;
        case "<=":
            $val = "<= '" . trim(substr($val, strpos($val, " "))) . "'";
            break;
        case "<>":
            $val = "<> '" . trim(substr($val, strpos($val, " "))) . "'";
            break;
        case "li":
            $val = "like '%" . trim(substr($val, strpos($val, " "))) . "%'";
            break;
        case "no":
            $val = "not like '%" . trim(substr($val, strpos($val, " ", 5))) . "%'";
            break;
        case "be":
            $val1 = trim(substr($val, strpos($val, " "), strpos($val, " and") - strpos($val, " ")));
            $val2 = trim(substr($val, strpos($val, "and ") + 4));
            $val = "between '" . $val1 . "' AND '" . $val2 . "' ";
            break;
    }
    if ($whatis == 'select') {
        $val = " like '" . $val . "'";
    }
    return " " . $val;
}

define('INDIVIDUAL', 'P');
define('COMPANY', 'C');
define('TRUST', 'T');
define('PARTNERSHIP_FIRM', 'F');
define('BODY_OF_INDIVIDUAL', 'B');
define('ASSOCIATION_OF_PERSONS', 'A');
define('HUF', 'H');
define('LOCAL_AUTHORITY', 'L');
define('GOVT', 'G');
define('JUDICIAL_ARTIFICIAL_PERSON', 'J');
define('DIGIT', 5);

function verifyPAN($pno, $name) {
    if (strlen($pno) != 10)
        return false;
    $pno = strtoupper($pno);
    $name = strtoupper($name);

    $words = @split(" ", $name);
    $lastnameIndividual = end($words);
    $firstname = $words[0];

    $panFourthLetter = substr($pno, 3, 1);
    switch ($panFourthLetter) {
        case 'P':
            $fourthLetter = INDIVIDUAL;
            $fifthLetter = substr($lastnameIndividual, 0, 1);
            break;
        case 'C':
            $fourthLetter = COMPANY;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'T':
            $fourthLetter = TRUST;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'F':
            $fourthLetter = PARTNERSHIP_FIRM;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'B':
            $fourthLetter = BODY_OF_INDIVIDUAL;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'A':
            $fourthLetter = ASSOCIATION_OF_PERSONS;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'H':
            $fourthLetter = HUF;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'L':
            $fourthLetter = LOCAL_AUTHORITY;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'G':
            $fourthLetter = GOVT;
            $fifthLetter = substr($firstname, 0, 1);
            break;
        case 'J':
            $fourthLetter = JUDICIAL_ARTIFICIAL_PERSON;
            $fifthLetter = substr($firstname, 0, 1);
            break;
    }


    $regex = "/([a-zA-Z]){3}(" . $fourthLetter . "){1}(" . $fifthLetter . "){1}([0-9]){4}([a-zA-Z]){1}/";

    if (preg_match($regex, $pno))
        return true;
    else
        return false;
}

?>