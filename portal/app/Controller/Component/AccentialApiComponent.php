<?php

/**
 * Accential API class.
 */
class AccentialApiComponent extends Component {

    public $components = array('CurlRequest');
    private $paramsValidationStatus;
    private $ftpUploadConfig;
    private $ftpAccentialUploadConfig;

    public function __construct($request = null, $response = null) {
        if (!$this->paramsValidationStatus) {
            $this->paramsValidationStatus = Configure::read('paramsValidationStatus');
        }
        if (!$this->ftpUploadConfig){
            $this->ftpUploadConfig = Configure::read('ftpUploadConfig');
        }
        if (!$this->ftpAccentialUploadConfig){
            $this->ftpAccentialUploadConfig = Configure::read('ftpAccentialUploadConfig');
        }
        parent::__construct($request, $response);
    }

    /**
     * Just to test this class.
     */
    public function accentialApiTestMethod() {
        return "Retorno: accentialApiTestMethod - CLASS: AccentialApiComponent";
    }

    /**
     * Responsible for requesting data to the API.
     */
    public function urlRequestToGetData($api, $type, $params) {
        $apiUrl = API_ENVIRONMENT_URL . '/';
        $apiUrl .= $api . '/get';
        $apiUrl .= '/' . $type;
        if (!empty($params) && is_array($params)) {
            $paramsJson = json_encode($params);
            $params = array(
                'params' => $paramsJson
            );
        } else {
            return $this->paramsValidationStatus ['invalid_param'];
        }
        $apiUrl .= '/' . $this->generateSecureToken();
        $data = $this->CurlRequest->curlRequest($apiUrl, $params);
        return $this->decodeData($data);
    }

    /**
     * Responsible for registering / editing data of a given API	
     */
    public function urlRequestToSaveData($api, $params) {
        $apiUrl = API_ENVIRONMENT_URL . '/';
        $apiUrl .= $api . '/save';
        $apiUrl .= '/all';
        if (!empty($params) && is_array($params)) {
            $paramsJson = json_encode($params);
            $params = array(
                'params' => $paramsJson
            );
            $apiUrl .= '/' . $this->generateSecureToken();
            $data = $this->CurlRequest->curlRequest($apiUrl, $params);
            return $this->decodeData($data);
        } else {
            return $this->paramsValidationStatus ['invalid_param'];
        }
    }

    //TODO: rever estes metodos de upload image, como estão estruturados nao tem muito sentido
    /**
     * Responsible to send file to ftp server
     */
    public function uploadFileComp($folder = null, $fileData, $recursive = false) {
        $data = '';
        if ($recursive) {
            foreach ($fileData as $file) {
                $data [] = $this->uploadFile($folder, $file);
            }
            return $data;
            exit();
        } else {
            $ftpConnectionId = ftp_connect('54.94.182.35');
            $ftpLogin = ftp_login($ftpConnectionId, 'acclabs-ftp', 'ACCftp1000');
        }
        $folder = (!$folder ? '' : $folder . '/');
        $explodeFileData = explode('.', $fileData ['name']);
        $fileExt = end($explodeFileData);
        $renamedRemoteFile = uniqid() . '.' . $fileExt;
        $pathToUpload = LOCAL_PATH_TO_UPLOAD . $renamedRemoteFile;
        $localFile = $fileData ['tmp_name'];
        if ($ftpLogin) {
            ftp_pasv($ftpConnectionId, true);
            if (ftp_put($ftpConnectionId, $pathToUpload, $localFile, FTP_BINARY)) {
                $data = FTP_ENVIRONMENT_URL . $renamedRemoteFile;
            } else {
                $data = 'UPLOAD_ERROR';
            }
        } else {
            $data = 'NO_CONNECTION';
        }
        ftp_close($ftpConnectionId);
        return $data;
    }

    /**
     * Responsible to send file to ftp server
     */
    private function uploadFile($folder = null, $fileData, $recursive = false) {
        $data = '';
        if ($recursive) {
            foreach ($fileData as $file) {
                $data [] = $this->uploadFile($folder, $file);
            }
            return $data;
            exit();
        } else {
            $ftpConnectionId = ftp_connect($this->ftpUploadConfig ['host']);
            $ftpLogin = ftp_login($ftpConnectionId, $this->ftpUploadConfig ['user'], $this->ftpUploadConfig ['password']);
        }
        $folder = (!$folder ? '' : $folder . '/');
        $fileExt = end(explode('.', $fileData ['name']));
        $renamedRemoteFile = uniqid() . '.' . $fileExt;
        $pathToUpload = $this->ftpUploadConfig ['uploadPath'] . $this->ftpUploadConfig ['uploadFolder'] . $folder . $renamedRemoteFile;
        $localFile = $fileData ['tmp_name'];
        if ($ftpLogin) {
            ftp_pasv($ftpConnectionId, true);
            if (ftp_put($ftpConnectionId, $pathToUpload, $localFile, FTP_BINARY)) {
                $data = $this->ftpUploadConfig ['url'] . '/' . $this->ftpUploadConfig ['uploadFolder'] . $folder . $renamedRemoteFile;
            } else {
                $data = 'UPLOAD_ERROR';
            }
        } else {
            $data = 'NO_CONNECTION';
        }
        ftp_close($ftpConnectionId);
        return $data;
    }

    public function uploadFileOffer($folder = null, $fileData, $recursive = false) {
        $data = '';
        if ($recursive) {
            foreach ($fileData as $file) {
                $data [] = $this->uploadFile($folder, $file);
            }
            return $data;
            exit();
        } else {
            $ftpConnectionId = ftp_connect($this->ftpAccentialUploadConfig ['host']);
            $ftpLogin = ftp_login($ftpConnectionId, $this->ftpAccentialUploadConfig ['user'], $this->ftpAccentialUploadConfig ['password']);
        }
        $folder = (!$folder ? '' : $folder . '/');
        $explodeFileData = explode('.', $fileData ['name']);
        $fileExt = end($explodeFileData);
        $renamedRemoteFile = uniqid() . '.' . $fileExt;
        $pathToUpload = LOCAL_PATH_TO_UPLOAD_IMAGE . $renamedRemoteFile;
        $localFile = $fileData ['tmp_name'];
        if ($ftpLogin) {
            ftp_pasv($ftpConnectionId, true);
            if (ftp_put($ftpConnectionId, $pathToUpload, $localFile, FTP_BINARY)) {
                $data = FTP_ENVIRONMENT_URL_IMAGES . $renamedRemoteFile;
            } else {
                $data = 'UPLOAD_ERROR';
            }
        } else {
            $data = 'NO_CONNECTION';
        }
        ftp_close($ftpConnectionId);
        return $data;
    }
    
    /**
     * Generate Secure TOKEN for API comunication
     */
    public function generateSecureToken() {
        $timestamp = time();
        $array = array('secureNumbers' => $timestamp);
        $json = json_encode($array);
        return base64_encode($json);
    }

    /**
     * Decode the returned data from API
     */
    public function decodeData($base64String = null) {
        if (!$base64String) {
            return null;
        }
        $json = base64_decode($base64String);
        $array = json_decode($json, true);
        return $array;
    }

}
