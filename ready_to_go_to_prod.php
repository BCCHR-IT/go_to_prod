<?php

require_once "../../redcap_connect.php";
require_once "vendor/autoload.php";

use Dompdf\Dompdf;

function deleteRepositoryFile($file)
{
    global $edoc_storage_option,$wdc,$webdav_path;
    if ($edoc_storage_option == '1') {
        // Webdav
        $wdc->delete($webdav_path . $file);
    } elseif ($edoc_storage_option == '2') {
        // S3
        global $amazon_s3_key, $amazon_s3_secret, $amazon_s3_bucket;
        $s3 = new S3($amazon_s3_key, $amazon_s3_secret, SSL); if (isset($GLOBALS['amazon_s3_endpoint']) && $GLOBALS['amazon_s3_endpoint'] != '') $s3->setEndpoint($GLOBALS['amazon_s3_endpoint']);
        $s3->deleteObject($amazon_s3_bucket, $file);
    } else {
        // Local
        @unlink(EDOC_PATH . $file);
    }
}

/*
 * Save Table of Results to the File Repository.
 */ 
$results = $_POST["table_contents"];
$comments = $_POST["comments"];
$pid = $_POST["pid"];

if (!empty($results)) 
{
    $filename = "Move to Production Plugin Results";
    $file_extension = "pdf";

    $dompdf = new Dompdf();
    $dompdf->loadHtml("$results<hr/><h4>Comments</h4><p>" . str_replace("\n", "<br/>", $comments) . "</p>");

    $dompdf->render();

    $pdf_content = $dompdf->output();

    // Upload the compiled report to the File Repository
    $database_success = FALSE;
    $upload_success = FALSE;

    $dummy_file_name = $filename;
    $dummy_file_name = preg_replace("/[^a-zA-Z-._0-9]/","_",$dummy_file_name);
    $dummy_file_name = str_replace("__","_",$dummy_file_name);
    $dummy_file_name = str_replace("__","_",$dummy_file_name);

    $stored_name = date('YmdHis') . "_pid" . $pid . "_" . generateRandomHash(6) . ".$file_extension";

    $upload_success = file_put_contents(EDOC_PATH . $stored_name, $pdf_content);
    $err_msg = "";

    if ($upload_success !== FALSE) 
    {
        $dummy_file_size = $upload_success;
        $dummy_file_type = "application/$file_extension";
        
        $file_repo_name = date("Y/m/d H:i:s");

        $sql = "INSERT INTO redcap_docs (project_id,docs_date,docs_name,docs_size,docs_type,docs_comment,docs_rights)
                VALUES ($pid,CURRENT_DATE,'$dummy_file_name.$file_extension','$dummy_file_size','$dummy_file_type',
                \"$file_repo_name - $filename (" . USERID . ")\",NULL)";
                        
        if (db_query($sql)) 
        {
            $docs_id = db_insert_id();

            $sql = "INSERT INTO redcap_edocs_metadata (stored_name,mime_type,doc_name,doc_size,file_extension,project_id,stored_date)
                    VALUES('".$stored_name."','".$dummy_file_type."','".$dummy_file_name."','".$dummy_file_size."',
                    '".$file_extension."','".$pid."','".date('Y-m-d H:i:s')."');";
                        
            if (db_query($sql)) 
            {
                $doc_id = db_insert_id();
                $sql = "INSERT INTO redcap_docs_to_edocs (docs_id,doc_id) VALUES ('".$docs_id."','".$doc_id."');";
                            
                if (db_query($sql)) 
                {
                    // Logging
                    $database_success = TRUE;
                } 
                else 
                {
                    /* if this failed, we need to roll back redcap_edocs_metadata and redcap_docs */
                    db_query("DELETE FROM redcap_edocs_metadata WHERE doc_id='".$doc_id."';");
                    db_query("DELETE FROM redcap_docs WHERE docs_id='".$docs_id."';");
                    deleteRepositoryFile($stored_name);
                    $err_msg = "Unable to save file metadata to redcap_docs_to_edocs.";
                }
            } 
            else
            {
                /* if we failed here, we need to roll back redcap_docs */
                db_query("DELETE FROM redcap_docs WHERE docs_id='".$docs_id."';");
                deleteRepositoryFile($stored_name);
                $err_msg = "Unable to save file metadata to redcap_edocs_metadata.";
            }
        }
        else 
        {
            /* if we failed here, we need to delete the file */
            deleteRepositoryFile($stored_name);
            $err_msg = "Unable to save file metadata to redcap_docs.";
        }            
    }
    else
    {
        $err_msg = "Unable to upload file use file_put_contents";
    }

    if ($database_success === FALSE) 
    {
        REDCap::logEvent("Move to Production - Error", "Failed to save copy of results to the File Repository. $err_msg", $sql, null, null, $pid);
    }
}

/*
 * Log completion 
 */
REDCap::logEvent("User has completed the Move to Production plugin.", "User has completed the Move to Production plugin, and the results have been saved to the File Repository.", null, null, null, $pid);