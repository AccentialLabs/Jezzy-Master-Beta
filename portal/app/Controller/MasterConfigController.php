<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MasterConfigController
 *
 * @author user
 */
class MasterConfigController extends AppController {

    //put your code here

    public function __construct($request = null, $response = null) {
        $this->layout = 'default_business_master';
        parent::__construct($request, $response);
    }

    public function index() {

        $secondMasterUserTypes = $this->getAllSecondaryMasterUsersTypes();
        $secondariesUsers = $this->getAllSecondaryUsers();

        $this->Session->write("secondariesUsersList", $secondariesUsers);
        $this->set("secondsMasterUsersTypes", $secondMasterUserTypes);
        $this->set("secondariesUsers", $secondariesUsers);
    }

    public function getAllSecondaryMasterUsersTypes() {

        $query = "select * from secondary_masterusers_types;";

        $conditions = array(
            'User' => array(
                'query' => $query
            )
        );

        $masterUsers = $this->AccentialApi->urlRequestToGetData('users', 'query', $conditions);
        return $masterUsers;
    }

    public function getAllSecondaryUsers() {

        $query = "select * from secondary_masterusers inner join secondary_masterusers_types on secondary_masterusers_types.id = secondary_masterusers.secondary_type_id;";
        $conditions = array(
            'User' => array(
                'query' => $query
            )
        );

        $secondariesUsers = $this->AccentialApi->urlRequestToGetData('users', 'query', $conditions);
        return $secondariesUsers;
    }

    public function removeSecondaryUser() {
        $this->autoRender = false;
        $query = "UPDATE secondary_masterusers SET status = 'INACTIVE' WHERE id = " . $this->request->data['id'] . ";";
        $conditions = array(
            'User' => array(
                'query' => $query
            )
        );

        $this->AccentialApi->urlRequestToGetData('users', 'query', $conditions);
    }

    public function reativeSecondaryUser() {
        $this->autoRender = false;
        $query = "UPDATE secondary_masterusers SET status = 'ACTIVE' WHERE id = " . $this->request->data['id'] . ";";
        $conditions = array(
            'User' => array(
                'query' => $query
            )
        );

        $this->AccentialApi->urlRequestToGetData('users', 'query', $conditions);
    }

    public function createSecondUser() {
        $this->autoRender = false;
        $sql = "INSERT INTO secondary_masterusers("
                . "name,"
                . "email,"
                . "password,"
                . "company_id,"
                . "secondary_type_id)"
                . "VALUES("
                . "'" . $this->request->data['name'] . "',"
                . "'" . $this->request->data['email'] . "',"
                . "'" . md5('123456') . "',"
                . "99999,"
                . $this->request->data['secondary_type_id'] . ");";

        $conditions = array(
            'User' => array(
                'query' => $sql
            )
        );

        $this->AccentialApi->urlRequestToGetData('users', 'query', $conditions);
    }

    public function showEditSecondUser() {

        $this->layout = "";
        $index = $this->request->data['index'];

        $seconds = $this->Session->read("secondariesUsersList");

        $user = $seconds[$index];
        $secondMasterUserTypes = $this->getAllSecondaryMasterUsersTypes();
        $this->set("secondsMasterUsersTypes", $secondMasterUserTypes);
        $this->set("user", $user);
    }

    public function saveUpdateSecondaryUser() {
        $this->autoRender = false;
        $query = "UPDATE secondary_masterusers SET "
                . "name = '" . $this->request->data['name'] . "',"
                . "email = '" . $this->request->data['email'] . "',"
                . "secondary_type_id = " . $this->request->data['secondary_type_id'] . ""
                . " WHERE id = " . $this->request->data['id'] . ";";

        $conditions = array(
            'User' => array(
                'query' => $query
            )
        );

        $this->AccentialApi->urlRequestToGetData('users', 'query', $conditions);
    }

}
