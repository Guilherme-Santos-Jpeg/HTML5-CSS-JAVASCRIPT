// JavaScript Document

$(document).ready(function(){
						   
$.init_slide('imgstore','chamada',0,0,100000,1,3000,1);				

//Ativando o jQuery lightBox (ampliar imagem) plugin ///////////////////////////////////////

//mascaras de formulários ///////////////////////////////////////
$(function() {
	$('.data').mask('99/99/9999');
	$('#fdt_nascimento').mask('99/99/9999');
	$('.cep').mask('99999-999');
	$('.cpf').mask('999.999.999-99');
	$('#fcpf').mask('999.999.999-99');
	$('.cnpj').mask('999.999.999/9999-99');
	$('.fone').mask('(99)9999-9999');
	$('#ftelefone01').mask('(99)9999-9999');
	$('#ftelefone02').mask('(99)9999-9999');
});

/////////////////////////////////////////////////////////////////

//valida formulários #contato ///////////////////////////////////////
$("#contato").bind("submit", function() 
		{
		if($.trim($("#cnome").val()) == ""){
				alert("Preencha o Campo Nome");
				$("#cnome").css({ background: "DarkGray"});
				$("#cnome").focus();
				return false;
		}
		if($.trim($("#telefone").val()) == "")
		{
				alert("Preencha o Campo Telefone");
				$("#telefone").css({ background: "DarkGray"});
				$("#telefone").focus();
				return false;
		}
		if($.trim($("#cemail").val()) == ""){
				alert("Preencha o Campo E-mail");
				$("#cemail").css({ background: "DarkGray"});
				$("#cemail").focus();
				return false;
		}
		if($.trim($("#cidade").val()) == ""){
				alert("Preencha o Campo Cidade");
				$("#cidade").css({ background: "DarkGray"});
				$("#cidade").focus();
				return false;
		}
		if($.trim($("#mensagem").val()) == ""){
				alert("Preencha o CampoMensagem");
				$("#mensagem").css({ background: "DarkGray"});
				$("#mensagem").focus();
				return false;
		}
		
	 });

$("#fcandidato").bind("submit", function() 
		{
		if($.trim($("#fnome").val()) == ""){
				alert("Preencha o Campo Nome");
				$("#fnome").css({ background: "DarkGray"});
				$("#fnome").focus();
				return false;
		}
		if($.trim($("#fdt_nascimento").val()) == "")
		{
			alert("Preencha o campo Data Nascimento");
			$("#fdt_nascimento").css({ background: "DarkGray"});
			$("#fdt_nascimento").focus();
			return false;
		}
		if($.trim($("#femail").val()) == ""){
			alert("Preencha o campo Email");
			$("#femail").css({ background: "DarkGray"});
			$("#femail").focus();
			return false;
		}
		if($.trim($("#ffiliacao").val()) == ""){
			alert("Preencha o campo Filiação");
			$("#ffiliacao").css({ background: "DarkGray"});
			$("#ffiliacao").focus();
			return false;
		}
		if($.trim($("#fest_civil").val()) == ""){
			alert("Preencha o campo Estado Civil");
			$("#fest_civil").css({ background: "DarkGray"});
			$("#fest_civil").focus();
			return false;
		}
		if($.trim($("#fendereco").val()) == ""){
			alert("Preencha o campo Endereço");
			$("#fendereco").css({ background: "whitesmoke"});
			$("#fendereco").focus();
			return false;
		}
		if($.trim($("#fbairro").val()) == ""){
			alert("Preencha o campo Bairro");
			$("#fbairro").css({ background: "DarkGray"});
			$("#fbairro").focus();
			return false;
		}
		if($.trim($("#fcidade").val()) == ""){
			alert("Preencha o campo Cidade");
			$("#fcidade").css({ background: "DarkGray"});
			$("#fcidade").focus();
			return false;
		}
		if($.trim($("#ftelefone01").val()) == ""){
			alert("Preencha o campo Telefone");
			$("#ftelefone01").css({ background: "whitesmoke"});
			$("#ftelefone01").focus();
			return false;
		}

		if($.trim($("#frg").val()) == 0){
			alert("Preencha o campo RG");
			$("#frg").css({ background: "DarkGray"});
			$("#frg").focus();
			return false;
		}
		if($.trim($("#fcpf").val()) == 0){
			alert("Preencha o campo CPF");
			$("#fcpf").css({ background: "whitesmoke"});
			$("#fcpf").focus();
			return false;
		}
		if($.trim($("#fcnh").val()) == 0){
			alert("Preencha o campo CNH");
			$("#fcnh").css({ background: "DarkGray"});
			$("#fcnh").focus();
			return false;
		}
		if($.trim($("#finstrucao").val()) == 0){
			alert("Preencha o campo Instrução");
			$("#finstrucao").css({ background: "DarkGray"});
			$("#finstrucao").focus();
			return false;
		}
		if($.trim($("#fexperiencia").val()) == 0){
			alert("Preencha o campo Experiência");
			$("#fexperiencia").css({ background: "DarkGray"});
			$("#fexperiencia").focus();
			return false;
		}
		if($.trim($("#finformacoes").val()) == 0){
			alert("Preencha o campo Informações");
			$("#finformacoes").css({ background: "DarkGray"});
			$("#finformacoes").focus();
			return false;
		}
		
	 });


});