<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MasterInsertOfferController
 *
 * @author user
 */
class MasterInsertOfferController extends AppController {

    //put your code here

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business_master';
        parent::__construct($request, $response);
    }

    public function index($offerId) {
        $this->set('atributes', $this->getOfferAtributes());
        $this->set('categories', $this->getCompanysCategory());
        $this->set('filters', $this->getAllFilters());
        if ($offerId != null && isset($offerId)) {
            $this->GeneralFunctions = $this->Components->load('GeneralFunctions');
            $offer = $this->getOfferInformation($this->GeneralFunctions->onlyNumbers($offerId));
            $this->set('offerInformation', $offer);
            $this->set('offerExtra', $this->getOfferExtraInformation($offerId));
            $this->set('offerImages', $this->getAllImagesForOffer($offerId));
            $this->set('offerFilters', $this->getOfferFilters($offerId));
        }
    }
    
       /**
     * Get the information about the offer
     * @param Session $company
     * @param Offer Id $offerId
     * @return Offer
     */
    private function getOfferInformation($offerId) {
        $arrayParams = array(
            'Offer' => array(
                'conditions' => array(
                    'Offer.company_id' =>99999,
                    'Offer.id' => $offerId
                )
            )
        );
        return $this->AccentialApi->urlRequestToGetData('offers', 'first', $arrayParams);
    }

    /**
     * Functio responsible to add and edit basic offer information
     * @return offer
     */
    public function addEditBasicOfferInformation() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $var['Company']['id'] = 99999;

            $company = $var;
            $this->GeneralFunctions = $this->Components->load('GeneralFunctions');
            extract($this->request->data);
            if (!empty($offer_id)) {
                $param['Offer']['id'] = $offer_id;
                $newOffer = false;
            } else {
                $newOffer = true;
            }
            // => Basic filds
            $param['Offer']['company_id'] = $company['Company']['id'];
            $param['Offer']['title'] = $title;
            $param['Offer']['resume'] = $resume;
            $param['Offer']['value'] = $price;
            $param['Offer']['amount_allowed'] = $qtd;
            $param['Offer']['begins_at'] = $this->GeneralFunctions->convertDateBrazilToSQL($begins_at);
            $param['Offer']['parcels'] = $parcels;
            // => Extra Filds
            $param['Offer']['description'] = $description;
            $param['Offer']['specification'] = $specification;
            $param['Offer']['percentage_discount'] = 100 - ($price_offer / $price) * 100;
            $param['Offer']['parcels_impost_value'] = $percentage;
            $param['Offer']['weight'] = $weight == "" ? 0 : $weight;
            $param['Offer']['ends_at'] = $ends_at == "" ? "''" : $this->GeneralFunctions->convertDateBrazilToSQL($ends_at);
            $param['Offer']['metrics'] = "''"; // TODO - 1: o que é este campo
            $param['Offer']['sku'] = $sku;
            $returnAddEdit = $this->AccentialApi->urlRequestToSaveData('offers', $param);
            if (isset($returnAddEdit['data']['Offer']['id'])) {
                $this->editDeliveryInformation($returnAddEdit['data']['Offer']['id'], $newOffer, $offer_type, $delivery_dealine, $delivery_value, $use_correios_api);
            }
            return json_encode($returnAddEdit);
        }
    }

    private function editDeliveryInformation($justAddId, $newOffer, $offer_type, $delivery_dealine, $delivery_value, $use_correios_api) {
        if ($use_correios_api == 1 || $use_correios_api == "1") {
            $delivery_mode = "CORREIO";
            $delivery_dealine = 0;
            $delivery_value = 0;
        } else {
            $delivery_mode = "TRANSPORTA";
            if ($delivery_dealine == "") {
                $delivery_dealine = 0;
            }
            if ($delivery_value == "") {
                $delivery_value = 0;
            }
        }
        if (!$newOffer) {
            $query = "UPDATE offers_extra_infos SET "
                    . " offer_type = '" . $offer_type . "' , "
                    . " delivery_mode = '" . $delivery_mode . "' , "
                    . " delivery_deadline = " . $delivery_dealine . " , "
                    . " delivery_value = " . $delivery_value . ""
                    . " WHERE offer_id = " . $justAddId . ";";
            $paramExtras = array(
                'User' => array(
                    'query' => $query
                )
            );
            $infosExtras = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
        } else {
            $query = "INSERT INTO offers_extra_infos("
                    . "offer_type, "
                    . "delivery_mode, "
                    . "delivery_deadline, "
                    . "delivery_value, "
                    . "offer_id)"
                    . " values("
                    . "'" . $offer_type . "',"
                    . "'" . $delivery_mode . "',"
                    . " " . $delivery_dealine . ","
                    . " " . $delivery_value . ","
                    . " " . $justAddId . ");";
            $paramExtras = array(
                'User' => array(
                    'query' => $query
                )
            );
            $infosExtras = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
        }
        return $infosExtras;
    }

    private function getOfferAtributes() {
        $query = "select * from offers_attributes order by name;";
        $params3 = array(
            'User' => array(
                'query' => $query
            )
        );
        return $this->AccentialApi->urlRequestToGetData('users', 'query', $params3);
    }

    /**
     * Gets all category for the company
     * @return arrys with the categorys
     */
    private function getCompanysCategory() {
        $arrayParams = array(
            'CompaniesCategory' => array()
        );
        return $this->AccentialApi->urlRequestToGetData('companies', 'all', $arrayParams);
    }

    private function getAllFilters() {
        $company = $this->Session->read('CompanyLoggedIn');
        $return['gender'] = $this->getFiltesOfProfiles('gender', $company);
        $return['location'] = $this->getFiltesOfProfiles('location', $company);
        $return['relationship_status'] = $this->getFiltesOfProfiles('relationship_status', $company);
        $return['religion'] = $this->getFiltesOfProfiles('religion', $company);
        $return['political'] = $this->getFiltesOfProfiles('political', $company);
        $return['age'] = $this->getFiltesOfProfilesAges($company);
        return $return;
    }

    private function getFiltesOfProfiles($filter, $company) {
        $paramExtras = array(
            'User' => array(
                'query' => 'SELECT COUNT(facebook_profiles.' . $filter . ') as sum, facebook_profiles.' . $filter . ' as response FROM facebook_profiles INNER JOIN companies_users ON facebook_profiles.user_id = companies_users.user_id AND companies_users.company_id = 119 WHERE facebook_profiles.' . $filter . ' IS NOT NULL GROUP BY ' . $filter . ';'
            )
        );
        $result = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
        $total = 0;
        foreach ($result as $response) {
            $total = $total + $response[0]['sum'];
        }
        $resultArr = array();
        foreach ($result as $key => $response) {
            $resultArr[$key]['param'] = str_replace(",", " ", $response['facebook_profiles']['response']);
            $resultArr[$key]['total'] = number_format((($response[0]['sum'] * 100) / $total), 1);
        }
        return $resultArr;
    }

    private function getFiltesOfProfilesAges($company) {
        $paramExtras = array(
            'User' => array(
                'query' => "
                    SELECT
                        SUM(IF(age < 20,1,0)) AS 0_20,
                        SUM(IF(age BETWEEN 20 AND 29,1,0)) AS 20_29,
                        SUM(IF(age BETWEEN 30 AND 39,1,0)) AS 30_39,
                        SUM(IF(age BETWEEN 40 AND 49,1,0)) AS 40_49,
                        SUM(IF(age BETWEEN 50 AND 59,1,0)) AS 50_59,
                        SUM(IF(age BETWEEN 60 AND 120,1, 0)) AS 60_120,
                        SUM(IF(age >= 121, 1, 0)) AS outro
                    FROM ( SELECT YEAR(CURDATE()) - YEAR(birthday ) AS age 
                    FROM users as a, companies_users as b 
                    WHERE a.id=b.user_id and b.status='ACTIVE' 
                        AND b.company_id =119) AS derived;"
            )
        );
        $result = $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
        $total = 0;
        foreach ($result[0][0] as $key => $response) {
            $total = $total + $response;
        }
        $resultArr = array();
        foreach ($result[0][0] as $key => $response) {
            $resultArr[$key]['param'] = str_replace("_", " a ", $key);
            $resultArr[$key]['total'] = number_format((($response * 100) / $total), 1);
        }
        return $resultArr;
    }

    /**
     * Get the URL of extra images
     * @param Offer id $offerId
     * @return Arrya with images
     */
    private function getAllImagesForOffer($offerId) {
        $query = "SELECT * FROM "
                . " offers_photos"
                . " WHERE offer_id = '" . $offerId . "';";
        $paramExtras = array(
            'User' => array(
                'query' => $query
            )
        );
        return $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
    }

    /**
     * Gets all extra information about the product
     * @param type $offerId
     * @return type
     */
    private function getOfferExtraInformation($offerId) {
        $query = "SELECT * FROM offers_extra_infos WHERE offer_id = $offerId;";
        $paramExtras = array(
            'User' => array(
                'query' => $query
            )
        );
        return $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras)[0];
    }

    private function getOfferFilters($offerId) {
        $query = "SELECT * FROM "
                . " offers_filters"
                . " WHERE offer_id = '" . $offerId . "';";
        $paramExtras = array(
            'User' => array(
                'query' => $query
            )
        );
        return $this->AccentialApi->urlRequestToGetData('users', 'query', $paramExtras);
    }

}
