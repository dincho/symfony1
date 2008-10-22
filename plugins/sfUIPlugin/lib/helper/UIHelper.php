<?php
/**
 * This function create an object table list.
 *
 * @param  array    $objects       Listed objects as an array.
 * @param  array    $headers       Associative array where the keys are the text and
 *                                      the values are the number of colspan.
 * @param  array    $values        Array with the methods used as values in the cells.
 * 										One entry for each column.
 * @param  array    $links         Array with possible links. One string for each cell. If you don't want a
 * 										link, keep it empty string or null. If you put something between curly
 *  									brackets, it'll be parsed as a object method.
 * @param  array    $actions       Array of actions you want, where the key is the action and
 * 										the value is the link for the action. It has the same rules as $links
 * 										for curly bracktes.
 * @param  array    $sizes         Array with the size of each column. One entry for each column.
 * @param  string   $header_class  CSS class for the header.
 * @param  string   $class1        CSS class for odd rows.
 * @param  string   $class2        CSS class for even rows.
 * @return string   $empty_text    The text it'll appear if the object array is empty
 */
function object_data_grid($objects, $headers, $values, $links = array(), $actions = array(), $sizes = array(), $header_class = null, $class1 = null, $class2 = null, $empty_text = "Empty") {
    $table = "<table class=\"zebra\">\n";    
    
    $table .= "<thead>\n<tr>\n";
    $i = 0;
    $header_class = (empty($header_class)) ? "" : "class='$header_class'";
    foreach ($headers as $header => $colspan) {
        $tamanho = "";
        if (!empty($sizes) && array_key_exists($i, $sizes))
            $size = "width='".$sizes[$i]."'";
        $table .= "<th $size $header_class colspan='$colspan'>\n".$header."</th>\n";
        $i++;
    }
    $table .= "</tr>\n</thead>\n";
    
    $table .= "<tbody>\n";
    $i = 0;
    foreach ($objects as $obj) {
        $class = ($i % 2 == 0) ? $class1 : $class2;
        $row = "<tr>\n";
        $j = 0;
        foreach ($values as $method) {
            $value = trata_link_valor($links[$j], $obj, $method);
            $row .= (empty($class)) ?
                        "<td>\n".$value."</td>\n" :
                        "<td class=$class>\n".$value."</td>\n";
            $j++;
        }
        foreach ($actions as $action => $action_link) {
            $row .= (empty($class)) ?
                        "<td>\n".trata_link_acao($action_link, $obj, $action)."</td>\n" :
                        "<td class=$classe>\n".trata_link_acao($action_link, $obj, $action)."</td>\n";
        }
        $row .= "</tr>\n";
        $i++;
        
        $table .= $row;
    }
    $table .= "</tbody>\n</table>\n";
    
    return (empty($objects)) ? $empty_text : $table;
}

/**
 * Functions that works the links. Don't bother looking!! ;-)
 */
function trata_link_valor($link, $obj, $metodo) {
    if (empty($link))
        return $obj->$metodo();
    else {
        if (strpos($link, "{") === false) {
            return link_to($obj->$metodo(), "$link");
        } else {
            $inicio = strpos($link, "{");
            $fim = strpos($link, "}");
            $param = substr($link, ($inicio+1), ($fim-$inicio-1));
            $link = str_replace("{".$param."}", $obj->$param(), $link);
            return link_to($obj->$metodo(), $link);
        }
    }
}

function trata_link_acao($link, $obj, $texto) {
    $confirmacao = null;
    if (strpos($link, "+") !== false) {
        $mais = strpos($link, "+");
        $confirmacao = substr($link, ($mais+1), (strlen($link)-1-$mais));
        if (strpos($confirmacao, "{") !== false) {
            $inicio = strpos($confirmacao, "{");
            $fim = strpos($confirmacao, "}");
            $param = substr($confirmacao, ($inicio+1), ($fim-$inicio-1));
            $confirmacao = str_replace("{".$param."}", $obj->$param(), $confirmacao);
        }
        $link = substr($link, 0, $mais);
    }
    
    if (strpos($link, "{") === false) {
        return link_to($texto, $link);
    } else {
        $inicio = strpos($link, "{");
        $fim = strpos($link, "}");
        $param = substr($link, ($inicio+1), ($fim-$inicio-1));
        $link = str_replace("{".$param."}", $obj->$param(), $link);
        $opcoes = array("post" => true);
        if (!empty($confirmacao)) $opcoes["confirm"] = $confirmacao;
        return link_to($texto, $link, $opcoes);
    }
}