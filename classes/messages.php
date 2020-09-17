<?php
/**
 * LANGUAGE FILE
 *  here you can change the text content of the plugin
 *
 */
//Validation Labels


/**
 * @param $phrase
 * @return mixed
 */

//TODO: the names of the columns in the view files and the close button are hard coded.. create lang variables them.
function lang($phrase){
        static $lang = array(
            'OTHER_OR_UNKNOWN_TITLE' => '"99" or "98" coding recommended for "other" and/or "unknown" values in drop-down lists, radio-buttons or check-boxes.',
            'OTHER_OR_UNKNOWN_BODY' =>'<div class="overflow">It is common to include an "other" or "unknown" option at the end of a dropdown list. It is encouraged to use different coding for these answers (in general other=99 and unknown=98). There are two reasons for this: <p>1. You can easily add additional choices without needing to recode your values; and 2. when you are using statistical software it is apparent which values correspond to special codes. For example, the following is NOT recommended: </p><small><ul class="list-group" style=" padding-left: 50px; width: 215px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">4, Other </li></ul></small><p>Say you have collected data for 100 records and you now want to add Dr. Rose to the list. A common mistake is the following: </p><small><ul class="list-group" style=" padding-left: 50px; width: 215px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">4, Dr. Rose <br><strong>(DON\'T DO IT THIS WAY)</strong></li><li class="list-group-item">5, Other</li></ul></small><p>If, before the change, you had 20 records as \'other\' with a value of 4, they would all instantly be transferred to Dr. Rose. This usually isn\'t what is intended. A better design is something like: </p><small><ul class="list-group" style=" padding-left: 50px; padding-top: 0px; width: 215px; "><li class="list-group-item">1, Dr. Jones</li><li class="list-group-item">2, Dr. Parker </li><li class="list-group-item">3, Dr. Smith</li><li class="list-group-item">99, Other</li></ul></small><p>Now you can add additional members to the list during the project without needing to recode. And, when you analyze your data the other value is easily identified.</p></div>',
            'YES_NO_TITLE'=>'Inconsistencies in coding for yes/no questions.',
            'YES_NO_BODY' => 'When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.  In REDCap, the standard for \'Yes\' is 1 and \'No\' is 0.  If you select the Yes/No question type this is how it will be coded.
                        You should avoid using values other than 0 or 1 for No and Yes. Order doesn\'t matter. If you want the Yes option to come first, you can make your radio button fields as: <ul class="list-group" style=" padding-left: 50px; width: 150px; "><li class="list-group-item">1, Yes</li><li class="list-group-item">0, No</li><li class="list-group-item">99, Other</li></ul>Please see this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Adding+Fields">page</a> for more help.',

            'POSITIVE_NEGATIVE_TITLE' =>'Inconsistencies in coding for positive/negative questions.',
            'POSITIVE_NEGATIVE_BODY' =>'When data is analyzed in statistical software you often only see the \'coded\' values.  So, it is important to be consistent across your project so the codes don\'t arbitrarily change from question to question.',

            'IDENTIFIERS_TITLE' =>'No fields tagged as identifiers.',
            'IDENTIFIERS_BODY' =>'<div class="alert alert-danger" role="alert">All fields with protected health information (PHI) should be marked as identifiers. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Protecting+Email+Addresses+and+Other+Identifiers">page</a> for help.</div>',
                
            'DATE_CONSISTENT_TITLE' => 'Date format inconsistencies.',
            'DATE_CONSISTENT_BODY' => 'Your project uses different date formats (i.e, mix of mdy and ymd). <strong> You should validate consistently across all dates.</strong> When data is analyzed in statistical software you often only see the unformatted values.  So, it is important to be consistent across your project so the date formats don\'t arbitrarily change from question to question. For example, May 1, 2012 could be formatted as MDY (05-01-2012) or DMY (01-05-2012). Naively, this could be interpreted as both May 1, 2012 AND January 5, 2012. See this <a href="https://hub.bcchr.ca/display/redcap/Field+Validation">page</a> for more help with field validation.',

            'BRANCHING_LOGIC_TITLE' => 'Branching logic inconsistencies.',
            'BRANCHING_LOGIC_BODY' => 'Some fields listed in your branching logic do not exist in this project and thus cannot be used. These fields must be removed from the branching logic before you can continue. If you\'re using checkboxes/radios you may be querying an option that does not exist. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Branching+Logic#BranchingLogic-WritingSyntax">page</a> for help.',

            'CALCULATED_FIELDS_TITLE' => 'Inconsistencies in calculated fields.',
            'CALCULATED_FIELDS_BODY' => 'Some <strong>fields names or event names</strong> listed in your calculated fields do not exist in this project and thus cannot be used. These fields must be removed from your calculations before you can continue. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Calculated+Fields">page</a> for help.',

            'VAR_NAMES_EVENT_NAMES_TITLE' => 'Variable names with the same name as an event name.',
            'VAR_NAMES_EVENT_NAMES_BODY' => 'Some of your field names are the same as an event name, this can create confusion. if this is non intentional please change the name of the variables.',

            'TEST_RECORDS_TITLE' => 'This project has not been sufficiently tested.',
            'TEST_RECORDS_BODY' => 'We recommend the creation of at least <strong>three</strong> test records and at least <strong>one</strong> export in development mode. This allows you to preview the type of results expected from your project. It is also highly recommended that you review your project\'s design with a statistician prior to entering production mode to ensure your data capture is configured properly.',

            'READY_TO_GO_TITLE' => ' You are all set!. ',
            'READY_TO_GO_BODY' => 'Looks like you are ready to move this project to production mode!.',

            'MY_FIRST_INSTRUMENT_TITLE' => '"My First Instrument" form name found. ',
            'MY_FIRST_INSTRUMENT_BODY' => 'You will see one default form already present in your "Online Designer," entitled “My First Instrument.” You may rename this form by clicking the “Rename” button to the right of the form name.',

            'NUMBER_VALIDATED_RECORDS_TITLE' => 'You have unvalidated text fields.',
            'NUMBER_VALIDATED_RECORDS_BODY' => 'Field validation helps to ensure the integrity of your collected data. Every form designer is strongly encouraged to take advantage of this REDCap functionality in order to discover errors during the data entry process and resolve these errors before they are saved to the database. Field validation only applies when the Field Type is a Text Box (Short Text). Examples of fields that SHOULD have validation are <b>email</b> and <b>phone number</b>. Please see this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Field+Validation">page</a> for help.',

            'MAX_NUMBER_OF_RECORDS_TITLE' => 'Forms with more fields than recommended.',
            'MAX_NUMBER_OF_RECORDS_BODY' => 'It is recommended that each form has a maximum of<strong> 200 fields</strong> to optimize its performance; however, it is okay to have more fields if necessary. ',

            'NOT_DESIGNATED_FORMS_TITLE' => 'Forms not assigned to any event.',
            'NOT_DESIGNATED_FORMS_BODY' => ' One or more instruments are not assigned to any event. No data will be collected on these instruments if they are not assigned to events in the <strong>Designate Instruments for My Events</strong> page. Please see this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Longitudinal+Set-up">page</a> for help.',

            'CALCULATED_TODAY_TITLE' => 'Calculations using "Today".',
            'CALCULATED_TODAY_BODY' => 'It is strongly recommended, that you do not use "today" in calc fields. This is because every time you access and save the form, the calculation will run. So if you calculate the age as of today, then a year later you access the form to review or make updates, the elapsed time as of "today" will also be updated (+1 yr). Most users calculate time off of another field (e.g. screening date, enrollment date). See this <a href="https://hub.bcchr.ca/display/redcap/Date+Difference">page</a> for more help.',

            'ASI_LOGIC_TITLE' => 'Problems found in ASI logic.',
            'ASI_LOGIC_BODY' => 'Some fields listed in your Automated Surveys Invitation (ASI) logic do not exist in this project and thus cannot be used. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/ASI+through+email#ASIthroughemail-Settingupautomatedinvitations">page</a> for help.',
            
            'QUEUE_LOGIC_TITLE' => 'Problems found in the Survey Queue logic.',
            'QUEUE_LOGIC_BODY' => 'Some fields listed in your Survey Queue logic do not exist in this project and thus cannot be used. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Survey+Queue">page</a> for help.',

            'DATA_QUALITY_LOGIC_TITLE' => 'Problems found in the Data Quality Module logic.',
            'DATA_QUALITY_LOGIC_BODY' => 'Some fields listed in your Data Quality Module logic do not exist in this project and thus cannot be used. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Data+Quality+Module">page</a> for help.',

            'REPORTS_LOGIC_TITLE' => 'Problems found in some of your Reports Advanced Filter Logic.',
            'REPORTS_LOGIC_BODY' => 'Some fields listed in your Reports Advanced Filter Logic do not exist in this project and thus cannot be used. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Creating+Reports">page</a> for help.',

            'WARNING' => 'Warning',
            'DANGER' => 'Danger',
            'INFO' => 'Info',
            'SUCCESS' => 'Success',
            'VIEW' => 'View',
            'EDIT' => 'Edit',
            'PROJECT_SETUP' => 'Project Setup',
            'PROJECT_GO_PROD' => 'Project Setup',
            'USER_RIGHTS' => 'Sorry, only users who CAN edit this project are allowed to run this plugin.',
            'LOADING' => 'Loading...',
            'WIKI' => 'Wiki Page',
            'VALIDATION' => 'Issues that you may need to fix',
            'RESULT' => 'Type',
            'OPTIONS' => 'Options',
            'RUN' => 'Run Review',
            'YES' => 'Yes',
            'NO' => 'No',
            'CLOSE' => 'Close',
            'NOTICE' => 'Notice',
            'INFO_WHAT_NETX' => 'What happens Next?',
            'INFO_WHAT_NETX_BODY' => 'Your project will be reviewed by the Data Management Team before being moved to Production. For more information, click <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Moving+to+Production"><u>HERE</u></a>.',
            'INFO_WHAT_NETX_BODY_2' => 'If, when you Move to Production, you check \'Delete ALL Data\', any data entered before being approved for Production will be deleted. If you have real survey data, please contact us at <a href="mailto:redcap@bcchr.ca">redcap@bcchr.ca</a>.',
            'INFO_CITATION' => 'Citation Information',
            'INFO_CITATION_BODY' => 'REDCap at BC Children’s Hospital is supported by BCCH Research IT. All research resulting from the use of REDCap must cite the grants that make this service available - details, including boilerplate language, are located
                <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Citing+REDCap"><u>HERE</u></a>.',
            'INFO_STATISTICIAN_REVIEW' => 'Statistician Review',
            'INFO_STATISTICIAN_REVIEW_BODY' => 'It is also highly recommended that you review your project\'s design with a statistician prior to entering production mode to ensure your data capture is configured properly.',

            'I_AGREE_BODY' => 'Fix the issues in the table, and run the plugin again. Once you\'re ready, click the button below to signify that you have acknowledged or fixed all the pertinent issues, and the project is ready to move to production:',
            'I_AGREE' => 'I am ready',
            'I_AGREE_MODAL' => 'You will be redirected to the Project Setup page, where you must click Move to Production to notify the BCCHR REDCap team that you\'re ready to proceed. Please see this <a target="_blank" style="color:blue" href="https://hub.bcchr.ca/display/redcap/Moving+to+Production" target="_blank">page</a> for more information.',
            
            'TOTAL_FIELDS' => 'Total Fields in Project:',
            'VALIDATED_FIELDS' => 'Validated Fields:',
            'TEXT_BOX_FIELDS' => 'Text Box Fields:',
            'LOADING_EXTRA_TIME' => '<strong>Wow, what a large database!</strong><br> - It will take some extra time while all the Data Dictionary is analyzed. Please be patient :)',

            'PRODUCTION_WARNING' => '<div class="alert alert-warning alert-dismissable"><a target="_blank"href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> This plugin may not work as expected in <strong style=\'color: green\'>Production</strong> mode. For better results, move back to <strong>Development</strong> mode.</div>',
            'VERSION_INFO' => '<div class="alert alert-warning alert-dismissable"><a target="_blank" href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> This plugin may not work as expected in <strong style=\'color: green\'>REDCap versions less than  7.3.0</strong> After being on any page for more than 3 minutes, it would disable certain jQuery-enabled triggers, such as auto-complete drop-down fields on data entry forms and any custom Bootstrap components.</div>',
            'TITLE' => 'Move to Production Review',
            'MAIN_TEXT' => 'If your REDCap project is ready to collect live data, move your project to production. The advantages of moving your REDCap project from Development to Production mode includes protecting your data from accidental mistakes and securing collected data. This Move to Production Review plugin will allow you to verify if your project is ready to move to Production or if components of your project require revision. <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Moving+to+Production" > <u>When do I move to Production Mode?</u></a>',
            
            'VALIDATED_NUMBER_FIELDS' => 'Validated Number/Integer Fields:',
            'NUMBER_FIELDS' => 'Number/Integer fields:',
            'UNVALIDATED_NUMBER_FIELDS' => 'Percentage of number/integer fields without a min/max:',
            'VALIDATED_NUMBER_FIELDS_TITLE' => 'The percentage of number/integer fields with a min/max.',
            'VALIDATED_NUMBER_FIELDS_BODY' => 'It is recommended, but not required, to set a min and max for every number field in the project. Have you added min/max where possible in your project? Please see this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Field+Validation">page</a> for help.',

            'VALIDATED_DATE_FIELDS' => 'Validated Date Fields:',
            'DATE_FIELDS' => 'Date fields:',
            'UNVALIDATED_DATE_FIELDS' => 'Percentage of date fields without a min/max:',
            'VALIDATED_DATE_FIELDS_TITLE' => 'The percentage of date fields with a min/max.',
            'VALIDATED_DATE_FIELDS_BODY' => 'It is recommended, but not required, to set a min and max for every date field in the project. Have you added min/max where possible in your project? Please see this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Field+Validation">page</a> for help.',

            'ONLINE_DESIGNER' => 'Online Designer',

            'SURVEY_EMAIL_FIELD_TITLE' => 'Email is Missing for Automated Survey Invitations',
            'SURVEY_EMAIL_FIELD_BODY' => 'You have not designated an email field to use for sending invitations to survey participants (see the Optional Modules section of the Project Setup page). If you do not designate an email-validated text field to be your survey invitation email field, then the Automated Invitations will not work for the Public Survey Link because they will not have an email address to send the survey invitation to when scheduling the invitation for the next survey. Please see this <a href="https://hub.bcchr.ca/display/redcap/Participant+List#ParticipantList-ParticipantListlinkedwithRecordID">page</a> for more help.',

            'TEST_ASI_TITLE' => 'Automated survey invitations have not been sufficiently tested',
            'TEST_ASI_BODY' => 'We recommend you test each survey invitation at least once. This allows you to preview the type of results expected from your project. See this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/ASI+through+email#ASIthroughemail-Settingupautomatedinvitations">page</a> for help.',

            'ALL_FIELDS_VALIDATED_TITLE' => 'All text fields are validated',

            'DESIGNATED_SURVEY_INSTR_TITLE' => 'Survey functionality enabled, but no instruments are enabled as surveys',
            'DESIGNATED_SURVEY_INSTR_BODY' => 'To properly use REDCap\'s survey functionality, you must enable at least one instrument as a survey in the Online Designer. Please see this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Enable+a+Survey">page</a> for more help.',

            'TOTAL_UNFLAGGED_IDENTFIERS' => 'Total Unflagged Identifiers:',
            'TOTAL_IDENTFIERS' => 'Total Identifers:',
            'UNFLAGGED_IDENTIFIERS_TITLE' => 'You have unflagged identifiers in your project',
            'UNFLAGGED_IDENTIFIERS_BODY' => 'You must flag all fields in your project that store indentifying information about participants. Please see this <a target="_blank" href="https://hub.bcchr.ca/display/redcap/Protecting+Email+Addresses+and+Other+Identifiers">page</a> for more help.'
        );

        return $lang[$phrase];
    }



