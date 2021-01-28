<?php 
error_reporting(1);
session_start();
date_default_timezone_set("Asia/Kolkata");
define('baseurl','https://chitfinder.com/magnificit/');
class DB {
    private $conn_db;
    function __construct() 
    {
        $host="db5001417858.hosting-data.io";
        $user="dbu1152178";
        $password="6sQ?kF5D";
        $db="dbs1196187";
        $this->conn_db = mysqli_connect($host, $user, $password, $db);
        try 
        {
            if($this->conn_db) 
            {
                return $this->conn_db;
            } 
            else 
            {
                throw new Exception('Unable to connect');
            }
        } 
        catch (Exception $e) 
        {
            echo $e->getMessage();
        }
    }

//execute query and returns data as multi deimentional array
    function executeQuery($sql) {
        $result = array();
        if($sql!=''){
        try {
            $sql_qry = mysqli_query($this->conn_db, $sql);
            if ($sql_qry) {
                if (mysqli_num_rows($sql_qry) > 0) {
                    $i = 0;
                    while ($row_res = mysqli_fetch_assoc($sql_qry)) {
                        $result[$i] = $row_res;
                        $i++;
                    }

                    return $result;
                }
            } else {
                throw new Exception(mysqli_error($this->conn_db));
                $this->wh_log(mysqli_error($this->conn_db));
            }
        } catch (Exception $e) {
            $this->wh_log($e->getMessage());
        }
    }
    }

    //execute query and returns data as rows
    function getrows_executeQuery($sql) {
 if($sql!=''){
        try {
            $sql_qry = mysqli_query($this->conn_db, $sql);
            if ($sql_qry) {
                return $sql_qry;
            } else {
                throw new Exception(mysqli_error($this->conn_db));
                $this->wh_log(mysqli_error($this->conn_db));
            }
        } catch (Exception $e) {
            $this->wh_log($e->getMessage());
        }
 }
    }

//execute query and returns last inserted id
    function getinsertidQuery($sql) {
         if($sql!=''){
        try {
            $sql_qry = mysqli_query($this->conn_db, $sql);
            if ($sql_qry) {
                $last_insertid = mysqli_insert_id($this->conn_db);
                return $last_insertid;
            } else {
                return FALSE;
                throw new Exception(mysqli_error($this->conn_db));
                $this->wh_log(mysqli_error($this->conn_db));
            }
        } catch (Exception $e) {
            $this->wh_log($e->getMessage());
        }
         }
    }

    //execute query and returns last inserted id
    function boolean_executeQuery($sql) {
         if($sql!=''){
        try {
            $sql_qry = mysqli_query($this->conn_db, $sql);
            if ($sql_qry) {
                return true;
            } else {
                return false;
                throw new Exception(mysqli_error($this->conn_db));
                $this->wh_log(mysqli_error($this->conn_db));
            }
        } catch (Exception $e) {
            $this->wh_log($e->getMessage());
        }
         }
    }

//generates logs while mysql execution errors
    public function wh_log($log_msg) {
        $log_filename = $_SERVER['DOCUMENT_ROOT'] . "/log";
        if (!file_exists($log_filename)) {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
        file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
    }

}
