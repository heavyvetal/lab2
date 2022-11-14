<?php

abstract class DataBase {

    public $dbcon;
    public $localhost = "localhost";
    public $login = "root";
    public $password = "";
    public $namedb = "photo";

    function __construct($localhost, $login, $password, $namedb){
        $this->localhost = $localhost;
        $this->login = $login;
        $this->password = $password;
        $this->namedb = $namedb;
    }
}

class Sql extends DataBase {

    function __construct($localhost, $login, $password, $namedb){
        parent::__construct($localhost, $login, $password, $namedb);
    }

	//Set
	function set(){
		$numargums = func_num_args();
		if ($numargums == 4) {
			$this->localhost = func_get_arg(0);
			$this->login = func_get_arg(1);
			$this->password = func_get_arg(2);
			$this->namedb = func_get_arg(3);
		}
	}
	
	//Show
	function show(){
		echo $this->localhost;
		echo $this->login;
		echo $this->password;
		echo $this->namedb; 
	}
	
	//Connect
	function connect(){
		$this->dbcon = mysql_connect($this->localhost, $this->login, $this->password) or die ("Невозможно законнектиться к базе".mysql_error());
		$select = mysql_select_db($this->namedb,$this->dbcon) or die ("Невозможно найти базу".mysql_error());
	}
	
	//Query
	function query($query){
		$mysql = mysql_query($query) or die ("Невозможно выполнить запрос".mysql_error());
		return $mysql;
	}
	
	//Select
	function select($query){
		$mysql = mysql_query($query,$this->dbcon) or die ("Невозможно выполнить запрос".mysql_error());
		return mysql_fetch_array($mysql, MYSQL_ASSOC); 
	}
	
	//Close
	function close(){
		mysql_close($this->dbcon);
	}
}


class Sqli extends DataBase{

	function __construct($localhost, $login, $password, $namedb){
		parent::__construct($localhost, $login, $password, $namedb); 
	}

    //Show
    function show(){
        echo $this->localhost;
        echo $this->login;
        echo $this->password;
        echo $this->namedb;
    }
	
	//Connect
	function connect(){
		$this->dbcon = new mysqli($this->localhost, $this->login, $this->password, $this->namedb);
		if ($this->dbcon->connect_errno) {
			echo "Не удалось подключиться к MySQL: (" . $this->dbcon->connect_errno . ") " . $this->dbcon->connect_error;
		}
	}
	
	//Query
	function query($query){
		$result = $this->dbcon->query($query);
		return $result;
	}
	
	//Select
	function select($query){
		$result = $this->dbcon->query($query);
		$row = $result->fetch_assoc();;
		return $row;
	}
	
	//Close
	function close(){
		$this->dbcon->close();
	}
}
?>