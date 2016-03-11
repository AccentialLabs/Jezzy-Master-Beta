<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MasterDashboardController
 *
 * @author user
 */
class MasterDashboardController extends AppController{
    //put your code here
    
     public function __construct($request = null, $response = null) {
        $this->layout = 'default_business_master';
        parent::__construct($request, $response);
    }
    
    
     public function index() {
        $master = $this->Session->read('CompanyLoggedIn');
      
        
        $this->set('master', $master);
    }
}
