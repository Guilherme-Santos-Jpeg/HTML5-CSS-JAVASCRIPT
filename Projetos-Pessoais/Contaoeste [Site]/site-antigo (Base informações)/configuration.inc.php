<?
	include_once("../kernel/database.mysql.class.php");
	include_once("../kernel/configuration.class.php");
	
	$Config = new Configuration();
	
	//$Config->configDB("localhost","root","","contaoeste_site");
	$Config->configDB("mysql02.contaoeste.com.br","contaoeste2","c0nt40este","contaoeste2");
	
	$Config->setKeyFrase("C3NTR0F3D3R4LD33DUC4C40T3CN0L0G1C4D354NT4C4T4R1N4");
	
	$Banco = new MyDatabase($Config->getDbHost(),$Config->getDbName(),$Config->getDbUser(),$Config->getDbPassword());
	$Banco->connect();

?>
