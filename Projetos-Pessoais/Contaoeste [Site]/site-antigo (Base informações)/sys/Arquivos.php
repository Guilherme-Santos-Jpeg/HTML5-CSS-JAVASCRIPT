<?

	class Arquivos
	{
		var $file = false;
		var $ext  = false;
		var $size = 0;
		var $name = false;
		var $temp = false;
		
		function Arquivos($name)
		{
			$this->file = $_FILES[$name];
			$this->name = $this->file['name'];
			$this->temp = $this->file['tmp_name'];
			$this->ext  = end(explode(".",$this->name));
			$this->size = filesize($this->temp);
		}
		function getSize()
		{
			return $this->size;
			
		}
		function getExtensao()
		{	
			return $this->ext;
		}
		function getNome()
		{
			return $this->name;
		}
		
		function copyTo($diretorio,$nome)
		{
			global $WINDIR; // var global para ambientes win
				
			$alvo = $diretorio.$nome.".".$this->ext;
			
			if(isset($WINDIR))	// caso seja ambiente win..
			{
				$temp = str_replace("\\\\","\\", $this->temp); // .. substitui o \\ por \ se ouver algum
			}
			if(is_file($alvo)) // caso já existir este arquivo ..
			{
				unlink($alvo); // .. exclua o antigo
			}
			$copiar = @copy($this->temp,$alvo); // executa a cópia
			if(!$copiar) // deu erro?
			{
				return false;
			} 
			else if(!isset($WINDIR) && !@unlink($this->temp)) // caso não for win e não exitir um temporário para copiar
			{
				return false;
			}
			else // senão tudo funcionou, retorne true
			{
				return true;
			}
		}
		
		function getConteudo()
		{			
			$content = false; 
			if(is_file($this->temp))
			{
				$file = fopen ($this->temp, "rb");
				$content = addslashes(fread ($file, $this->size));
				fclose ($file);
			}
			return $content;
		}
		
	}







?>