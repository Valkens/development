<?php
function substring($str, $len, $more = '...')
{
    if ($str=='' || $str==NULL) return $str;
    if (is_array($str)) return $str;
    $str = trim($str);
    if (strlen($str) <= $len) return $str;
    $str = substr($str,0,$len);
    if ($str != '') {
        if (!substr_count($str," ")) {
            if ($more) $str .= $more;
            return $str;
        }
        while(strlen($str) && ($str[strlen($str)-1] != " ")) $str = substr($str,0,-1);
        if ($more) $str .= $more;
    }
    return $str;
}