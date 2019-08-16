<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class POSReportico {
    private $CI;
    private $password;
    
    function __construct() {
        set_include_path(FCPATH.'reportico/');
        require_once('reportico.php');
        $this->password = 'ABqU1!]KfIGb';
    }
    
    function create_report($report="", $type="", $mode='REPORTOUTPUT'){
        
        if(empty($report))
            return;
        
        $q = new reportico();
        $q->initial_project = "POS";
        $q->initial_project_password = $this->password;
        $q->initial_execute_mode = $type;
        $q->initial_report = $report.".xml";
        $q->initial_output_format = "HTML";
        $q->access_mode = $mode;
        $q->embedded_report = true;
        $q->bootstrap_styles = "3";
        $q->bootstrap_preloaded = true;
        $q->reportico_ajax_mode = true;
        //$q->initial_execution_parameters["userid"] = "2";
        $q->force_reportico_mini_maintains = true;
        $q->clear_reportico_session = true;
        $q->jquery_preloaded = false;
        //$q->initial_show_detail = "show";
        //$q->initial_show_graph = "show";
        $q->output_template_parameters["show_hide_prepare_go_buttons"] = "hide";
        $q->session_namespace = "report".  intval($report);
        $q->execute();    
    }
    
    
}
    