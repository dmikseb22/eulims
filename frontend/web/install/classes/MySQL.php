<?php

include_once 'Dao.php';

class MySQL
{
    private $server="localhost";
    private $username='eulims';
    private $password='eulims';
    private $conn;
    private $dao;
    
    /**
     * 
     * @param String $database
     */
    function __construct($database) {		
        $this->dao = new Dao([
            'server'=>$this->server,
            'database'=>$database,
            'username'=>$this->username,
            'password'=>$this->password
        ]);
        $this->conn = $this->dao->openConnection();
    }
    /**
     * @Description Insert new record to table specified
     * @param string $tablename
     * @param Array $arrayval
     */
    public function insertRow($tablename, array $arrayval){
        if(is_array($arrayval)):
            try {
                $array_ks = array_keys($arrayval);
                $array_ks_1 = implode(", ", $array_ks);
                $i=0;
                foreach ($arrayval as $key => $value) {
                    $stmtVal[$i] = $value;
                    $stmtParam[$i] = ":".$key;
                    $i++;
                }
                $stmtParam_1 = implode(", ", $stmtParam);
                // prepare and bind
                $stmt = $this->conn->prepare("INSERT INTO $tablename ($array_ks_1) VALUES ($stmtParam_1)");
                foreach ($stmtParam as $key => $value) {
                    $stmt->bindParam($value,$stmtVal[$key]);
                }
                return $stmt->execute();
            } catch (Exception $e) {
                return null;
            }
        endif;
        return null;
    }
   /**
    * 
    * @param string $tablename
    * @param array $arrayval
    * @return type
    */
    public function deleteRow($tablename, array $arrayval){
        try {
            $i = 0;
            foreach ($arrayval as $key => $value) {
                $expression[$i] = $key."='".$value."'";
            }
            $expression = implode(" AND ", $expression);
            $stmt = $this->conn->prepare("DELETE FROM $tablename WHERE $expression");
            return $stmt->execute();
        } catch (Exception $e) {
            return null;
        }
    }
    /**
     * 
     * @param string $tablename Table to updated.
     * @param array $setvals the values to be updated
     * @param array $condition provide a way for filtering
     * @return type
     */
    public function updateRow($tablename, array $setvals, array $condition){
        try {
            $i = 0;
            foreach ($setvals as $key => $value) {
                $setExp[$i] = $key."='".$value."'";
                $i++;
            }
            $setExp = implode(", ", $setExp);
            $a = 0;
            foreach ($condition as $key => $value) {
                $setCondition[$a] = $key."='".$value."'";
                $a++;
            }
            $setCondition = implode(" AND ", $setCondition);
            $stmt = $this->conn->prepare("UPDATE $tablename SET $setExp WHERE $setCondition");
            return $stmt->execute();
        } catch (Exception $e) {
            return null;
        }
    }
    /**
     * 
     * @param string $tablename
     * @param array $arrayval
     * @return object
     */
    public function fetchAll($tablename, array $arrayval){
        try {
            $array_keys = implode(", ", $arrayval);
            $stmt = $this->conn->prepare("SELECT $array_keys FROM $tablename");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $result = $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    /**
     * Destroy and close Connection
     */
    public function Destroy(){
        $this->dao->closeConnection();
    }

}

?>