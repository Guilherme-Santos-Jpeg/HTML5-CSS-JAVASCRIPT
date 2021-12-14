<?
include_once("sys/template.php");
include_once("sys/request.php");
include_once("configuration.inc.php");
include_once("../model/arq.arquivo.class.php");
include_once("../kernel/email.class.php");
$get = new Request();
$exc = new Execution();

class Index{

	var $ftemplate = "principal.htm";
	var $conteudo;
	var $ft;
	
	function Index(){
		$ft = new FileTemplate($this->ftemplate);
		$this->ft = $ft->get();
		$this->conteudo = new Template($this->ft,"conteudo");
		$this->conteudo->assignTemplate("head",$this->makeHead());
		$this->conteudo->assignTemplate("body",$this->makeBody());
	}
	
	function show(){
		$this->conteudo->show();
	}
	
/** # Head Escopo **********************************/	
	function makeHead(){

		$head = new Template($this->ft,"head");
		$head->assignVar("title","Contaoeste 2009 - Chapecó - SC");
		$head->assignVar("description","Contaoeste - Chapecó - SC");
		$head->assignVar("keywords","Contaoeste, chapecó, sc, contadores");
		$head->assignVar("author","Bazzi.Com  -  http://www.bazzi.com.br");
		$head->assignVar("revisit-after","1 day");
		$head->assignVar("reply-to","solucoes@bazzi.com.br");
		$head->assignVar("copyright","Contaoeste 2009");
		$head->assignVar("robots","all");
		$head->assignVar("favicon-image","imgs/icon.png" );

		$javascript_files = array(
									"jquery-1.2.6.min",
									"jquery.lightbox-0.5",
									"jquery.myslide",
									"functions",
									"jquery.maskedinput-1.2.2.min",
									"jquery",
									"jquery-1.2.2",
									"jquery.popin.pack"
								);
		$head->assignTemplate("text_javascript",$this->makeHeadListFiles($javascript_files,"text_javascript"));

		return $head->getTemplate();
	}
	function makeHeadListFiles($list, $template){
		$text = "";
		foreach($list as $file){
			$tplText = new Template($this->ft,$template);
			$tplText->assignVar("file",$file);
			$text.=$tplText->getTemplate();
		}
		return $text;
	}
	
/** # Body Escopo **********************************/
	function makeBody(){
		global $exc;
		$body = new Template($this->ft,"body");
		$int = "internos_".$exc->modulo;		
		$internos = new Template($this->ft,$int);	
		$body->assignTemplate("internos",$internos->getTemplate());	
		
		
		$lateral = new Template($this->ft,"internos_lateral");
		$menuitem = array("class_sobrenos"=>"","class_curriculo"=>"","class_servicos"=>"","class_links"=>"","class_noticias"=>"","class_oportunidades"=>"","class_contato"=>"","class_inicio"=>"");
		$menuitem['class_'.$exc->modulo] = "ativo";
		foreach($menuitem as $id => $mi){
			$body->assignVar($id,$mi);
		}
		$this->func = $exc->funcao=='null'?'visaogeral':$exc->funcao;
		$internos_sub = new Template($this->ft,$exc->modulo."_internos_".$this->func);
		$body->assignTemplate($exc->modulo.'_internos',$internos_sub->getTemplate());
		$menuitens = "";
		
		switch($exc->modulo){
		
			case "sobrenos":			
			
				$body->assignVar('lateral',$lateral->getTemplate());
			
			break;
			
			case "servicos":
			
				$body->assignVar('lateral',$lateral->getTemplate());
						
			break;
			
			case "oportunidades":	
				
				switch ($exc->funcao){
				
					case "ver":
						include_once("../model/vag.vaga.class.php");
						$Obj = new VagVaga();
						$Obj->setCodigo($exc->param[0]);			
						$Obj->load();
						$body->assignVar("nome", $Obj->getNome());
						$body->assignVar("data",$Obj->getDataFormatada());
						$body->assignVar("descricao", $Obj->getConteudoSite());	
						$body->assignVar('lateral',$lateral->getTemplate());
					break;
					
					case "visaogeral":
					default:
						include_once("../model/vag.vaga.class.php");
						$listaOportunidades="";
						$Oportunidades = new VagVagaFactory();
						$Oportunidades->select("publicado=1");
						while($Oportunidade = $Oportunidades->getNext()){
							$tplLinha = new Template($this->ft,"listaOportunidades");
							$tplLinha->assignVar("data",$Oportunidade->getDataFormatada());
							$tplLinha->assignVar("nome",$Oportunidade->getNome());
							$tplLinha->assignVar("codigo",$Oportunidade->getCodigo());
							$listaOportunidades.=$tplLinha->getTemplate();
						}
						$body->assignTemplate('listaOportunidades',$listaOportunidades==""?"<li>Não existe nenhuma Oportunidade cadastrada no momento.</li>":$listaOportunidades);		
						$body->assignVar('lateral',$lateral->getTemplate());
					break;
					
					case "curriculo":
						$body->assignVar('lateral',$lateral->getTemplate());
					break;
					
					case "enviaCur":
						
						include_once("../model/cur.curriculo.class.php");	
						
						$Cur = new  CurCurriculo();
						
						$Cur->setNome($_POST['fnome']);
						
						$aux = $_POST['fdt_nascimento'];
						if(strstr($_POST['fdt_nascimento'],'/')) { 
							$aux = explode('/',$_POST['fdt_nascimento']);
							$aux = $aux[2].'-'.$aux[1].'-'.$aux[0];				
						}
						
						$Cur->setDt_nascimento($aux);
						$Cur->setEmail($_POST['femail']);
						$Cur->setFiliacao($_POST['ffiliacao']);
						$Cur->setEstado_civil($_POST['fest_civil']);
						$Cur->setEndereco($_POST['fendereco']);
						$Cur->setBairro($_POST['fbairro']);
						$Cur->setCidade($_POST['fcidade']);
						$Cur->setTelefone01($_POST['ftelefone01']);
						$Cur->setTelefone02($_POST['ftelefone02']);
						$Cur->setRg($_POST['frg']);
						$Cur->setCpf($_POST['fcpf']);
						$Cur->setCnh($_POST['fcnh']);
						$Cur->setGrau_instrucao($_POST['finstrucao']);
						$Cur->setExperiencia($_POST['fexperiencia']);
						$Cur->setInformacao($_POST['finformacoes']);
						//$Cur->setInteresse($_POST["interesse"]);
						$interesse = "";  
						foreach($_POST["interesse"] as $i){ 
							$interesse.=$i.", ";
						}
						$Cur->setInteresse($interesse);
						//echo $interesse;			
						
						print_r ($Post);
						
						include_once("../kernel/arquivo.class.php");
						$arquivo = new Arquivo("fcurriculo");
						
						if($Cur->save()){
							$Cur->load();
							if ($arquivo->getSize()>0){
								$arquivo->copyTo("../../curriculos/",$Cur->getCodigo());
								$Cur->setAnexo($arquivo->getExtensao());
								$Cur->save();
							}	
						$body->assignVar("mensagem","Curriculo  Enviado com Sucesso.");
						} else {
							$body->assignVar("mensagem", "Não foi possivel enviar sua mensagem. Favor tentar novamente.");
						}
						$body->assignVar('lateral',$lateral->getTemplate());
						break;	
						
					}	
					$body->assignVar('lateral',$lateral->getTemplate());
					
			break;
			
			case "noticias":
				
				$titulo = "";
				$listaNoticias="";	
				//switch ($exc->funcao){
				
				switch($exc->funcao){
					case "visaogeral":

						$titulo = "Escolha uma categoria";
						//mostra relação de categorias
						include_once("../model/not.categoria.class.php");
						$NoticiasCat = new NotCategoriaFactory();
						$NoticiasCat->select();
						while($Categoria = $NoticiasCat->getNext()){
							$tplLinha = new Template($this->ft,"listaNoticias");
							$tplLinha->assignVar("nome",$Categoria->getNome());
							$tplLinha->assignVar("url","index.php?exc=noticias.categoria.".$Categoria->getCodigo());
							$listaNoticias.=$tplLinha->getTemplate();
						}						
						//Categoria do Notícia
						$body->assignTemplate('listaNoticias',$listaNoticias==""?"Não existe nenhum item cadastrado no momento.":$listaNoticias);
						$body->assignVar('lateral',$lateral->getTemplate());
						$body->assignVar('titulo',$titulo);
					
					break;
				
					case "categoria":
						//mostra noticias da categoria exc função
						include_once("../model/not.categoria.class.php");
						$NoticiasCat = new NotCategoria();
						$NoticiasCat->setCodigo($exc->param[0]);
						$NoticiasCat->load();
						include_once("../model/not.noticia.class.php");
						$Noticias = new NotNoticiaFactory();
						$titulo = "Notícias da Categoria ".$NoticiasCat->getNome();
						$Noticias->select("publicado=1 AND not_categoria=".$NoticiasCat->getCodigo());
						while($Noticia = $Noticias->getNext()){
							$tplLinha = new Template($this->ft,"listaNoticias");
							$tplLinha->assignVar("nome",$Noticia->getNome());
							$tplLinha->assignVar("url","index.php?exc=noticias.ver.".$Noticia->getCodigo());
							$listaNoticias.=$tplLinha->getTemplate();
						}
						
						//Categoria do Notícia
						$body->assignTemplate('listaNoticias',$listaNoticias==""?"Não existe nenhum item cadastrado no momento.":$listaNoticias);
						$body->assignVar('lateral',$lateral->getTemplate());
						$body->assignVar('titulo',$titulo);
					
					break;
						    
					case "ver":	
						
						//conteudo da noticia ver
						include_once("../model/not.noticia.class.php");
						$Obj = new NotNoticia();
						$Obj->setCodigo($exc->param[0]);
						$Obj->load();
						$body->assignVar("nome", $Obj->getNome());
						$body->assignVar("codigo","index.php?exc=noticias.categoria.".$Obj->getNot_categoria()->getCodigo());
						$body->assignVar("data",$Obj->getDataFormatada());
						$body->assignVar("descricao", $Obj->getConteudoSite());	
						$body->assignVar('lateral',$lateral->getTemplate());
					break;	
				}
				
				include_once("../model/not.categoria.class.php");
				$NoticiasCat = new NotCategoriaFactory();
				$NoticiasCat->select();
				while($Categoria = $NoticiasCat->getNext()){
					$tplLinha = new Template($this->ft,"listaCats");
					$tplLinha->assignVar("categoria",$Categoria->getNome());
					$tplLinha->assignVar("url","index.php?exc=noticias.categoria.".$Categoria->getCodigo());
					$listaCats.=$tplLinha->getTemplate();
				}
				$body->assignTemplate('listaCats',$listaCats==""?"Não existe nenhum item cadastrado no momento.":$listaCats);	
				
			break;
			
			case "links":
				
				$titulo = "";
				$listaLinks="";	
				if ($exc->funcao == "visaogeral")
				{
					
					$titulo = "Escolha uma categoria";
					//mostra relação de categorias
					include_once("../model/lin.categoria.class.php");
					$LinksCat = new LinCategoriaFactory();
					$LinksCat->select();
					while($Categoria = $LinksCat->getNext()){
						$tplLinha = new Template($this->ft,"listaLinks");
						$tplLinha->assignVar("link",$Categoria->getNome());
						$tplLinha->assignVar("url","index.php?exc=links.categoria.".$Categoria->getCodigo());
						$listaLinks.=$tplLinha->getTemplate();
					}
				}else{
					//mostra links da categoria exc função
					include_once("../model/lin.categoria.class.php");
					$LinksCat = new LinCategoria();
					$LinksCat->setCodigo($exc->param[0]);
					$LinksCat->load();
					include_once("../model/lin.link.class.php");
					$Links = new LinLinkFactory();
					$titulo = "Links da Categoria ".$LinksCat->getNome();
					$Links->select("publicado=1 AND lin_categoria=".$LinksCat->getCodigo());
					while($Link = $Links->getNext()){
						$tplLinha = new Template($this->ft,"listaLinks");
						$tplLinha->assignVar("link",$Link->getNome());
						$tplLinha->assignVar("url",$Link->getManchete());
						$listaLinks.=$tplLinha->getTemplate();
					}
				}
				//Categoria do Link
				echo  $listaCats;
				$body->assignTemplate('listaLinks',$listaLinks==""?"Não existe nenhum item cadastrado no momento.":$listaLinks);
				$body->assignVar('lateral',$lateral->getTemplate());
				$body->assignVar('titulo',$titulo);	
				
				include_once("../model/lin.categoria.class.php");
				$LinksCat = new LinCategoriaFactory();
				$LinksCat->select();
				while($Categoria = $LinksCat->getNext()){
					$tplLinha = new Template($this->ft,"listaCats");
					$tplLinha->assignVar("categoria",$Categoria->getNome());
					$tplLinha->assignVar("url","index.php?exc=links.categoria.".$Categoria->getCodigo());
					$listaCats.=$tplLinha->getTemplate();
				}
				$body->assignTemplate('listaCats',$listaCats==""?"Não existe nenhum item cadastrado no momento.":$listaCats);
				
			break;
			
			case "contato":				
				
				$body->assignVar('lateral',$lateral->getTemplate());
				
				switch ($exc->funcao){
				
						case "envia": 	//envia Contato por e-mail					
							$conteudo.= "Nome: ".$_POST['cnome']."<br />";				
							$conteudo.= "Telefone: ".$_POST['telefone']."<br />";	
							$conteudo.= "E-mail: ".$_POST['cemail']."<br />";
							$conteudo.= "Cidade: ".$_POST['cidade']."<br />";				
							$conteudo.= "Mensagem: ".$_POST['mensagem']."<br />";	
							
							$subject  = "[Contaoeste] Contato do Site";							
							
							$Email = new Email();
							$Email->para('informatica','informatica@contaoeste.com.br');
													
							$Email->mensagem($subject,$conteudo);			
							
							if($Email->enviar()){
								$body->assignVar("mensagem","Mensagem  Enviada com Sucesso. Aguarde nosso contato.");
							} else {
								$body->assignVar("mensagem", "Não foi possivel enviar sua mensagem. Favor tentar novamente.");
							}
							$body->assignVar('lateral',$lateral->getTemplate());
						
					 break;
					 
					case "localizacao":					 
						$menuitens = "localizacao";						
					break;
					
					$body->assignVar('lateral',$lateral->getTemplate());
					}		
				break;
			
			default:
			
				//------frente lista noticias =========================================================================================
				include_once("../model/not.noticia.class.php");
				$Noticias = new NotNoticiaFactory(); 
				$Noticias->select("destaque=1","dt_criacao DESC LIMIT 4");				
				$listaNoticiasFrente="";
				while($Noticia = $Noticias->getNext()){
					$tplItem = new Template($this->ft, 'listaNoticiasFrente');
					$tplItem->assignVar('nome',$Noticia->getNome());
					$tplItem->assignVar('categoria',$Noticia->getNot_categoria()->getNome());
					$tplItem->assignVar('data',$Noticia->getDataFormatada());
					$tplItem->assignVar('codigo',$Noticia->getCodigo());
					$listaNoticiasFrente.=$tplItem->getTemplate();
				}
				$body->assignTemplate('listaNoticiasFrente',$listaNoticiasFrente==""?"Não há nenhuma notícia cadastrada no momento.":$listaNoticiasFrente);	
				
				//------frente lista links =========================================================================================
				include_once("../model/lin.link.class.php");
				$Links = new LinLinkFactory(); 
				$Links->select("destaque=1","nome ASC LIMIT 5");				
				$listaLinksFrente="";
				while($Link = $Links->getNext()){
					$tplItem = new Template($this->ft, 'listaLinksFrente');
					$tplItem->assignVar('link',$Link->getNome());
					$tplItem->assignVar('categoria',$Link->getLin_categoria());
					$tplItem->assignVar("url",$Link->getManchete());
					$tplItem->assignVar('codigo',$Link->getCodigo());
					$listaLinksFrente.=$tplItem->getTemplate();
				}
				$body->assignTemplate('listaLinksFrente',$listaLinksFrente==""?"Não há nenhum link cadastrado no momento.":$listaLinksFrente);	

				//------frente lista vagas =========================================================================================
				include_once("../model/vag.vaga.class.php");
				$Vagas = new VagVagaFactory(); 
				$Vagas->select("publicado=1","dt_criacao DESC LIMIT 4");
				$listaOportunidadesFrente="";
				while($Vaga = $Vagas->getNext()){
					$tplItem2 = new Template($this->ft, 'listaOportunidadesFrente');
					$tplItem2->assignVar('nome',$Vaga->getNome());
					$tplItem2->assignVar('data',$Vaga->getDataFormatada());
					$tplItem2->assignVar('codigo',$Vaga->getCodigo());
					$listaOportunidadesFrente.=$tplItem2->getTemplate();
				}
				$body->assignTemplate('listaOportunidadesFrente',$listaOportunidadesFrente==""?"<li>Não há nenhuma oportunidade cadastrada no momento.</li>":$listaOportunidadesFrente);	
				
				// Cadastro de E-mail por Newsletter
				include_once("../model/not.email.class.php");
				$scriptNews="";
				$retorno="";
				if (isset($_POST['botao']) && $_POST['botao']=="Cadastrar"){
					$mensagem="";
					$naofaz=1;
					if($_POST['news_nome'] =="") $naofaz=2; else $nome  = $_POST['news_nome'];
					if($_POST['news_email']=="") $naofaz=2; else $email = $_POST['news_email'];	
					
					if($_POST['news_nome'] =="Digite seu nome") $naofaz=2; else $nome  = $_POST['news_nome'];
					if($_POST['news_email']=="Digite seu e-mail") $naofaz=2; else $email = $_POST['news_email'];					
				
					$retorno= "<script><!--\n";
					//verificando se já existe email
					$Emails = new NotEmailFactory();
					$Emails->select("1=1");
					while($Email = $Emails->getNext()){
						if( $Email->getEmail() == $email){
							$retorno.= "alert('Não foi possível efetuar o cadastro. Esse e-mail já está cadastrado!');\n";
								$naofaz=0;
						}
					}
					if($naofaz==1){				
						$Email = new NotEmail();
						$Email->setCodigo($codigo);
						$Email->setNome($nome);
						$Email->setEmail($email);
						if($Email->save())
							$retorno.= "alert('Cadastro efetuado com sucesso!');\n";
						else 
							$retorno.= "alert('Não foi possível efetuar o cadastro. Tente novamente mais tarde!');\n";
					}		
					if($naofaz==2){
						$retorno.= "alert('Não foi possível efetuar o cadastro. Tente novamente mais tarde!');\n";
					}										
					$retorno.= "--></script>";
					//Fim Cadastrando nome e e-mail para newsletter 
				}
				$body->assignVar('scriptNews',$retorno);
				
			break;
		}
		$this->montaMenu($menuitens,$body);		
		return $body->getTemplate();
	}
/** #End Index **/
	private function montaMenu($itens,&$tpl)
	{
		global $exc;
		$a = explode(",",$itens);
		$b['visaogeral'] = "";
		foreach($a as $val){ $b[$val]=""; }
		$b['sub_'.$this->func] = "ativo";			
		foreach($b as $id => $mi){ $tpl->assignVar($id,$mi); }
	}
}
$index = new Index();
$index->show();

?>