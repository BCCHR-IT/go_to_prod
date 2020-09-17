<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 3:18 PM
 */
class check_field_validation
{

    public static function getMinimumOfValidatedFields($DataDictionary){
        $count_validated_fields=0;
        $count_fields=0; // count fields that can be validated
        $unvalidated_fields = array();

        // Loop through each field and do something with each
        foreach ($DataDictionary as $field_name=>$field_attributes){
            // Do something with this field if it is a checkbox field
            if ($field_attributes['field_type'] == "text"){
                $count_fields++;
                if (strlen(trim($field_attributes['text_validation_type_or_show_slider_number'])) >0 or strlen(trim($field_attributes['select_choices_or_calculations']))  > 0  ) {
                    $count_validated_fields++;
                }
                else
                {
                    $link_path1 = APP_PATH_WEBROOT . 'Design/online_designer.php?pid=' . $_GET['pid'] . '&page=' . $field_attributes['form_name'] . '&field=' . $field_name;
                    $link_to_edit1 = '<a href=' . $link_path1 . ' target="_blank" ><img src=' . APP_PATH_IMAGES . 'pencil.png></a>';
                    
                    // Adding : Intrument Name, field name, field label, link to fiel in online designer
                    array_push($unvalidated_fields,Array($field_attributes['form_name'],$field_name,$field_attributes['field_label'],$link_to_edit1));
                }
            }
        }

        return Array("unvalidated_fields" => $unvalidated_fields, "validated_fields" => $count_validated_fields, "total_text_fields" => $count_fields);
    }

    public static function checkNumberValidation($DataDictionary) {
        $count_validated_fields = 0;
        $count_fields = 0;

        foreach($DataDictionary as $field_name => $field_attributes) {
            if ($field_attributes['field_type'] == "text" && ($field_attributes['text_validation_type_or_show_slider_number'] == 'integer' || $field_attributes['text_validation_type_or_show_slider_number'] == 'number')){
                $count_fields++;
                if (empty($field_attributes['text_validation_min']) || empty($field_attributes['text_validation_max'])) {
                    $count_validated_fields++;
                }
            }
        }

        return array($count_validated_fields, $count_fields);
    }

    public static function checkDateValidation($DataDictionary) {
        $count_validated_fields = 0;
        $count_fields = 0;

        foreach($DataDictionary as $field_name => $field_attributes) {
            if ($field_attributes['field_type'] == "text" && in_array($field_attributes['text_validation_type_or_show_slider_number'], array('date_dmy', 'date_mdy', 'date_my', 'date_ymd', 'date_ym', 'datetime_dmy', 'datetime_mdy', 'datetime_ymd', 'datetime_seconds_dmy', 'datetime_seconds_mdy', 'datetime_seconds_ymd'))) {
                $count_fields++;
                if (empty($field_attributes['text_validation_min']) || empty($field_attributes['text_validation_max'])) {
                    $count_validated_fields++;
                }
            }
        }

        return array($count_validated_fields, $count_fields);
    }
}