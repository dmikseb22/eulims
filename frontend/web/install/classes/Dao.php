<?php

class Dao
{
    private $server = "";
    private $user = "";
    private $pass = "";
    /**
     *
     * @var type 
     */
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    protected $con;
    /**
     * Pass the MySQL Credentials
     * @param Array $credentials
     */
    function __construct($credentials=[]) {		
	$this->server = "mysql:host=$credentials[server];dbname=$credentials[database]";
        $this->user = $credentials['username'];
        $this->pass = $credentials['password'];
    }	
    /**
     * Opening Connections
     * @return type
     */
    public function openConnection()
    {
        try 
        {      
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);  
            return $this->con;
        } 
        catch (PDOException $e) 
        { 
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }

    /**
     * Function for closing connection
     */
    public function closeConnection()
    {
        $this->con = null;
    }
}
?>