<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once '../conf/DbConf.php';

/**
 * Description of DbMan
 *
 * @author Antti Ketola <antiq@mobilitio.com>
 */
class DbMan {

    private $dbConf;
    private $connection;
    private $db;

    public function __construct() {
        $this->dbConf = new DbConf();
    }

    public function connect() {

        $this->connection = mysql_connect($this->dbConf->getDbUrl(), $this->dbConf->getDbUser(), $this->dbConf->getDbPass());
        $db = mysql_select_db($this->dbConf->getDbName(), $this->connection);
        if (!$db) {
            die('DB seletion failed: ' . mysql_error());
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function disconnect() {
        mysql_close($this->connection);
    }

    public function insertHealthRecord($rectime, $username, $glucose, $carbs, $insuline, $insulinetype, $weight, $diastolic, $systolic, $pulse) {
        $query = "INSERT INTO " . $this->dbConf->getRecordTableName() .
                " (RecordTime, Username, Glucose, Carbs, Insuline, Insulinetype, Weight, Diastolic, Systolic, Pulse) " .
                "VALUES(CURRENT_TIMESTAMP,'" . $username . "'," .
                $glucose . "," . $carbs . "," . $insuline . ",'" .
                $insulinetype . "'," . $weight . "," . $diastolic . "," .
                $systolic . "," . $pulse . ")";
        try {
            $result = mysql_query($query, $this->connection);
            if (!$result) {
                die('Invalid query: ' . mysql_error());
            }
        } catch (Exception $ex) {
            $foo = print("SQL failed:" . $ex);
        }
    }

        public function insertTimedHealthRecord($rectime_ms, $username, $glucose, $carbs, $insuline, $insulinetype, $weight, $diastolic, $systolic, $pulse) {
        
        $mytime = date('Y-m-d H:i:s',$rectime_ms/1000);
        
        $query = "INSERT INTO " . $this->dbConf->getRecordTableName() .
                " (RecordTime, Username, Glucose, Carbs, Insuline, Insulinetype, Weight, Diastolic, Systolic, Pulse) " .
                "VALUES('" . $mytime ."','" . $username . "'," .
                $glucose . "," . $carbs . "," . $insuline . ",'" .
                $insulinetype . "'," . $weight . "," . $diastolic . "," .
                $systolic . "," . $pulse . ");";
        $p = print_r("insertTimedHealthRecord Query:" . $query, true);
        error_log($p,0);
        try {
            $result = mysql_query($query, $this->connection);
            if (!$result) {
                die('Invalid query: ' . mysql_error());
            }
        } catch (Exception $ex) {
            $foo = print("SQL failed:" . $ex);
        }
    }

    /**
     *
     * @param type $par_username
     * @return HealthRecord array of HealthRecords
     */
    public function getHealthRecordsAll($par_username) {
        $query = "SELECT * FROM " . $this->dbConf->getRecordTableName() . " WHERE (Username = \"" . $par_username . "\") ORDER BY RecordTime ASC";

        try {
            $result = mysql_query($query, $this->connection);
        } catch (Exception $ex) {
            echo "getHealthRecordsAll failed:" . mysql_error();
        }

        $healthRecordArray;
        $hi = 0;

        while ($row = mysql_fetch_array($result)) {
            $newrec = new HealthRecord();
            $newrec->rectime = $row['RecordTime'];
            $newrec->username = $row['Username'];
            $newrec->glucose = $row['Glucose'];
            $newrec->carbs = $row['Carbs'];
            $newrec->insuline = $row['Insuline'];
            $newrec->insulinetype = $row['Insulinetype'];
            $newrec->weight = $row['Weight'];
            $newrec->diastolic = $row['Diastolic'];
            $newrec->systolic = $row['Systolic'];
            $newrec->pulse = $row['Pulse'];
            $healthRecordArray[$hi++] = $newrec;
        }

        return $healthRecordArray;
    }

    /**
     *
     * @param type $par_username
     * @return HealthRecord array of HealthRecords
     */
    public function getHealthRecordsAny() {
        $query = "SELECT * FROM " . $this->dbConf->getRecordTableName() . " ORDER BY 'RecordTime' ASC";

        try {
            $result = mysql_query($query, $this->connection);
        } catch (Exception $ex) {
            
        }

        $healthRecordArray;
        $hi = 0;

        while ($row = mysql_fetch_array($result)) {
            $newrec = new HealthRecord();
            $newrec->rectime = $row['RecordTime'];
            $newrec->username = $row['Username'];
            $newrec->glucose = $row['Glucose'];
            $newrec->carbs = $row['Carbs'];
            $newrec->insuline = $row['Insuline'];
            $newrec->insulinetype = $row['Insulinetype'];
            $newrec->weight = $row['Weight'];
            $newrec->diastolic = $row['Diastolic'];
            $newrec->systolic = $row['Systolic'];
            $newrec->pulse = $row['Pulse'];
            $healthRecordArray[$hi++] = $newrec;
        }

        return $healthRecordArray;
    }

    /**
     *
     * @param type $par_username
     * @return HealthRecord array of HealthRecords
     */
    public function getHealthRecordsBetweenDates($par_username, $par_from_date, $par_to_date) {
        $query = "SELECT * FROM " . $this->dbConf->getRecordTableName() .
                " WHERE (Username = '" . $par_username . "') AND (RecordTime >= '" .
                $par_from_date . "') AND (RecordTime <= '" . $par_to_date . "') ORDER BY RecordTime ASC";
        try {
            $result = mysql_query($query, $this->connection);
        } catch (Exception $ex) {
            
        }

        $healthRecordArray;
        $hi = 0;

        while ($row = mysql_fetch_array($result)) {
            $newrec = new HealthRecord();
            $newrec->rectime = $row['RecordTime'];
            $newrec->username = $row['Username'];
            $newrec->glucose = $row['Glucose'];
            $newrec->carbs = $row['Carbs'];
            $newrec->insuline = $row['Insuline'];
            $newrec->insulinetype = $row['Insulinetype'];
            $newrec->weight = $row['Weight'];
            $newrec->diastolic = $row['Diastolic'];
            $newrec->systolic = $row['Systolic'];
            $newrec->pulse = $row['Pulse'];
            $healthRecordArray[$hi++] = $newrec;
        }

        return $healthRecordArray;
    }

    public function getPassword($par_username) {
        $login = htmlspecialchars($par_username);
        
        $pwq = "SELECT Password FROM " . $this->dbConf->getDbClientTableName() .
                " WHERE (Username = '" . $par_username . "')";

        try {
            $result = mysql_query($pwq, $this->connection);
        } catch (Exception $ex) {
                print("getPassword exception:".$ex);
        }

        $row = mysql_fetch_array($result);
        $password = $row['Password'];
        
        return $password;
    }

    public function addUser($par_username, $par_password) {
        $username = htmlspecialchars($par_username);
        $password = htmlspecialchars($par_password);
        $query = "INSERT INTO " . $this->dbConf->getDbClientTableName() .
                "( Username, Password )" .
                "VALUES ('" . $username . "','" . $password . "');";
        try {
            $result = mysql_query($query, $this->connection);
        } catch (Exception $ex) {
            return FALSE;
        }

        return TRUE;
    }

}

?>
