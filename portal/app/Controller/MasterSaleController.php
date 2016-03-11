<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MasterSaleController extends AppController {

    //put your code here

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business_master';
        parent::__construct($request, $response);
    }

    public function index() {

        $minhasVendas = $this->getAllMyCheckouts();
        $todasVendas = $this->getAllCheckouts();

        $this->set("minhasVendas", $minhasVendas);
        $this->set("todasVendas", $todasVendas);
    }

    public function getAllMyCheckouts() {
        $params = array(
            'Checkout' => array(
                'conditions' => array(
                    'Checkout.company_id' => 99999
                ),
                'order' => array(
                    'Checkout.id' => 'DESC'
                ),
            ),
            'PaymentState',
            'Offer',
            'User',
            'OffersUser'
        );
        $todasCompras = $this->AccentialApi->urlRequestToGetData('payments', 'all', $params);

        return $todasCompras;
    }

    public function getAllCheckouts() {
        $params = array(
            'Checkout' => array(
                'conditions' => array(
                ),
                'order' => array(
                    'Checkout.id' => 'DESC'
                ),
            ),
            'PaymentState',
            'Offer',
            'User',
            'OffersUser'
        );
        $todasCompras = $this->AccentialApi->urlRequestToGetData('payments', 'all', $params);

        return $todasCompras;
    }

}
