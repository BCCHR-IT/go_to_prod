<?php

/**
 * Created by Alvaro Alvarez.
 * User: alvaro1
 * Date: 3/7/17
 * Time: 5:20 PM
 */
class check_identifiers
{
    /**
     * @param $DataDictionary
     * @return bool - True if there is at least one variable set as Identifier
     */
    public static function AnyIdentifier($DataDictionary){

        // Loop through each field and check if is a Identifier
        foreach ($DataDictionary as $field_name=>$field_attributes){
            if ($field_attributes['identifier'] == "y" ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $DataDictionary
     * @return Array 
     */
    public static function AllIdentifiersFlagged($DataDictionary) {
        $all_identifiers = 0;
        $identifiers_unflagged = 0;
        $unflagged_identifiers = array();

        // Retrieve all identifiers, as set in the control center.
        $query = 'SELECT value FROM redcap_config where field_name = "identifier_keywords"';
        $result = db_query($query);
        while ($row = db_fetch_assoc($result)) {
            $identifiers = $row["value"];
        }
        $identifiers = explode(",", $identifiers);

        foreach($identifiers as $identifier) {
            $identifier = trim($identifier);
            $field_attributes = $DataDictionary[$identifier];
            if ($field_attributes) 
            {
                $all_identifiers++;
                if ($field_attributes["identifier"] != "y") {
                    $identifiers_unflagged++;

                    $link_path1 = APP_PATH_WEBROOT . 'Design/online_designer.php?pid=' . $_GET['pid'] . '&page=' . $field_attributes['form_name'] . '&field=' . $field_name;
                    $link_to_edit1 = '<a href=' . $link_path1 . ' target="_blank" ><img src=' . APP_PATH_IMAGES . 'pencil.png></a>';
                    
                    // Adding : Intrument Name, field name, field label, link to fiel in online designer
                    array_push($unflagged_identifiers,Array($field_attributes['form_name'],$identifier,$field_attributes['field_label'],$link_to_edit1));
                }
            }
        }

        return Array("unflagged_identifiers" => $unflagged_identifiers, "total_unflagged_identifiers" => $identifiers_unflagged, "total_identifiers" => $all_identifiers);
    }
}