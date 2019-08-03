<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My_Exception
 *
 * @author Azim
 */
class MY_Exceptions extends CI_Exceptions {

    public $error_controller = 'dashboard';
    public $error_method_404 = 'error_404';

    function __construct()
    {
        parent::CI_Exceptions();
        log_message('debug', 'MY_Exceptions Class Initialized');
    }
    
    function show_404($page = '')
    {
        // log the error
        log_message('error', '404 Page Not Found --&gt; ' . $page);    
        
        // get the CI base URL
        $this->config =& get_config();
        $base_url = $this->config['base_url'];     
        
        // see: http://www.kelvinluck.com/2009/04/custom-404-error-messages-with-codeigniter/
        
        // create new cURL resource
        $ch = curl_init();
        
        // set URL and other options
        curl_setopt($ch, CURLOPT_URL, $base_url . "$this->error_controller/$this->error_method_404");
        curl_setopt($ch, CURLOPT_HEADER, 0); // note: the 404 header is already set in the error controller
        
        // pass URL to the browser
        curl_exec($ch);
        
        // close cURL resource, and free up system resources
        curl_close($ch);
    }
   
}
