<? //requests POST and GET
///// Ultima atualização 07/03/2008 
///// Atualização de Segurança EscapeStrings

////--------------------------------------------------------------------------------------
	class Request {
		function Request() { $this->make(); }
		function make() {
			while (list($name, $value) = each($_GET)) {	$this->$name = $this->escapestrings($value);	}
			while (list($name, $value) = each($_POST)){	$this->$name = $this->escapestrings($value);	}
		}
		function get(){
		echo "class Request(){<br>";
		$arr = get_object_vars($this);
   		while (list($prop, $val) = each($arr)){	echo "...$prop = $val;<br>"; }
   		echo "}<br>";
		}
		function escapestrings($b) 
		{ 
			//se magic_quotes não estiver ativado, escapa a string 
			if (!get_magic_quotes_gpc()) 
			{ 
					return mysql_escape_string($b); // função nativa do php para escapar variáveis. 
			} else {  
					// caso contrario 
					return $b; // retorna a variável sem necessidade de escapar duas vezes 
    	} 
		} 
	}

////--------------------------------------------------------------------------------------

	class Execution {
		var $modulo = "inicio";
		var $funcao = "null";
		var $param  = array();
				
		function Execution() { $this->make(); }
		function make() {
			
			if(isset($_GET['exc'])){
			
				$this->aux = explode(".",$_GET['exc']);
				
					$this->modulo = ($this->valido(0))?$this->aux[0]:"null";
					$this->funcao = ($this->valido(1))?$this->aux[1]:"null";
					$cont = 0;
					for($i = 2; $i < count($this->aux); $i++) { 
						$this->param[$cont++] = ($this->valido($i))?$this->aux[$i]:"null";
					}
			}
		}
		function valido($i){
			if(isset($this->aux[$i]) && $this->aux[$i]!= "null") return true;
			else return false;
		}
		function get(){
		echo "class Execution(){<br>";
		$arr = get_object_vars($this);
			echo "...modulo = $this->modulo<br>";
			echo "...funcao = $this->funcao<br>";
			foreach($this->param as $id => $var){ echo "...param[$id] = $var<br>"; }
   		echo "}<br>";
		}
	}
?>