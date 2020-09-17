<?php

/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/16/17
 * Time: 10:29 PM
 */



require 'utilities.php';
// Call the REDCap Connect file in the main "redcap" directory
require_once findRedcapConnect();

$data_dictionary_array = REDCap::getDataDictionary('array');
//project information
global $Proj;

require_once  'messages.php';

function PrintTr($title_text,$body_text,$span_label,$a_tag){

        if (strpos($span_label, 'Warning') != False) {
            $color = 'yellow';
        }
        else if (strpos($span_label, 'Danger') != False) {
            $color = 'red';
        }
        else {
            $color = 'green';
        }


        return

        '<tr class="gp-tr ' . $color . '">
            <td>   
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    
            </td>
            <td class="gp-info-content">
                <div class="gp-title-content">
                    <strong>
                        '.$title_text. ' <span class="title-text-plus" style="color: #5492a3"><small>(more)</small></span>
                    </strong>
                </div>
                    
                <div class="gp-body-content">
                    <p>
                        ' .$body_text.' 
                    </p>
                </div>
            </td>
            <td>               
                    '.$span_label.' 
            </td>
            <td>               
                   '.$a_tag.'
            </td>
        </tr>';

}
function PrintOtherOrUnknownErrors($DataDictionary, $similarity){
        include_once "check_other_or_unknown.php";

        $res= new check_other_or_unknown();
        $array=$res::CheckOtherOrUnknown($DataDictionary, $similarity);

        if(!empty($array)){

            $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/other_or_unknown_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').'</a>';
            $span='<span class="label label-warning">'.lang('WARNING').'</span>';
            $_SESSION["OtherOrUnknownErrors"]= $array;
           return PrintTr(lang('OTHER_OR_UNKNOWN_TITLE'),lang('OTHER_OR_UNKNOWN_BODY'),$span,$a);
        }else return false;

    }
function PrintBranchingLogicErrors($DataDictionary){
        include_once "check_presence_of_branching_and_calculated_variables.php";
        $res= new check_presence_of_branching_and_calculated_variables();
        $array=$res::CheckIfBranchingLogicVariablesExist($DataDictionary);
        if (!empty($array)){
            $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/presence_of_branching_logic_variables_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
            $span='<span class="label label-danger">'.lang('DANGER').'</span>';
            $_SESSION["BranchingLogicErrors"]= $array;
            return PrintTr(lang('BRANCHING_LOGIC_TITLE'),lang('BRANCHING_LOGIC_BODY'),$span,$a);

        }else return false;
    }
function PrintCalculatedFieldsErrors($DataDictionary){
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfCalculationVariablesExist($DataDictionary);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/presence_of_calculated_variables_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $_SESSION["CalculatedFieldsErrors"]= $array;
        return PrintTr(lang('CALCULATED_FIELDS_TITLE'),lang('CALCULATED_FIELDS_BODY'),$span,$a);

    }else return false;
}

function PrintASILogicErrors(){
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfASILogicVariablesExist();
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/asi_logic_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $_SESSION["ASILogicErrors"]= $array;
        return PrintTr(lang('ASI_LOGIC_TITLE'),lang('ASI_LOGIC_BODY'),$span,$a);

    }else return false;

}

function PrintQueueLogicErrors(){
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfQueueLogicVariablesExist();
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/queue_logic_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        $_SESSION["QueueLogicErrors"]= $array;
        return PrintTr(lang('QUEUE_LOGIC_TITLE'),lang('QUEUE_LOGIC_BODY'),$span,$a);

    }else return false;

}
function PrintDataQualityLogicErrors(){
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfDataQualityLogicVariablesExist();
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/data_quality_logic_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["DataQualityLogicErrors"]= $array;
        return PrintTr(lang('DATA_QUALITY_LOGIC_TITLE'),lang('DATA_QUALITY_LOGIC_BODY'),$span,$a);

    }else return false;

}
function PrintReportsLogicErrors(){
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfReportsLogicVariablesExist();
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/reports_logic_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["ReportsLogicErrors"]= $array;
        return PrintTr(lang('REPORTS_LOGIC_TITLE'),lang('REPORTS_LOGIC_BODY'),$span,$a);

    }else return false;

}




function PrintTodayInCalculationsErrors($DataDictionary){
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $array=$res::CheckIfTodayExistInCalculations($DataDictionary);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/today_calculations_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["TodayExistInCalculations"]= $array;
        return PrintTr(lang('CALCULATED_TODAY_TITLE'),lang('CALCULATED_TODAY_BODY'),$span,$a);

    }else return false;
}


function PrintVariableNamesWithTheSameNameAsAnEventNameErrors(){
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_andcalculated_variables();
    $array=$res::VariableNamesWithTheSameNameAsAnEventName();
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/variables_with_same_name_as_event_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["VariableNamesWithTheSameNameThanAnEventName"]= $array;
        return PrintTr(lang('VAR_NAMES_EVENT_NAMES_TITLE'),lang('VAR_NAMES_EVENT_NAMES_BODY'),$span,$a);

    }else return false;


}
function PrintDatesConsistentErrors($DataDictionary){
    include "check_dates_consistency.php";
    $res= new check_dates_consistency();
    $array=$res::IsDatesConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/dates_consistency_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').'</a>';

        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["DatesConsistentErrors"]= $array;
        return PrintTr(lang('DATE_CONSISTENT_TITLE'),lang('DATE_CONSISTENT_BODY'),$span,$a);

    }else return false;


}
function PrintYesNoConsistentErrors($DataDictionary){
    include_once "check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsAllYesesOneAndNosZero($DataDictionary);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/consistency_yes_no_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["YesNoConsistentErrors"]= $array;
        return PrintTr(lang('YES_NO_TITLE'),lang('YES_NO_BODY'),$span,$a);

    }else return false;


}
function PrintPositiveNegativeConsistentErrors($DataDictionary){
    include_once "check_consistency_for_lists.php";
    $res= new check_consistency_for_lists();
    $array=$res::IsPositiveNegativeConsistent($DataDictionary);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/consistency_positive_negative_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').'</a>';

        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["PositiveNegativeConsistentErrors"]= $array;
        return PrintTr(lang('POSITIVE_NEGATIVE_TITLE'),lang('POSITIVE_NEGATIVE_BODY'),$span,$a);

    }else return false;


}
function PrintIdentifiersErrors($DataDictionary){
    include_once "check_identifiers.php";
    $res= new check_identifiers();
    $identifiers_found=$res::AnyIdentifier($DataDictionary);
    if (!$identifiers_found){
        $a='<a  target="_blank"  role="button" class="btn" href=" '.APP_PATH_WEBROOT . 'index.php?pid='.$_GET['pid'].'&route=IdentifierCheckController:index" >'.lang('EDIT').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        return PrintTr(lang('IDENTIFIERS_TITLE'),lang('IDENTIFIERS_BODY'),$span,$a);

    }else return false;


}
function PrintPIErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::PIExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('PI_TITLE'),lang('PI_BODY'),$span,$a);

    }else return false;


}
function PrintIRBErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $pi_found=$res::IRBExist($proj);
    if (!$pi_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('IRB_TITLE'),lang('IRB_BODY'),$span,$a);

    }else return false;


}
function PrintResearchErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $research_found=$res::IsAResearchProject($proj);
    if (!$research_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-info">'.lang('INFO').'</span>';
        return PrintTr(lang('RESEARCH_PROJECT_TITLE'),lang('RESEARCH_PROJECT_BODY'),$span,$a);

    }else return false;
}
function PrintJustForFunErrors($proj){
    include_once "check_pi_irb_type.php";
    $res= new check_pi_irb_type();
    $jff_found=$res::IsJustForFunProject($proj);
    if ($jff_found){
        $_SESSION["IsJustForFun"]= $jff_found;
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('JUST_FOR_FUN_PROJECT_TITLE'),lang('JUST_FOR_FUN_PROJECT_BODY'),$span,$a);

    }else{

        return false;
    }
}
function PrintTestRecordsErrors(){
    include_once "check_count_test_records_and_exports.php";
    $res= new check_count_test_records_and_exports();
    global $Proj;
    $array=$res::CheckTestRecordsAndExports();
    if (!empty($array) and $Proj->project['status']==0){
        $a= '<u>Exports:</u> '.$array[0].'<br><u>Records:</u> '.$array[1];
        $span='<span class="label label-danger">'.lang('DANGER').'</span>';
        return PrintTr(lang('TEST_RECORDS_TITLE'),lang('TEST_RECORDS_BODY'),$span,$a);

    }else return false;
}
function PrintNumberOfFieldsInForms($DataDictionary,$max_recommended){
    include_once 'check_number_of_fields_by_form.php';
    $res= new check_number_of_fields_by_form();
    $array=$res::getFormsWithToManyFields($DataDictionary,$max_recommended);
    if (!empty($array)){
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/number_of_fields_by_form_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["NumberOfFieldsByForm"]= $array;
        return PrintTr(lang('MAX_NUMBER_OF_RECORDS_TITLE'),lang('MAX_NUMBER_OF_RECORDS_BODY'),$span,$a);

    }else return false;

}
function PrintValidatedFields($DataDictionary,$min_percentage){
    include_once 'check_field_validation.php';
    $res= new check_field_validation();
    $array=$res::getMinimumOfValidatedFields($DataDictionary,$min_percentage);
      
    if (!empty($array["unvalidated_fields"])){
        $a = '<u>'.lang('VALIDATED_FIELDS').'</u> '.$array["validated_fields"].'<br><u>'.lang('TEXT_BOX_FIELDS').'</u> '.$array["total_text_fields"].'<br><u>Percentage of unvalidated fields:</u> '. round(1-($array["validated_fields"]/$array["total_text_fields"]), 2) * 100 . '%'.
            '<br/><a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/unvalidated_text_fields_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["UnvalidatedTextFields"]= $array["unvalidated_fields"];
        return PrintTr(lang('NUMBER_VALIDATED_RECORDS_TITLE'),lang('NUMBER_VALIDATED_RECORDS_BODY'),$span,$a);
    } else {
        $total_fields = sizeof(REDCap::getFieldNames());
        $a = '<u>'. lang('TOTAL_FIELDS') . '</u> '.$total_fields.'<br><u>'.lang('TEXT_BOX_FIELDS').'</u> '.$array["total_text_fields"].'<br><u>Percentage of text fields in project:</u> '. round(($array["total_text_fields"]/$total_fields), 2) * 100 . '%';
        $span='<span class="label label-warning">'.lang('INFO').'</span>';
        return PrintTr(lang('ALL_FIELDS_VALIDATED_TITLE'),lang('NUMBER_VALIDATED_RECORDS_BODY'),$span,$a);
    }
}

function  MyFirstInstrumentError(){
    include_once "check_my_first_instrument_presence.php";
    $res= new check_my_first_instrument_presence();
    $my_first_instrument_found=$res::IsMyFirstInstrument();
    if ($my_first_instrument_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'"  >'.lang('ONLINE_DESIGNER').'</a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        return PrintTr(lang('MY_FIRST_INSTRUMENT_TITLE'),lang('MY_FIRST_INSTRUMENT_BODY'),$span,$a);

    }else return false;
}

function  NotDesignatedFormsErrors(){
    include_once "check_un_designated_longitudinal_forms.php";
    $res= new check_un_designated_longitudinal_forms();
    $not_designated_forms=$res::NotDesignatedForms();
    if (!empty($not_designated_forms)){

        //$a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'Design/designate_forms.php?pid='.$_GET['pid'].'"  >'.lang('VIEW').'</a>';
        $a='<a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/undesignated_forms_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').' </a>';
        $span='<span class="label label-warning">'.lang('WARNING').'</span>';
        $_SESSION["NotDesignatedFormsErrors"]= $not_designated_forms;

        return PrintTr(lang('NOT_DESIGNATED_FORMS_TITLE'),lang('NOT_DESIGNATED_FORMS_BODY'),$span,$a);

    }else return false;
}

function PrintSuccess(){
//TODO: send directly to move to production screen
    $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
    $span='<span class="label label-success">'.lang('SUCCESS').'</span>';
    return PrintTr(lang('READY_TO_GO_TITLE'),lang('READY_TO_GO_BODY'),$span,$a);

}

function PrintValidatedNumberFields($DataDictionary) {
    // Prints the percentage of number fields with min/max set
    include_once "check_field_validation.php";
    $res = new check_field_validation();
    $array = $res::checkNumberValidation($DataDictionary);
    
    $a = '<u>'.lang('VALIDATED_NUMBER_FIELDS').'</u> '.$array[0].'<br><u>'.lang('NUMBER_FIELDS').'</u> '.$array[1].'<br><u>'.lang('UNVALIDATED_NUMBER_FIELDS').'</u> '. round((1-($array[0]/$array[1])), 2) * 100 . '%';
    $span = '<span class="label label-warning">'.lang('INFO').'</span>';

    return PrintTr(lang('VALIDATED_NUMBER_FIELDS_TITLE'), lang('VALIDATED_NUMBER_FIELDS_BODY'), $span, $a);
}

function PrintValidatedDateFields($DataDictionary) {
    // Prints the percentage of number fields with min/max set
    include_once "check_field_validation.php";
    $res = new check_field_validation();
    $array = $res::checkDateValidation($DataDictionary);
    
    $a = '<u>'.lang('VALIDATED_DATE_FIELDS').'</u> '.$array[0].'<br><u>'.lang('DATE_FIELDS').'</u> '.$array[1].'<br><u>'.lang('UNVALIDATED_DATE_FIELDS').'</u> '. round((1-($array[0]/$array[1])), 2) * 100 . '%';
    $span = '<span class="label label-warning">'.lang('INFO').'</span>';

    return PrintTr(lang('VALIDATED_DATE_FIELDS_TITLE'), lang('VALIDATED_DATE_FIELDS_BODY'), $span, $a);
}

function CheckASIEmailFieldExists() {
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $survey_email_field_found = $res::CheckEmailField();
    if (!$survey_email_field_found){
        $a='<a  target="_blank" href=" '.APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'"  >'.lang('PROJECT_SETUP').'</a>';
        $span='<span class="label label-warning">'.lang('DANGER').'</span>';
        return PrintTr(lang('SURVEY_EMAIL_FIELD_TITLE'), lang('SURVEY_EMAIL_FIELD_BODY'), $span, $a);

    } else return false;
}

function CheckASIEmailsTested() {
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $asi_emails_tested = $res::CheckIfASITested();
    if (!empty($asi_emails_tested)) {
        $a= '<u>Emails Sent:</u> ' . $asi_emails_tested[0] . '<br/><u>Number of ASIs to Test:</u> ' . $asi_emails_tested[1];
        $span='<span class="label label-danger">'.lang('WARNING').'</span>';
        return PrintTr(lang('TEST_ASI_TITLE'),lang('TEST_ASI_BODY'),$span,$a);
    } else return false;
}

function CheckInstrumentsDesignatedAsSurveys() {
    include_once "check_presence_of_branching_and_calculated_variables.php";
    $res= new check_presence_of_branching_and_calculated_variables();
    $instruments_designated = $res::CheckIfInstrumentsDesignatedAsSurveys();
    if (!$instruments_designated) {
        $a= '<a  target="_blank" href=" '.APP_PATH_WEBROOT.'Design/online_designer.php?pid='.$_GET['pid'].'"  >'.lang('ONLINE_DESIGNER').'</a>';
        $span='<span class="label label-danger">'.lang('WARNING').'</span>';
        return PrintTr(lang('DESIGNATED_SURVEY_INSTR_TITLE'),lang('DESIGNATED_SURVEY_INSTR_BODY'),$span,$a);
    } else return false;
}

function CheckIdentifiersFlagged($DataDictionary) {
    include_once "check_identifiers.php";
    $res = new check_identifiers();
    $unflagged_identifiers = $res::AllIdentifiersFlagged($DataDictionary);
    if (!empty($unflagged_identifiers["unflagged_identifiers"])) {
        $a = '<u>'.lang('TOTAL_UNFLAGGED_IDENTFIERS').'</u> '.$unflagged_identifiers["total_unflagged_identifiers"].'<br><u>'.lang('TOTAL_IDENTFIERS').'</u> '.$unflagged_identifiers["total_identifiers"].'<br><u>Percentage of unflagged identifiers:</u> '. round($unflagged_identifiers["total_unflagged_identifiers"]/$unflagged_identifiers["total_identifiers"], 2) * 100 . '%'.
            '<br/><a href="#ResultsModal" role="button" class="btn" data-toggle="modal" data-load-remote="views/unflagged_identifiers_view.php" data-isloaded="false" data-remote-target="#ResultsModal .modal-body">'.lang('VIEW').'</a>';
        $span='<span class="label label-warning">'.lang('DANGER').'</span>';
        $_SESSION["UnflaggedIdentifiers"]= $unflagged_identifiers["unflagged_identifiers"];
        return PrintTr(lang('UNFLAGGED_IDENTIFIERS_TITLE'),lang('UNFLAGGED_IDENTIFIERS_BODY'),$span,$a);
    } else return false;
}

$just_for_fun=PrintJustForFunErrors($Proj);
$res_records= PrintTestRecordsErrors();
$res_other_or_unknown= PrintOtherOrUnknownErrors($data_dictionary_array, 95 );
$res_branching_logic= PrintBranchingLogicErrors($data_dictionary_array);
$res_calculated_fields= PrintCalculatedFieldsErrors($data_dictionary_array);
$res_today_in_calculations= PrintTodayInCalculationsErrors($data_dictionary_array);
$res_asi_logic=PrintASILogicErrors();
$res_queue_logic=PrintQueueLogicErrors();
$res_data_quality_logic=PrintDataQualityLogicErrors();
$res_reports_logic=PrintReportsLogicErrors();
$res_dates_consistent= PrintDatesConsistentErrors($data_dictionary_array);
$res_yes_no_consistent= PrintYesNoConsistentErrors($data_dictionary_array);
$res_positive_negative_consistent= PrintPositiveNegativeConsistentErrors($data_dictionary_array);
$res_identifiers= PrintIdentifiersErrors($data_dictionary_array);
$res_number_of_fields_by_form=PrintNumberOfFieldsInForms($data_dictionary_array,200);
$res_validated_fields=PrintValidatedFields($data_dictionary_array, 1.0);
$res_my_first_instrument_found=MyFirstInstrumentError(); 
$res_not_designated_forms=NotDesignatedFormsErrors();
$res_validated_num_fields = PrintValidatedNumberFields($data_dictionary_array);
$res_validated_date_fields = PrintValidatedDateFields($data_dictionary_array);
$res_asi_email_field_exists = CheckASIEmailFieldExists();
$res_asi_emails_tested = CheckASIEmailsTested();
$res_surveys_designated_instryments = CheckInstrumentsDesignatedAsSurveys();
$res_check_identifiers = CheckIdentifiersFlagged($data_dictionary_array);

// Danger
echo $res_check_identifiers;
echo $res_records;
echo $res_branching_logic;
echo $res_calculated_fields;
echo $res_today_in_calculations;
echo $res_queue_logic;
echo $res_data_quality_logic;
echo $res_reports_logic;
echo $res_asi_logic;
// Warning
echo $res_asi_email_field_exists;
echo $res_asi_emails_tested;
echo $res_surveys_designated_instryments;
echo $res_other_or_unknown;
echo $res_dates_consistent;
echo $res_yes_no_consistent;
echo $res_positive_negative_consistent;
echo $res_identifiers;
echo $res_number_of_fields_by_form;
echo $res_my_first_instrument_found;
echo $res_not_designated_forms;
echo $res_validated_fields;
// Info
echo $res_validated_num_fields;
echo $res_validated_date_fields;

/*to capture the metrics*/
require_once 'metrics.php';