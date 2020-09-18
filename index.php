<?php
/**
 * Created by PhpStorm.
 * User: alvaro1
 * Date: 3/17/17
 * Time: 12:45 AM
 */
// large proj for testing 5749 , PID 9748 5292
// Call the REDCap Connect file in the main "redcap" directory
require_once "../../redcap_connect.php";


// OPTIONAL: Display the project header
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';
require_once 'classes/messages.php';
require_once 'classes/utilities.php';


// Check if user can create new records, if not Exit.
 //IsProjectAdmin();

//project information
global $Proj;

//echo $_SERVER['DOCUMENT_ROOT'];
//echo APP_PATH_WEBROOT;
//echo redcap_info();

// Warning if project is in production mode
if ($status == 1) {
    echo lang('PRODUCTION_WARNING');

}
//REDCap Version Warning
if (REDCap::versionCompare(REDCAP_VERSION, '7.3.0') < 0) {

    echo lang('VERSION_INFO');
}

//Load Data Dictionary for the current project
$data_dictionary_array = REDCap::getDataDictionary('array');
/*echo "<pre>";
echo print_array($data_dictionary_array);
echo "</pre>";*/

?>
<link rel="stylesheet" href="styles/go_prod_styles.css">


    <div class="projhdr"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> <?php echo lang('TITLE');?> </div>
    <div id="main-container">
        <div><p><?php echo lang('MAIN_TEXT');?></p></div>

        <button id="go_prod_go_btn" class=" btn btn-md btn-primary btn-block">  <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> <?php echo lang('RUN');?> </button>
        <!--<button   class=" btn btn-lg btn-primary" onclick="displayEditProjPopup();"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>test </button>-->
         <hr>
        <table  id="go_prod_table" style="display: none"  class="table" >
                <thead>
                <tr>
                    <th><strong></strong></th>
                    <th><h4 class="projhdr"><?php echo lang('VALIDATION');?> </h4></th>
                    <th><h4 class="projhdr"><?php echo lang('RESULT');?></h4></th>
                    <th><h4 class="projhdr"><?php echo lang('OPTIONS');?></h4></th>
                </tr>
                </thead>
                                 <!--INITIAL RESULTS ARE LOADED HERE-->
                <tbody id="go_prod_tbody">
                </tbody>
        </table>
         <div id="gp-loader"  style="display: none"  ><div  class="loader"></div></div>
        <div id="gp-loader-extra-time"  style="display: none"   ><div class="alert alert-info fade in" role="alert"><?php echo lang('LOADING_EXTRA_TIME');?></div></div>
        <div id="comments-container" style="display:none">
            <hr/>
            <h4 class="projhdr">Comments</h4>
            <p>If you have any comments regarding the review, changes you don't want to implement, etc, please let us know in the comments below.</p>
            <textarea id="comments" rows="10" cols="150" style="resize:vertical"></textarea>
        </div>
    </div>


    <!--REUSABLE MODAL -->
    <div id="ResultsModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p><?php echo lang('LOADING');?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('CLOSE')?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="edit_project" style="display:none;" title="<?php print cleanHtml2($lang['config_functions_30']) ?>">
        <div class="round chklist" style="padding:10px 20px;">
            <form id="editprojectform" action="<?php echo APP_PATH_WEBROOT ?>ProjectGeneral/edit_project_settings.php?pid=<?php echo $project_id ?>" method="post">
                <table style="width:100%;font-family:Arial;font-size:12px;" cellpadding=0 cellspacing=0>
                    <?php
                    // Include the page with the form
                    include APP_PATH_DOCROOT . 'ProjectGeneral/create_project_form.php';
                    ?>
                </table>
            </form>
        </div>
    </div>

    <!--Ajax calls -->
    <script> var project_id=<?php echo $_GET['pid']; ?>;</script>
    <script type="text/javascript" src="js/ajax_calls.js"> </script>

<?php

/*Remove the go to production button if the project is already in production mode*/
if($status != 1 or $_SESSION["IsJustForFun"]!=true){ //USERID == 'alvaro1' and
?>
    <div id='final-info' style="display: none">
        <br>
        <div class="col-md-12 col-sm-6 col-xs-12 col-lg-12 text-center well" >
            <h4>
                <?php echo lang('I_AGREE_BODY');?>
            </h4> <br><button data-toggle="modal" data-target="#i-agree-modal" id="go_prod_accept_all" class=" btn btn-md btn-success text-center "> <?php echo lang('I_AGREE');?> </button>
        </div>
        <h4 class="projhdr"><?php echo lang('NOTICE');?></h4>
        <hr>
        <div class="row" style="margin-bottom:20px">
            <div class="notice-group col-md-6 col-sm-6">
                <h4><?php echo lang('INFO_WHAT_NETX');?></h4>
                <p><?php echo lang('INFO_WHAT_NETX_BODY');?></p>
                <p><?php echo lang('INFO_WHAT_NETX_BODY_2');?></p>
            </div>
            <div class="notice-group col-md-6 col-sm-6">
                <h4><?php echo lang('INFO_CITATION');?></h4>
                <p><?php echo lang('INFO_CITATION_BODY');?>  </p>
            </div>
        </div>
    </div>

    <div id="i-agree-modal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Ready to Move to Production</h5>
                    <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php print lang('I_AGREE_MODAL'); ?></p>
                </div>
                <div class="modal-footer">
                    <button id="i_agree_modal_close_btn" type="button" class="btn btn-secondary close-modal-btn" data-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        /*Auto Run the report if the  URL  variable is to_prod_plugin=2 */
        $( document ).ready(function() {
            ready_to_prod = <?php echo json_encode($_GET["to_prod_plugin"])?>;

            if (ready_to_prod === '2'){
                $('button[id="go_prod_go_btn"]').click();
            }
        });
    </script>
    <script type="text/javascript">
        document.getElementById("i_agree_modal_close_btn").onclick = function () {
            $.ajax({
                method: "POST",
                url: "ready_to_go_to_prod.php", 
                data: {
                    pid: project_id,
                    table_contents: $('table').prop('outerHTML'),
                    comments: $('textarea').val()
                }
            });
            production = <?php  echo json_encode(APP_PATH_WEBROOT.'ProjectSetup/index.php?pid='.$_GET['pid'].'&to_prod_plugin=1')?>;
            location.href = production;
        };
    </script>
<?php
}


// OPTIONAL: Display the project footer
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';