<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MasterEntriesController
 *
 * @author user
 */
class MasterEntriesController extends AppController {

    //put your code here

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business_master';
        parent::__construct($request, $response);
    }

    public function index() {

        $this->Session->write("offerEditing", false);
        $companies = $this->getAllCompanies();
        $providers = $this->getAllProviders();

        $this->set("companies", $companies);
        $this->set("providers", $providers);
    }

    private function getAllCompanies() {

        $params = array(
            'Company' => array(
                'conditions' => array(
                )
            )
        );
        $companies = $this->AccentialApi->urlRequestToGetData('companies', 'all', $params);
        $this->Session->write('SessionCompanies', $companies);
        return $companies;
    }

    private function getAllProviders() {

        $query = "SELECT * FROM providers;";
        $providersParam = array(
            'User' => array(
                'query' => $query
            )
        );

        $returnProviders = $this->AccentialApi->urlRequestToGetData('users', 'query', $providersParam);
        $this->Session->write('SessionProviders', $returnProviders);
        return $returnProviders;
    }

    public function saveProvider() {
        $this->autoRender = false;

        $editingProvider = $this->Session->read("offerEditing");

        if ($editingProvider == false) {
            // CRIAÇÃO DE FORNECEDOR
            $sql = "INSERT INTO providers(" .
                    "`corporate_name`,"
                    . "`fancy_name`,"
                    . "`description`,"
                    . "`site_url`,"
                    . "`category_id`,"
                    . "`sub_category_id`,"
                    . "`cnpj`,"
                    . "`email`,"
                    . "`password`,"
                    . "`phone`,"
                    . "`phone_2`,"
                    . "`address`,"
                    . "`complement`,"
                    . "`city`,"
                    . "`state`,"
                    . "`district`,"
                    . "`number`,"
                    . "`zip_code`,"
                    . "`responsible_name`,"
                    . "`responsible_cpf`,"
                    . "`responsible_email`,"
                    . "`responsible_phone`,"
                    . "`responsible_phone_2`,"
                    . "`responsible_cell_phone`,"
                    . "`logo`,"
                    . "`status`,"
                    . "`login_moip`,"
                    . "`register`,"
                    . "`facebook_install`,"
                    . "`date_register`"
                    . ") VALUES("
                    . "'" . $this->request->data['provider']['corporate_name'] . "',"
                    . "'" . $this->request->data['provider']['fancy_name'] . "',"
                    . "'descricao forn',"
                    . "'" . $this->request->data['provider']['site'] . "',"
                    . "15,"
                    . "15, "
                    . "'" . $this->request->data['provider']['cnpj'] . "',"
                    . "'" . $this->request->data['provider']['email'] . "',"
                    . "'123456',"
                    . "'" . $this->request->data['provider']['phone'] . "',"
                    . "'" . $this->request->data['provider']['phone_2'] . "',"
                    . "'" . $this->request->data['provider']['address'] . "',"
                    . "'" . $this->request->data['provider']['complement'] . "',"
                    . "'" . $this->request->data['provider']['city'] . "',"
                    . "'" . $this->request->data['provider']['uf'] . "',"
                    . "'" . $this->request->data['provider']['district'] . "',"
                    . "'" . $this->request->data['provider']['number'] . "',"
                    . "'" . $this->request->data['provider']['cep'] . "',"
                    . "'" . $this->request->data['provider']['responsible_name'] . "',"
                    . "'" . $this->request->data['provider']['responsible_cpf'] . "',"
                    . "'" . $this->request->data['provider']['responsible_email'] . "',"
                    . "'" . $this->request->data['provider']['responsible_phone'] . "',"
                    . "'" . $this->request->data['provider']['responsible_phone_2'] . "',"
                    . "'" . $this->request->data['provider']['responsible_cell'] . "',"
                    . "'logoglollgolgolokogolgogl',"
                    . "'ACTIVE',"
                    . "0,"
                    . "0,"
                    . "0,"
                    . "'0000-00-00 00:00:00'"
                    . ");";

            $providersParam = array(
                'User' => array(
                    'query' => $sql
                )
            );
            $retorno = $this->AccentialApi->urlRequestToGetData('users', 'query', $providersParam);

            echo print_r($retorno);
        } else {
            //EDIÇÃO DE FORNECEDOR
            $sqlEdit = "UPDATE providers set" .
                    " corporate_name = '" . $this->request->data['provider']['corporate_name'] . "',"
                    . "fancy_name = '" . $this->request->data['provider']['fancy_name'] . "',"
                    . "description = 'DESCRIPTION',"
                    . "site_url = '" . $this->request->data['provider']['site'] . "',"
                    . "category_id = 15,"
                    . "sub_category_id = 15,"
                    . "cnpj = '" . $this->request->data['provider']['cnpj'] . "',"
                    . "email = '" . $this->request->data['provider']['email'] . "',"
                    . "password = '123456',"
                    . "phone = '" . $this->request->data['provider']['phone'] . "',"
                    . "phone_2 = '" . $this->request->data['provider']['phone_2'] . "',"
                    . "address = '" . $this->request->data['provider']['address'] . "',"
                    . "complement = '" . $this->request->data['provider']['complement'] . "',"
                    . "city = '" . $this->request->data['provider']['city'] . "',"
                    . "state ='" . $this->request->data['provider']['uf'] . "',"
                    . "district = '" . $this->request->data['provider']['district'] . "',"
                    . "number = '" . $this->request->data['provider']['number'] . "',"
                    . "zip_code = '" . $this->request->data['provider']['cep'] . "',"
                    . "responsible_name = '" . $this->request->data['provider']['responsible_name'] . "',"
                    . "responsible_cpf ='" . $this->request->data['provider']['responsible_cpf'] . "',"
                    . "responsible_email ='" . $this->request->data['provider']['responsible_email'] . "',"
                    . "responsible_phone ='" . $this->request->data['provider']['responsible_phone'] . "',"
                    . "responsible_phone_2 = '" . $this->request->data['provider']['responsible_phone_2'] . "',"
                    . "responsible_cell_phone = '" . $this->request->data['provider']['responsible_cell'] . "',"
                    . "logo = 'logogogogogog',"
                    . "status = 'ACTIVE',"
                    . "login_moip = 0,"
                    . "register = 0,"
                    . "facebook_install = 0,"
                    . "date_register = '0000-00-00 00:00:00'"
                    . "WHERE id = " . $this->request->data['provider']['id'] . ";";

            $providersParamEdit = array(
                'User' => array(
                    'query' => $sqlEdit
                )
            );
            $retorno = $this->AccentialApi->urlRequestToGetData('users', 'query', $providersParamEdit);

            //EDITANDO OFERTA = TRUE
            $this->Session->write("offerEditing", false);
        }
    }

    public function editProvider() {

        //EDITANDO OFERTA = TRUE
        $this->Session->write("offerEditing", true);

        $this->layout = "";
        $index = $this->request->data['providerIndex'];
        $providers = $this->Session->read('SessionProviders');
        $provider = $providers[$index];
        $this->set("provider", $provider);
    }

    public function removeProvider() {

        $this->layout = '';
        $query = "UPDATE providers SET status = 'INACTIVE' WHERE id = {$this->request->data['id']};";
        $providersParam = array(
            'User' => array(
                'query' => $query
            )
        );

        $returnProviders = $this->AccentialApi->urlRequestToGetData('users', 'query', $providersParam);
        echo print_r($returnProviders);
    }

    public function reativeProvider() {

        $this->layout = '';
        $query = "UPDATE providers SET status = 'ACTIVE' WHERE id = {$this->request->data['id']};";
        $providersParam = array(
            'User' => array(
                'query' => $query
            )
        );

        $returnProviders = $this->AccentialApi->urlRequestToGetData('users', 'query', $providersParam);
        echo print_r($returnProviders);
    }

    public function showSaveCompany() {

        $this->layout = "";
    }

    public function saveCompany() {

        $this->autoRender = false;

        $editingCompany = $this->Session->read("companyEditing");

        if ($editingCompany == false) {
            // CRIAÇÃO DE FORNECEDOR
            $sql = "INSERT INTO companies(" .
                    "`corporate_name`,"
                    . "`fancy_name`,"
                    . "`description`,"
                    . "`site_url`,"
                    . "`category_id`,"
                    . "`sub_category_id`,"
                    . "`cnpj`,"
                    . "`email`,"
                    . "`password`,"
                    . "`phone`,"
                    . "`phone_2`,"
                    . "`address`,"
                    . "`complement`,"
                    . "`city`,"
                    . "`state`,"
                    . "`district`,"
                    . "`number`,"
                    . "`zip_code`,"
                    . "`responsible_name`,"
                    . "`responsible_cpf`,"
                    . "`responsible_email`,"
                    . "`responsible_phone`,"
                    . "`responsible_phone_2`,"
                    . "`responsible_cell_phone`,"
                    . "`logo`,"
                    . "`status`,"
                    . "`login_moip`,"
                    . "`register`,"
                    . "`facebook_install`,"
                    . "`date_register`"
                    . ") VALUES("
                    . "'" . $this->request->data['Company']['corporate_name'] . "',"
                    . "'" . $this->request->data['Company']['fancy_name'] . "',"
                    . "'descricao forn',"
                    . "'" . $this->request->data['Company']['site'] . "',"
                    . "15,"
                    . "15, "
                    . "'" . $this->request->data['Company']['cnpj'] . "',"
                    . "'" . $this->request->data['Company']['email'] . "',"
                    . "'123456',"
                    . "'" . $this->request->data['Company']['phone'] . "',"
                    . "'" . $this->request->data['Company']['phone_2'] . "',"
                    . "'" . $this->request->data['Company']['address'] . "',"
                    . "'" . $this->request->data['Company']['complement'] . "',"
                    . "'" . $this->request->data['Company']['city'] . "',"
                    . "'" . $this->request->data['Company']['uf'] . "',"
                    . "'" . $this->request->data['Company']['district'] . "',"
                    . "'" . $this->request->data['Company']['number'] . "',"
                    . "'" . $this->request->data['Company']['cep'] . "',"
                    . "'" . $this->request->data['Company']['responsible_name'] . "',"
                    . "'" . $this->request->data['Company']['responsible_cpf'] . "',"
                    . "'" . $this->request->data['Company']['responsible_email'] . "',"
                    . "'" . $this->request->data['Company']['responsible_phone'] . "',"
                    . "'" . $this->request->data['Company']['responsible_phone_2'] . "',"
                    . "'" . $this->request->data['Company']['responsible_cell'] . "',"
                    . "'logoglollgolgolokogolgogl',"
                    . "'ACTIVE',"
                    . "0,"
                    . "0,"
                    . "0,"
                    . "'0000-00-00 00:00:00'"
                    . ");";

            $CompanysParam = array(
                'User' => array(
                    'query' => $sql
                )
            );
            $retorno = $this->AccentialApi->urlRequestToGetData('users', 'query', $CompanysParam);

            echo print_r($retorno);
        } else {
            //EDIÇÃO DE FORNECEDOR
            $sqlEdit = "UPDATE companies set" .
                    " corporate_name = '" . $this->request->data['Company']['corporate_name'] . "',"
                    . "fancy_name = '" . $this->request->data['Company']['fancy_name'] . "',"
                    . "description = 'DESCRIPTION',"
                    . "site_url = '" . $this->request->data['Company']['site'] . "',"
                    . "category_id = 15,"
                    . "sub_category_id = 15,"
                    . "cnpj = '" . $this->request->data['Company']['cnpj'] . "',"
                    . "email = '" . $this->request->data['Company']['email'] . "',"
                    . "password = '123456',"
                    . "phone = '" . $this->request->data['Company']['phone'] . "',"
                    . "phone_2 = '" . $this->request->data['Company']['phone_2'] . "',"
                    . "address = '" . $this->request->data['Company']['address'] . "',"
                    . "complement = '" . $this->request->data['Company']['complement'] . "',"
                    . "city = '" . $this->request->data['Company']['city'] . "',"
                    . "state ='" . $this->request->data['Company']['uf'] . "',"
                    . "district = '" . $this->request->data['Company']['district'] . "',"
                    . "number = '" . $this->request->data['Company']['number'] . "',"
                    . "zip_code = '" . $this->request->data['Company']['cep'] . "',"
                    . "responsible_name = '" . $this->request->data['Company']['responsible_name'] . "',"
                    . "responsible_cpf ='" . $this->request->data['Company']['responsible_cpf'] . "',"
                    . "responsible_email ='" . $this->request->data['Company']['responsible_email'] . "',"
                    . "responsible_phone ='" . $this->request->data['Company']['responsible_phone'] . "',"
                    . "responsible_phone_2 = '" . $this->request->data['Company']['responsible_phone_2'] . "',"
                    . "responsible_cell_phone = '" . $this->request->data['Company']['responsible_cell'] . "',"
                    . "logo = 'logogogogogog',"
                    . "status = 'ACTIVE',"
                    . "login_moip = 0,"
                    . "register = 0,"
                    . "facebook_install = 0,"
                    . "date_register = '0000-00-00 00:00:00'"
                    . "WHERE id = " . $this->request->data['Company']['id'] . ";";

            $CompanysParamEdit = array(
                'User' => array(
                    'query' => $sqlEdit
                )
            );
            $retorno = $this->AccentialApi->urlRequestToGetData('users', 'query', $CompanysParamEdit);

            //EDITANDO OFERTA = TRUE
            $this->Session->write("companyEditing", false);
        }
    }

    public function editCompany() {

        //EDITANDO OFERTA = TRUE
        $this->Session->write("companyEditing", true);

        $this->layout = "";
        $index = $this->request->data['companyIndex'];
        $companies = $this->Session->read('SessionCompanies');
        $company = $companies[$index];
        $this->set("company", $company);
    }

    public function removeCompany() {

        $this->layout = '';
        $query = "UPDATE companies SET status = 'INACTIVE' WHERE id = {$this->request->data['id']};";
        $providersParam = array(
            'User' => array(
                'query' => $query
            )
        );

        $returnProviders = $this->AccentialApi->urlRequestToGetData('users', 'query', $providersParam);
        echo print_r($returnProviders);
    }

    public function reativeCompany() {

        $this->layout = '';
        $query = "UPDATE companies SET status = 'ACTIVE' WHERE id = {$this->request->data['id']};";
        $providersParam = array(
            'User' => array(
                'query' => $query
            )
        );

        $returnProviders = $this->AccentialApi->urlRequestToGetData('users', 'query', $providersParam);
        echo print_r($returnProviders);
    }

}
