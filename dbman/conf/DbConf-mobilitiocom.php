<?php

class DbConf {
    private $dbUrl = "";
    private $dbUser = "";
    private $dbPass = "";
    private $dbName = "";
    private $dbClientTableName = "clientdata";
    private $dbRecordTableName = "healthrecords";
    
    function getDbUrl() {
        return $this->dbUrl;
    }
    
    function getDbUser() {
        return $this->dbUser;
    }
    
    function getDbPass() {
        return $this->dbPass;       
    }
    
    function getDbName() {
        return $this->dbName;
    }
    
    function getDbClientTableName() {
        return $this->dbClientTableName;
    }
    
    function getRecordTableName() {
        return $this->dbRecordTableName;               
    }
    
}

?>
