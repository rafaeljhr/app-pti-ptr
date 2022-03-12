"use strict";

window.addEventListener("load", principal);

var pesquisa_intervalo;

function principal() {
	defineEventHandlersParaElementosHTML();
	
	pesquisa_intervalo = setInterval(pesquisa, 100);
	
	if(document.getElementById('Procura_Vol').checked) {
		CheckVol();
	}
	else if(document.getElementById('Procura_Inst').checked){
		CheckInst();
	}
	else{
		CheckAcao();
	}
}

function defineEventHandlersParaElementosHTML() {
	document.getElementById("Procura_Vol").addEventListener("click", CheckVol);
	document.getElementById("Procura_Inst").addEventListener("click", CheckInst);
	document.getElementById("Procura_Acao").addEventListener("click", CheckAcao);
	document.getElementById("inlineRadio1").addEventListener("click", EnableInput);
	document.getElementById("inlineRadio2").addEventListener("click", EnableInput);
	document.getElementById("inlineRadio3").addEventListener("click", EnableInput);
	document.getElementById("inlineRadio4").addEventListener("click", EnableInput);
	document.getElementById("inlineRadio5").addEventListener("click", DisableInput);
}

function CheckVol(){
	document.getElementById("Form_Faixa_Etaria").style.display = "block";
	document.getElementById("acao_atividade").style.display = "none";
	
}

function CheckInst(){
	
	if (document.getElementById("inlineRadio5").checked == true){
		
		document.getElementById("inlineRadio5").checked = false;
		document.getElementById("inlineRadio1").checked = true;
		EnableInput()
	}
	document.getElementById("Form_Faixa_Etaria").style.display = "none";
	document.getElementById("acao_atividade").style.display = "none";
}

function CheckAcao(){
	
	if (document.getElementById("inlineRadio5").checked == true){
		
		document.getElementById("inlineRadio5").checked = false;
		document.getElementById("inlineRadio1").checked = true;
		EnableInput()
	}
	document.getElementById("Form_Faixa_Etaria").style.display = "none";
	document.getElementById("acao_atividade").style.display = "block";
	
	
}

function DisableInput(){
	document.getElementById("alvo_procura").disabled = true;
}

function EnableInput(){
	document.getElementById("alvo_procura").disabled = false;
}

function pesquisa(){
	
	var resposta = document.getElementById("resultado_procura");
	
	let tabela = get_Checked_Element(document.getElementsByName("tabela_procura")).value;
	let alvo = document.getElementById("alvo_procura").value;
	let opcao = get_Checked_Element(document.getElementsByName("opcao")).value;
	let atividade = get_Checked_Element(document.getElementsByName("opcao_atividade")).value;
	let faixa_etaria = document.getElementById("faixa_etaria").value;

	var xmlhttp_pesquisa = new XMLHttpRequest();
	
    xmlhttp_pesquisa.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);
			resposta.innerHTML = this.responseText;
		}
    };

    xmlhttp_pesquisa.open("GET","form_pesquisa.php?alvo="+ alvo + "&restricao=" + opcao + "&tabela=" + tabela + "&faixa_etaria=" + faixa_etaria + "&atividade=" + atividade,true);
	xmlhttp_pesquisa.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_pesquisa.send();
	
}

function get_Checked_Element(Elements){
	
	for (var i = 0; i < Elements.length; i++ ){
		if ( Elements[i].checked ) {
			return Elements[i];
		}
	}
}
