<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/9/17
 * Time: 11:38 AM
 */

include_once 'utilities.php';

class check_presence_of_branching_and_calculated_variables
{


    /**
     * @param $DataDictionary
     * @return array
     *
     * Extract the Fields with branching logic
     */
    public static function getBranchingLogicFields($DataDictionary){
        $var= array();
        // Loop through each field and do something with each
        foreach ($DataDictionary as $field_name=>$field_attributes){
            // Do something with this field if it is a checkbox field
            if (strlen(trim($field_attributes['branching_logic']))>0 ) {
                $FormName = $field_attributes['form_name'];
                $FieldName = $field_attributes['field_name'];
                $BranchingLogic = $field_attributes['branching_logic'];
                array_push( $var, Array($FormName,$FieldName,$BranchingLogic));
            }
        }
        return $var;
    }


    /**
     * @param $DataDictionary
     * @return array
     *
     * Extract the Calculated fields
     */
    public static function getCalculatedFields($DataDictionary){
        $var= array();
        // Loop through each field and do something with each
        foreach ($DataDictionary as $field_name=>$field_attributes){
            // Do something with this field if it is a checkbox field
            if (strlen(trim($field_attributes['select_choices_or_calculations']))>0  and $field_attributes['field_type'] == 'calc' ) {
                $FormName = $field_attributes['form_name'];
                $FieldName = $field_attributes['field_name'];
                $Calculation = $field_attributes['select_choices_or_calculations'];
                array_push( $var, Array($FormName,$FieldName,$Calculation));
            }
        }
        return $var;
    }


    //today calculation for Calc fields
    public static function getTodayCalculations($CalcFieldsArray){

        //$haystack = "foo bar baz";
        $today_var   = strtolower("\"today\"");
        $today_var2   = strtolower('\'today\'');
        $var=Array();
        foreach ($CalcFieldsArray as $item){
            if(( strpos( strtolower($item[2]), $today_var ) !== false )  or (strpos( strtolower($item[2]), $today_var2 ) !== false )){
                array_push( $var, $item);
            }
        }
        return $var;
    }


    public static function ExtractASILogic(){

        $var=Array();
        $sql = "SELECT 
	              SRV.form_name as form, RSS.event_id as event_id,  RSS.condition_logic as logic 
                FROM 
	              redcap_surveys as SRV, redcap_surveys_scheduler as RSS 
                WHERE
	               RSS.condition_logic IS NOT NULL and RSS.active=1 and SRV.survey_id=RSS.survey_id and SRV.project_id=".$_GET['pid'];
        $result = db_query( $sql );
        while ( $query_res = db_fetch_assoc( $result ) )
        {
            array_push($var, Array($query_res[form],$query_res[event_id],$query_res[logic]));
        }
        return $var;
    }

    public static function ExtractQueueLogic() { 
        // Return the complete Survey Queue prescription for this project
        $Proj = new Project();
        
        $project_queue = array();
        
		$sql = "select distinct q.* from redcap_surveys_queue q, redcap_surveys s, redcap_metadata m, redcap_events_metadata e,
				redcap_events_arms a where s.survey_id = q.survey_id and s.project_id = ". $_GET['pid'] ." and m.project_id = s.project_id
                and s.form_name = m.form_name and q.event_id = e.event_id and e.arm_id = a.arm_id and s.survey_enabled = 1  and q.active = 1";
                
        $q = db_query($sql);
        
		if (db_num_rows($q) > 0) {
			while ($row = db_fetch_assoc($q)) {
				$survey_id = $row['survey_id'];
				$event_id = $row['event_id'];
                $form = $Proj->surveys[$survey_id]['form_name'];
                
                if (!in_array($form, $Proj->eventsForms[$event_id])) 
                    continue;

				array_push($project_queue, Array($form, $event_id, $row["condition_logic"]));
			}
        }
        
		return $project_queue;
    }

    public static function ExtractDataQualityLogic(){

        $var=Array();
        $sql = "SELECT  rule_name as name, real_time_execute as rtime, rule_logic as logic FROM redcap_data_quality_rules as DQR where DQR.rule_logic IS NOT NULL and DQR.project_id=".$_GET['pid'];
        $result = db_query( $sql );
        while ( $query_res = db_fetch_assoc( $result ) )
        {

            $val = $query_res[rtime] == 1 ? lang("YES") : lang("NO");

            array_push($var, Array($query_res[name],$val,$query_res[logic]));
        }
        return $var;
    }

    public static function ExtractReportsLogic(){

        $var=Array();
        $sql = "SELECT  title as title, report_id as reportid, advanced_logic as logic  FROM redcap_reports where advanced_logic IS NOT NULL and project_id=".$_GET['pid'];
        $result = db_query( $sql );
        while ( $query_res = db_fetch_assoc( $result ) )
        {
            array_push($var, Array($query_res[title],$query_res[reportid],$query_res[logic]));
        }
        return $var;
    }

    /**
     * @param $array
     * @return array
     */
    public static function ExtractVariables($array){

        $branching_logic_array=array();
        $re = '/\[(.*?)\]/';
        $longitudinal=REDCap::isLongitudinal();
        $events = REDCap::getEventNames(true, true);
        foreach ($array as $item){
            preg_match_all($re, trim($item[2]), $matches);
            //array_push($branching_logic_array,$matches[1]);
            //$branching_logic_array=array_merge($branching_logic_array,$matches[1]);
            foreach ($matches[1] as $item2){
                if ($longitudinal){
                        //do not remove if the Event name is also used as a Variable name.
                    if (!in_array($item2,self::VariableNamesWithTheSameNameAsAnEventName())){
                        //if the variable name name is in the list of events then is removed from the list of problems
                        if(!in_array($item2,$events)){
                            array_push( $branching_logic_array, Array($item[0],$item[1],$item2 ));
                        }
                    }
                 //if the project is not longitudinal just add all the variables
                }else{
                    array_push( $branching_logic_array, Array($item[0],$item[1],$item2 ));
                }
            }
        }
        return array_map("unserialize", array_unique(array_map("serialize", $branching_logic_array)));
    }




    public static function VariableNamesWithTheSameNameAsAnEventName(){
        // Check if project is longitudinal
        $var = Array();
        if (REDCap::isLongitudinal()){
            $fields = REDCap::getFieldNames();
            $events = REDCap::getEventNames(true, true);
             $var= array_intersect($events,$fields);
        }
        return $var;
    }

    //transform a checkbox option from triple underscore  ___ to parenthesis () presentation
    public static function TransformCheckBoxField($field___format){

         // check if is a negative code for example var(-2)
        if(strpos( trim($field___format),  "____" ) !== false){
            $number = substr(trim($field___format), strpos($field___format, "____") + 4);
            //echo $number;
            $underscore="____".$number;
            $parenthesis="(-".$number.")";

        }else {
            $number = substr(trim($field___format), strpos($field___format, "___") + 3);
            //echo $number;
            $underscore = "___" . $number;
            $parenthesis = "(" . $number . ")";
        }


        $parenthesis_format = str_replace($underscore,$parenthesis, $field___format);


        return $parenthesis_format;
    }



    //adding extra Checkbox variables to the list of variables of the project
    public static function AddCheckBoxes($fields){

        $var =Array();

        foreach ($fields as $field_name){
            if (REDCap::getFieldType($field_name) == 'checkbox') {


                $checkbox_variable_array= REDCap::getExportFieldNames($field_name);
                    foreach ($checkbox_variable_array[$field_name] as $checkbox___format){
                        $checkbox_field= self::TransformCheckBoxField($checkbox___format);
                        array_push( $var, $checkbox_field);

                    }
            } else {
                        array_push( $var, $field_name);
              }
        }
        return $var;
    }


    /**
     * @param $DataDictionary
     * @return array
     */
    public static function CheckIfBranchingLogicVariablesExist($DataDictionary){
        global $Proj;

        $var= array();
        $branching_fields=self::getBranchingLogicFields($DataDictionary);
        $BranchingLogicArray=self::ExtractVariables($branching_fields);
        $fields = REDCap::getFieldNames();

         $fields= self::AddCheckBoxes($fields);//adding the extra Checkbox variables
        foreach ($BranchingLogicArray as $variable){
             if(!in_array(strtolower($variable[2]),$fields)){
                 $label=TextBreak($variable[1]);

                 $link_path=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'&page='.$variable[0].'&field='.$variable[1].'&branching=1';
                 $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'arrow_branch_side.png></a>';

                 array_push( $var, Array(REDCap::getInstrumentNames($variable[0]),$variable[1],$label,'<strong style="color: red">['.$variable[2].']</strong>',$link_to_edit));
             }
        }


        return $var;
     }


    /**
     * @param $DataDictionary
     * @return array
     */
    public static function CheckIfCalculationVariablesExist($DataDictionary){
        global $Proj;

        $var= array();
        $calculated_fields=self::getCalculatedFields($DataDictionary);
        $calculated_fields_array=self::ExtractVariables($calculated_fields);
        $fields = REDCap::getFieldNames();
        $fields= self::AddCheckBoxes($fields);//adding the extra Checkbox variables
        foreach ($calculated_fields_array as $variable){
            if(!in_array(strtolower($variable[2]),$fields)){
                $label=TextBreak($variable[1]);
                $link_path=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'&page='.$variable[0].'&field='.$variable[1];
                $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';
                array_push( $var, Array(REDCap::getInstrumentNames($variable[0]),$variable[1],$label,'<strong style="color: red">['.$variable[2].']</strong>',$link_to_edit));
            }
        }
        return $var;
    }

    public static function CheckIfTodayExistInCalculations($DataDictionary){

        $var=array();
        $today_fields=self::getCalculatedFields($DataDictionary);
        $today_list=self::getTodayCalculations($today_fields);
        foreach ($today_list as $today){
            $label=TextBreak($today[1]);
            $link_path=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'&page='.$today[0].'&field='.$today[1];
            $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';
            array_push($var,Array(REDCap::getInstrumentNames($today[0]),$today[1],$label,$today[2],$link_to_edit ));
        }
        return $var;
    }

    public static function CheckIfASILogicVariablesExist(){
        global $Proj;
        $var= array();
        $logic_fields=self::ExtractASILogic();
        $logic_fields_array=self::ExtractVariables($logic_fields);
        $fields = REDCap::getFieldNames();
        $fields= self::AddCheckBoxes($fields);//adding the extra Checkbox variables
        foreach ($logic_fields_array as $variable){
            if(!in_array(strtolower($variable[2]),$fields)){
                $event= REDCap::getEventNames(false,true, $variable[1]);
                if (!$event) {$event='-';}
                $link_path=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'];
                $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';
                array_push( $var, Array(REDCap::getInstrumentNames($variable[0]),$event,'<strong style="color: red">['.$variable[2].']</strong>',$link_to_edit));
            }
        }
        return $var;
    }

    public static function CheckIfQueueLogicVariablesExist(){
        global $Proj;
        $var= array();
        $logic_fields=self::ExtractQueueLogic();
        $logic_fields_array=self::ExtractVariables($logic_fields);
        $fields = REDCap::getFieldNames();
        $fields= self::AddCheckBoxes($fields);//adding the extra Checkbox variables
        foreach ($logic_fields_array as $variable){
            if(!in_array(strtolower($variable[2]),$fields)){
                $event= REDCap::getEventNames(false,true, $variable[1]);
                if (!$event) {$event='-';}
                $link_path=APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'];
                $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';
                array_push( $var, Array(REDCap::getInstrumentNames($variable[0]),$event,'<strong style="color: red">['.$variable[2].']</strong>',$link_to_edit));
            }
        }
        return $var;
    }

    public static function CheckIfDataQualityLogicVariablesExist(){
        global $Proj;
        $var= array();
        $logic_fields=self::ExtractDataQualityLogic();
        $logic_fields_array=self::ExtractVariables($logic_fields);
        $fields = REDCap::getFieldNames();
        $fields= self::AddCheckBoxes($fields);//adding the extra Checkbox variables
        foreach ($logic_fields_array as $variable){
            if(!in_array(strtolower($variable[2]),$fields)){
                $link_path=APP_PATH_WEBROOT.'DataQuality/index.php?pid='.$_GET['pid'];
                $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';
                array_push( $var, Array($variable[0],$variable[1],'<strong style="color: red">['.$variable[2].']</strong>',$link_to_edit));
            }
        }
        return $var;
    }

    public static function CheckIfReportsLogicVariablesExist(){
        global $Proj;
        $var= array();
        $logic_fields=self::ExtractReportsLogic();
        $logic_fields_array=self::ExtractVariables($logic_fields);
        $fields = REDCap::getFieldNames();
        $fields= self::AddCheckBoxes($fields);//adding the extra Checkbox variables
        foreach ($logic_fields_array as $variable){
            if(!in_array(strtolower($variable[2]),$fields)){
                $link_path=APP_PATH_WEBROOT.'DataExport/index.php?pid='.$_GET['pid'].'&report_id='.$variable[1].'&addedit=1';
                $link_to_edit='<a href='.$link_path.' target="_blank" ><img src='.APP_PATH_IMAGES.'pencil.png></a>';
                array_push( $var, Array($variable[0],$variable[1],'<strong style="color: red">['.$variable[2].']</strong>',$link_to_edit));
            }
        }
        return $var;
    }

    public static function IsASIEnabled() {
        $asi_enabled = 0;
        $query = 'SELECT count(*) as count FROM redcap_surveys_scheduler scheduler left join redcap_surveys surveys on  surveys.survey_id = scheduler.survey_id where project_id = ' . $_GET['pid'];
        $result = db_query($query);
        while ($row = db_fetch_assoc($result)) {
            $asi_enabled = $row["count"];
        }
        return $asi_enabled;
    }

    public static function CheckEmailField() 
    {
        if (!empty(self::IsASIEnabled())) {
            $survey_email_field_set = false;
            $query = "select survey_email_participant_field from redcap_projects where project_id = " . $_GET["pid"];
            $result = db_query($query);
            while ($row = db_fetch_assoc($result)) {
                if (!empty($row["survey_email_participant_field"])) {
                    $survey_email_field_set = true;
                }
            }
            return $survey_email_field_set;
        }
        else return true;
    }

    public static function CheckIfASITested() 
    {
        $array = array();
        $asi_count = self::IsASIEnabled();
        if (!empty($asi_count)) {
            $query = "SELECT count(distinct surveys_emails.survey_id) as count FROM redcap_surveys_emails surveys_emails left join redcap_surveys surveys on surveys.survey_id = surveys_emails.survey_id where surveys.project_id = " . $_GET["pid"];
            $result = db_query($query);
            while ($row = db_fetch_assoc($result)) {
                if ($row["count"] < $asi_count) {
                    $array = Array($row["count"], $asi_count);
                }
            }
        }
        return $array;
    }

    public static function CheckIfInstrumentsDesignatedAsSurveys()
    {
        $query = "SELECT surveys_enabled from redcap_projects where project_id = " . $_GET["pid"];
        $result = db_query($query);
        $row = db_fetch_assoc($result);
        if ($row["surveys_enabled"] == 1)
        {
            $query = "SELECT count(*) as count FROM redcap_projects projects inner join redcap_surveys as surveys on surveys.project_id = projects.project_id where projects.surveys_enabled = 1 and projects.project_id = " . $_GET["pid"];
            $result = db_query($query);
            while ($row = db_fetch_assoc($result)) {
                if ($row["count"] == 0) {
                    return false;
                }
            }
        }
        return true;
    }
}