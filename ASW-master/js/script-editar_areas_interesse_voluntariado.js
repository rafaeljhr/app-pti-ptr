"use strict";

window.addEventListener("load", principal);

function principal() {
	defineEventHandlersParaElementosHTML();
}

function defineEventHandlersParaElementosHTML () {
	document.getElementById("add_area").addEventListener("click", adiciona_area);
	document.getElementById("add_populacao").addEventListener("click", adiciona_pop_alvo);
	document.getElementById("add_horario").addEventListener("click", adiciona_horario);
}

function sort_select(selElem){
	
	var tmpAry = new Array();
    for (var i=0;i<selElem.options.length;i++) {
        tmpAry[i] = new Array();
        tmpAry[i][0] = selElem.options[i].text;
        tmpAry[i][1] = selElem.options[i].value;
    }
    tmpAry.sort();
    while (selElem.options.length > 0) {
        selElem.options[0] = null;
    }
    for (var i=0;i<tmpAry.length;i++) {
        var op = new Option(tmpAry[i][0], tmpAry[i][1]);
        selElem.options[i] = op;
    }
    return;
}

function remover_area(elem){
	var div = elem.parentNode;
	var inputs = div.getElementsByTagName('input');
	var butao = div.getElementsByTagName('button')
	
	var area_int = document.getElementById("areas_interesses");
	
	var option_area = document.createElement("option");
	option_area.text = inputs[0].value;
	option_area.value = inputs[1].value;
	
	div.remove();
	
	area_int.add(option_area);
	
	sort_select(area_int);
}

function adiciona_area(){
	var area_selecionada = document.getElementById("areas_interesses");
	var div = document.createElement('div');
	var opcao_texto = area_selecionada.options[area_selecionada.selectedIndex].text;
	var opcao_valor = area_selecionada.value;
	var br = document.createElement('br');
	var texto = "<input type='text' class='form-control' value = '" + opcao_texto + "' disabled>\
				<input type='hidden' name = 'area_adicionar_volun[]' value = '" + opcao_valor + "'>\
				<button class='btn btn-outline-danger' type='button' onclick='remover_area(this)'>X</button>";
				
	div.innerHTML = texto;		
	div.classList.add("p-2");
	div.classList.add("input-group");
	
	document.getElementById("areas_adicionadas").appendChild(div);
	area_selecionada.remove(area_selecionada.selectedIndex)
}

function remover_populacao(elem){
	var div = elem.parentNode;
	var inputs = div.getElementsByTagName('input');
	var butao = div.getElementsByTagName('button')
	
	var pop_alvo = document.getElementById("populacao_alvo");
	
	var option_pop = document.createElement("option");
	option_pop.text = inputs[0].value;
	option_pop.value = inputs[1].value;
	
	div.remove();
	
	pop_alvo.add(option_pop);
	
	sort_select(pop_alvo);
}

function adiciona_pop_alvo(){
	var pop_selecionada = document.getElementById("populacao_alvo");
	var div = document.createElement('div');
	var opcao_texto = pop_selecionada.options[pop_selecionada.selectedIndex].text;
	var opcao_valor = pop_selecionada.value;
	var br = document.createElement('br');
	var texto = "<input type='text' class='form-control' value = '" + opcao_texto + "' disabled>\
				<input type='hidden' name = 'populacao_adicionar_volun[]' value = '" + opcao_valor + "'>\
				<button class='btn btn-outline-danger' type='button' onclick='remover_populacao(this)'>X</button>";
				
	div.innerHTML = texto;		
	div.classList.add("p-2");
	div.classList.add("input-group");
	
	
	document.getElementById("populacoes_adicionadas").appendChild(div);
	pop_selecionada.remove(pop_selecionada.selectedIndex)
}

function adiciona_horario(){
	if (validar_horario()){
		var hora_selecionado = document.getElementById("dia_select");
		var periodo_selecionado = document.getElementById("periodo_select");
		
		var opcao_dia = hora_selecionado.options[hora_selecionado.selectedIndex].text;
		var opcao_periodo = periodo_selecionado.options[periodo_selecionado.selectedIndex].text;
		
		var div = document.createElement('div');

		var texto = "<input type='text' class='form-control' value = '" + opcao_dia + "' disabled>\
					<input type='text' class='form-control' value = '"+ opcao_periodo +"' disabled>\
					<input type='hidden' name = 'hora_adicionar_volun[]' value = '"+ opcao_dia +"'>\
					<input type='hidden' name = 'periodo_adicionar_volun[]' value = '"+ opcao_periodo +"'>\
					<button class='btn btn-outline-danger' type='button' onclick='remover_horario(this)'>X</button>";
				
		div.innerHTML = texto;		
		div.classList.add("p-2");
		div.classList.add("input-group");
		
		document.getElementById("horarios_adicionados").appendChild(div);
	}
	
}

function remover_horario(elem){
	var div = elem.parentNode;
	div.remove();
}

function validar_horario(){
	var hora_selecionado = document.getElementById("dia_select");
	var periodo_selecionado = document.getElementById("periodo_select");
	var opcao_dia = hora_selecionado.options[hora_selecionado.selectedIndex].text; 
	var opcao_periodo = periodo_selecionado.options[periodo_selecionado.selectedIndex].text;
	
	var lista_divs = document.getElementById("horarios_adicionados").getElementsByTagName("div");
	
	for (var i = 0; i<lista_divs.length; i++){
		var inputs = lista_divs[i].getElementsByClassName("form-control");
		if (inputs[0].value == opcao_dia && inputs[1].value == opcao_periodo){
			document.getElementById("horarios_iguais").style.display = "block";
			return false;
		}
	}
	document.getElementById("horarios_iguais").style.display = "none";
	return true;
}

function verificar_inputs () {

    var areas_interesse = document.getElementById("areas_adicionadas").getElementsByTagName("div");
	if (areas_interesse.length == 0){
		document.getElementById("area_interesse_nao_selecionada").style.display = "block";
        document.getElementById("areas_interesses").focus();
        return false;
		
	}
	esconderSmallAreaInteresse();

    var populacao_alvo = document.getElementById("populacoes_adicionadas").getElementsByTagName("div");
    if (populacao_alvo.length == 0){
        document.getElementById("populacao_alvo_nao_selecionada").style.display = "block";
        document.getElementById("populacao_alvo").focus();
        return false;
    }
	esconderSmallPopulacaoAlvo();
	
    var horario = document.getElementById("horarios_adicionados").getElementsByTagName("div");
    if (horario.length == 0){
        document.getElementById("horario_nao_adicionado").style.display = "block";
        document.getElementById("dia_select").focus();
        return false;
    }
	esconderSmallsHorario();
	
    return true;
}

function esconderSmallAreaInteresse () {
    document.getElementById("area_interesse_nao_selecionada").style.display = "none";
}

function esconderSmallPopulacaoAlvo () {
    document.getElementById("populacao_alvo_nao_selecionada").style.display = "none";
}

function esconderSmallsHorario () {
    document.getElementById("horario_nao_adicionado").style.display = "none";
}