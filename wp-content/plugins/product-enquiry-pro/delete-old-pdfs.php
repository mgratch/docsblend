<?php

/**
 * This file deals with deleting PDF created before more than 1 hour using cron job
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


// Function which will register the cron to delete PDFs on activation of the plugin
function quoteupRegisterDeletePdfs()
{
    // Make sure this event hasn't been scheduled
    if (!wp_next_scheduled('quoteupDeletePdfs')) {
        // Schedule the event
        wp_schedule_event(time(), 'hourly', 'quoteupDeletePdfs');
    }
}

//Function will clear the cron on deactivation of plugin
function quoteDeregisterDeletePdfs()
{
    wp_clear_scheduled_hook('quoteupDeletePdfs');
}


add_action('quoteupDeletePdfs', 'quoteupDeletePdfsCallback');

//Function that performs actual deleting process.
function quoteupDeletePdfsCallback()
{
    global $wpdb;
    //find out pdfs older than an hour and delete them
    $uploadDir   = wp_upload_dir();
    $pdfDir      = $uploadDir[ 'basedir' ] . '/QuoteUp_PDF/';

    if (! file_exists($pdfDir)) {
        return;
    }

    $all_files = glob($pdfDir . "*");
    if ($all_files) {
        /*		 * * cycle through all files in the directory ** */
        foreach ($all_files as $file) {
            /*			 * * if file is older than an hour, delete it ** */
            if (filemtime($file) < time() - 3600) {
                //Update Enquiry table for deleted file enquiry ID
                $enquiry_id = basename($file, '.pdf');
                $table_name         = $wpdb->prefix . "enquiry_detail_new";
                $wpdb->update(
                    $table_name,
                    array(
                        'pdf_deleted'   => 1,
                    ),
                    array(
                        'enquiry_id' => $enquiry_id
                    )
                );
                //END
                unlink($file);
            }
        }
    }
}
