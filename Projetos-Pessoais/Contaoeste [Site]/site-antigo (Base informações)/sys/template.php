<?php

class Template {
	var $nameTemplate;
	var $contentTemplate;

	function Template($file, $nt) {
		$this->nameTemplate = $nt;
		$this->contentTemplate = $file;
		$this->contentTemplate = $this->getContentTemplate();	
	}
	
	function getContentTemplate() {
		$tmp1 = "<!--tpl:".$this->nameTemplate."-->";
		$tmp2 = "<!--/tpl:".$this->nameTemplate."-->";	
		// no php5 tem o stripos que nao tem problemas de maiusculas e minusculas	
		$pos1 = strpos($this->contentTemplate, $tmp1) + strlen($tmp1);
		$pos2 = strpos($this->contentTemplate, $tmp2) -1;
		$str = substr($this->contentTemplate, $pos1, $pos2 - $pos1);
		return $str;
	}
	
	function assignVar($varName, $varValue) {
		$tmp = str_replace ("{".$varName."}", $varValue, $this->contentTemplate);
		$this->contentTemplate = $tmp;
	}
	
	function assignInclude($incName, $incFile) {
		$file = fopen ($incFile, "r");
		$result = fread ($file, filesize($incFile));
		fclose ($file);
		$tmp = str_replace ("<!--inc:".$incName."-->", $result, $this->contentTemplate);
		$this->contentTemplate = $tmp;
	}
	
	function assignText($txt, $str) {
		$tpm = "<!--txt:".$txt."-->";
		$tmp2 = str_replace($tpm, $str, $this->contentTemplate);
		$this->contentTemplate = $tmp2;
	}
		
	function assignTemplate($nt, $str) {
		$tmp1 = "<!--tpl:".$nt."-->";
		$tmp2 = "<!--/tpl:".$nt."-->";	
		// no php5 tem o stripos que nao tem problemas de maiusculas e minusculas	
		$pos1 = strpos($this->contentTemplate, $tmp1) -1;
		$pos2 = strpos($this->contentTemplate, $tmp2) + strlen($tmp1) +1;
		
		$vt = substr($this->contentTemplate, 0, $pos1);
		$vt .= $str;
		$vt .= substr($this->contentTemplate, $pos2, strlen($this->contentTemplate));
		$this->contentTemplate = $vt;
	}
	
	function getTemplate() {
		$tmp = $this->contentTemplate;
		return $tmp;
	}
	
	function show() {
		echo $this->contentTemplate;
	}
}

class FileTemplate {
	var $content;

	function FileTemplate($nf) {
		// Le o arquivo do template
		$file = fopen ($nf, "r");
		$this->content = fread ($file, filesize($nf));
		fclose ($file);
	}
	
	function get() {
		$tmp = $this->content;
		return $tmp;
	}
}


?>