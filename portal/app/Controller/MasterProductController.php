<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MasterProductController
 *
 * @author user
 */
App::import('Vendor', 'PHPExcel');

class MasterProductController extends AppController {

    //put your code here

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business_master';
        parent::__construct($request, $response);
    }

    public function index() {
        $offers = $this->getAllOffers();
        $myOffers = $this->getAllMyOffers();
        $this->set("offers", $offers);
        $this->set("myOffers", $myOffers);
    }

    private function getAllOffers() {

        $arrayParams = array(
            'Offer' => array(
                'conditions' => array(
                ),
                'order' => array(
                    'Offer.id' => 'DESC'
                ),
            ),
            'Company'
        );
        $offers = $this->AccentialApi->urlRequestToGetData('offers', 'all', $arrayParams);
        $offersWithStatistics = '';
        foreach ($offers as $offer) {
            $statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card, sum(evaluation) evaluation, count(evaluation) votantes
                from offers_statistics 
                inner join offers_comments on offers_statistics.offer_id = offers_comments.offer_id 
                where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

            $statisticsParams = array(
                'User' => array(
                    'query' => $statisticsQuery
                )
            );
            $statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
            $offer['Statistics'] = $statistics[0];
            $offersWithStatistics[] = $offer;
        }
        return $offersWithStatistics;
    }

    public function sendFileXls() {
        $this->layout = "";
        echo $_FILES['xlsFile']['tmp_name'];

        $objReader = new PHPExcel_Reader_Excel5();
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load("C:/xampp/htdocs/jezzy-master/portal/app/teste_php.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);
    }

    public function getAllMyOffers() {

        $arrayParams = array(
            'Offer' => array(
                'conditions' => array(
                    'Offer.company_id' => 99999
                ),
                'order' => array(
                    'Offer.id' => 'DESC'
                )
            )
        );
        $offers = $this->AccentialApi->urlRequestToGetData('offers', 'all', $arrayParams);
        $offersWithStatistics = '';
        foreach ($offers as $offer) {
            $statisticsQuery = "select details_click, checkouts_click, purchased_billet, purchased_card, sum(evaluation) evaluation, count(evaluation) votantes
                from offers_statistics 
                inner join offers_comments on offers_statistics.offer_id = offers_comments.offer_id 
                where offers_statistics.offer_id =" . $offer['Offer']['id'] . ";";

            $statisticsParams = array(
                'User' => array(
                    'query' => $statisticsQuery
                )
            );
            $statistics = $this->AccentialApi->urlRequestToGetData('users', 'query', $statisticsParams);
            $offer['Statistics'] = $statistics[0];
            $offersWithStatistics[] = $offer;
        }
        return $offersWithStatistics;
    }

}
