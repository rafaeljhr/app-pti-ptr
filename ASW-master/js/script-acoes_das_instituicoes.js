"use strict";

window.addEventListener("load", principal);

var intervalo;
var msg_intervalo;
var estado_cand_intervalo;

function principal() {
	defineEventHandlersParaElementosHTML();
	
	estado_cand_intervalo = setInterval(mostrar_estado_candidaturas, 500);

    // A usar pelo voluntário: A cada segundo é verificado se existe na base de dados se
    // existe ações novas registadas pelas empresas. Se sim, as ações apresentadas ao voluntário
    // são atualizada.
    intervalo = setInterval(verificar_se_acoes_novas, 1000);

}

/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ATRIBUIÇÃO DE FUNÇÕES AOS DIVERSOS ELEMENTOS HTML DA APLICAÇÃO MEMENTO
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/

function defineEventHandlersParaElementosHTML() {

	// Não deixar selecionar mais que uma checkbox no form

    if(document.getElementById("acoes_ativas")){
        document.getElementById("acoes_inativas").addEventListener("click", onlyOneChecked1);

    }else if (document.getElementById("acoes_ativas2")) {
        document.getElementById("acoes_ativas2").addEventListener("click", onlyOneChecked2);

    } 
    
    if(document.getElementById("filtro_acoes")){
        document.getElementById("todas_acoes").addEventListener("click", onlyOneChecked4);

    } else if (document.getElementById("filtro_acoes2")) {
        document.getElementById("acoes_para_si2").addEventListener("click", onlyOneChecked3);
    }
    

    if (document.getElementById("mais_filtros")) {
        document.getElementById("mais_filtros").addEventListener("click", aparecer_esconder_div_filtros);
    } else if (document.getElementById("mais_filtros2")) {
        document.getElementById("mais_filtros2").addEventListener("click", aparecer_esconder_div_filtros);
    }
    
}


/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
FUNÇÕES USADAS NA VISÃO DE UMA INSTITUIÇÃO SOBRE AS AÇÕES
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/


function onlyOneChecked1 () {

    if (document.getElementById("acoes_inativas").checked) {
        document.getElementById("acoes_inativas").checked=false;
    
    }  

    submeter_form3 ();  
}


function onlyOneChecked2 () {

    if (document.getElementById("acoes_ativas2").checked) {
        document.getElementById("acoes_ativas2").checked=false;
    
    }  

    submeter_form4 (); 
}


function onlyOneChecked3 () {
    if (document.getElementById("acoes_para_si2").checked) {
        document.getElementById("acoes_para_si2").checked=false;
    
    }  
	
    submeter_form2 ();
}

function onlyOneChecked4 () {

    if (document.getElementById("todas_acoes").checked) {
        document.getElementById("todas_acoes").checked=false;
        
    }  
    submeter_form ();
}



function submeter_form () {

    var form = document.getElementById("filtro_acoes");
    form.submit();

}

function submeter_form2 () {

    var form2 = document.getElementById("filtro_acoes2");
    form2.submit();

}

function submeter_form3 () {

    var form = document.getElementById("filtro_acoes_empresa");
    form.submit();

}

function submeter_form4 () {

    var form2 = document.getElementById("filtro_acoes_empresa2");
    form2.submit();

}


function aparecer_esconder_div_filtros () {

    if (document.getElementById("mais_filtros")) {
        if (document.getElementById("mais_filtros").checked) {

            document.getElementById("filtrar_acoes_apresentadas").style.display = "block";
            desativar_setInterval();

            if (document.getElementById("filtro_acoes")) {
                document.getElementById("filtro_acoes").style.marginTop = '30px';
            } else {
                document.getElementById("filtro_acoes_empresa").style.marginTop = '30px';
            }
            
            
        } else {
    
            document.getElementById("filtrar_acoes_apresentadas").style.display = "none";
            ativar_setInterval();
            
            if (document.getElementById("filtro_acoes")) {
                document.getElementById("filtro_acoes").style.marginTop = '0px';
            } else {
                document.getElementById("filtro_acoes_empresa").style.marginTop = '0px';
            }
            
        }
    } else {
        if (document.getElementById("mais_filtros2").checked) {

            document.getElementById("filtrar_acoes_apresentadas").style.display = "block";
            desativar_setInterval();

            if (document.getElementById("filtro_acoes2")) {
                document.getElementById("filtro_acoes2").style.marginTop = '30px';
            } else {
                document.getElementById("filtro_acoes_empresa2").style.marginTop = '30px';
            }

            
            
        } else {
    
            document.getElementById("filtrar_acoes_apresentadas").style.display = "none";
            ativar_setInterval();
            
            if (document.getElementById("filtro_acoes2")) {
                document.getElementById("filtro_acoes2").style.marginTop = '0px';
            } else {
                document.getElementById("filtro_acoes_empresa2").style.marginTop = '0px';
            }
            
        }
    }
}

function fechar_convidar_voluntarios(){
	document.getElementById("conjunto_ações").style.pointerEvents = "auto";
	var div = document.getElementById("convidar_voluntarios");
	
	div.innerHTML = "";
	div.style.display = "none";
}

function convidar_voluntario(acao_info, acao_id){

	document.getElementById("conjunto_ações").style.pointerEvents = "none";
	var div = document.getElementById("convidar_voluntarios");
	div.style.display = "block";
	
    var xmlhttp_convidar = new XMLHttpRequest();
	
    xmlhttp_convidar.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			div.innerHTML = this.responseText;
		}
    };
	
    xmlhttp_convidar.open("GET","lista_acao_voluntario.php?acao="+ JSON.stringify(acao_info) + "&acao_id=" + acao_id,true);
	xmlhttp_convidar.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_convidar.send();
}

function candidaturas_voluntarios(acao_id){

	document.getElementById("conjunto_ações").style.pointerEvents = "none";
	var div = document.getElementById("convidar_voluntarios");
	div.style.display = "block";
	
    var xmlhttp_cand = new XMLHttpRequest();
	
    xmlhttp_cand.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			div.innerHTML = this.responseText;
		}
    };
	console.log(acao_id);
    xmlhttp_cand.open("GET","lista_candidaturas_acao.php?acao_id="+ acao_id,true);
	xmlhttp_cand.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_cand.send();
}

function aceitar_candidatura(volun_id, acao_id, btn){
	
	var div = encontrar_parent(btn, "container input-group p-2");
	var div2 = document.getElementById("convidar_voluntarios");

	document.getElementById(volun_id).remove();

	div.remove();
	
	var xmlhttp_atualiza_cand = new XMLHttpRequest();
	
	xmlhttp_atualiza_cand.open("GET","aceitar_rejeitar_cand.php?acao="+ acao_id + "&volun=" + volun_id +"&estado=aceite",true);
	xmlhttp_atualiza_cand.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_atualiza_cand.send();
}

function rejeitar_candidatura(volun_id, acao_id, btn){
	
	var div = encontrar_parent(btn, "container input-group p-2");
	document.getElementById(volun_id).remove();
	div.remove();
	
	var xmlhttp_atualiza_cand = new XMLHttpRequest();
	
	xmlhttp_atualiza_cand.open("GET","aceitar_rejeitar_cand.php?acao="+ acao_id + "&volun=" + volun_id +"&estado=rejeitado",true);
	xmlhttp_atualiza_cand.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_atualiza_cand.send();
}

function encontrar_parent(el, className) {
  className = className.toLowerCase();

  while (el && el.parentNode) {
    el = el.parentNode;
    if (el.className && el.className.toLowerCase() == className) {
      return el;
    }
  }
}

function atualizar_volun(acao_id, acao){
	
	var procura = findRadioButton('procura_form');
	var carta = findRadioButton('carta_form');
	var texto = document.getElementById('procura_nome').value;
	var div = document.getElementById("conv_volun_div");
	
	var xmlhttp_cand = new XMLHttpRequest();
	
    xmlhttp_cand.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			div.innerHTML = this.responseText;
		}
    };

    xmlhttp_cand.open("GET","lista_acao_voluntario.php?carta=" + carta + "&acao_id=" + acao_id + "&texto=" + texto + "&procura=" + procura + "&acao=" + JSON.stringify(acao),true);
	xmlhttp_cand.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_cand.send();

}

function atualizar_cand(acao_id){
	
	var procura = findRadioButton('procura_form');
	var carta = findRadioButton('carta_form');
	var texto = document.getElementById('procura_nome').value;
	var div = document.getElementById("conv_volun_div");

	var xmlhttp_cand = new XMLHttpRequest();
	
    xmlhttp_cand.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			div.innerHTML = this.responseText;
		}
    };

    xmlhttp_cand.open("GET","lista_candidaturas_acao.php?carta=" + carta + "&acao_id=" + acao_id + "&texto=" + texto + "&procura=" + procura,true);
	xmlhttp_cand.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_cand.send();

}

function findRadioButton(Name) {
    var test = document.getElementsByName(Name);
    var sizes = test.length;

    for (var i=0; i < sizes; i++) {
        if (test[i].checked==true) { 
			return test[i].value;
		}
    }
}


function filtrar_acoes_apresentadas(){
	
    var erro = 0;
    
    if (document.getElementById("dia_select").value=="default" &&  document.getElementById("periodo_select").value!="default") {
        document.getElementById("dia_da_semana_nao_definido").style.display = "block";
        document.getElementById("dia_select").focus();
        erro = 1;

    } else if (document.getElementById("periodo_select").value=="default" && document.getElementById("dia_select").value!="default") {
        document.getElementById("periodo_nao_definido").style.display = "block";
        document.getElementById("periodo_select").focus();
        erro = 1;

    } 

    if (erro == 0) {

        let freguesia = document.getElementById("freguesia").value;
        let concelho = document.getElementById("concelho").value;
        let distrito = document.getElementById("distrito").value;
        let area_interesse = document.getElementById("area_interesse").value;
        let populacao_alvo = document.getElementById("populacao_alvo").value;
        let dia_da_semana = document.getElementById("dia_select").value;
        let periodo = document.getElementById("periodo_select").value;

        var xmlhttp_filtrar = new XMLHttpRequest();
        
        xmlhttp_filtrar.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var acoes_atuais_na_pagina = document.getElementsByClassName('caixa_da_acao');

                while (acoes_atuais_na_pagina[0]) {
                    acoes_atuais_na_pagina[0].parentNode.removeChild(acoes_atuais_na_pagina[0]);
                }
				
                document.getElementById("conjunto_ações").innerHTML += this.responseText;

                document.getElementById("freguesia").value = freguesia;
                document.getElementById("concelho").value = concelho;
                document.getElementById("distrito").value = distrito;
                document.getElementById("area_interesse").value = area_interesse;
                document.getElementById("populacao_alvo").value = populacao_alvo;
                document.getElementById("dia_select").value = dia_da_semana;
                document.getElementById("periodo_select").value = periodo;

                defineEventHandlersParaElementosHTML();
				
                if (document.getElementById("mais_filtros")) {
                    
                    if (document.getElementById("filtrar_acoes_apresentadas").style.display == "block"){
						document.getElementById("mais_filtros").checked=true;
					}

                } else {
                    
                    if (document.getElementById("filtrar_acoes_apresentadas").style.display == "block"){
						document.getElementById("mais_filtros2").checked=true;
					}
                }
                sleep(1000).then(() => {
                    loader(false);
                }); 
            }
        }

        loader(true);
        
        xmlhttp_filtrar.open("GET","aplicar_filtros.php?freguesia=" + freguesia +
        "&concelho=" + concelho + "&distrito="+ distrito + "&area_interesse=" + area_interesse + "&populacao_alvo=" + populacao_alvo +
        "&dia_select=" + dia_da_semana + "&periodo_select=" + periodo, true);

        xmlhttp_filtrar.setRequestHeader( "Content-Type", "application/json" );
        xmlhttp_filtrar.send();

    }

} 

function loader (boleano) {

    if (boleano==true) {
        document.getElementById("loader").style.display = "block";
    } else {
        document.getElementById("loader").style.display = "none";
    }
}


function esconder_small_periodo () {
    document.getElementById("periodo_nao_definido").style.display = "none";
}


function esconder_small_dia_da_semana () {
    document.getElementById("dia_da_semana_nao_definido").style.display = "none";
}


function verificar_se_acoes_novas () {

    // saber se é uma página com user logado ou não
    if (document.getElementById("mais_filtros") || document.getElementById("mais_filtros2")){

        let freguesia = document.getElementById("freguesia").value;
        let concelho = document.getElementById("concelho").value;
        let distrito = document.getElementById("distrito").value;
        let area_interesse = document.getElementById("area_interesse").value;
        let populacao_alvo = document.getElementById("populacao_alvo").value;
        let dia_da_semana = document.getElementById("dia_select").value;
        let periodo = document.getElementById("periodo_select").value;

        var xmlhttp_filtrar = new XMLHttpRequest();
            
        xmlhttp_filtrar.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                var acoes_atuais_na_pagina = document.getElementsByClassName('caixa_da_acao');

                var num_acoes_atuais_na_pagina = acoes_atuais_na_pagina.length;

                var num_acoes_da_resposta = occurrences(this.responseText, 'caixa_da_acao');

                if (num_acoes_atuais_na_pagina != num_acoes_da_resposta) {

                    while (acoes_atuais_na_pagina[0]) {
                        acoes_atuais_na_pagina[0].parentNode.removeChild(acoes_atuais_na_pagina[0]);
                    }
                    
                    document.getElementById("acoes_mostradas").innerHTML += this.responseText;

                    defineEventHandlersParaElementosHTML();

                    if (document.getElementById("mais_filtros")) {
                        
                        if (document.getElementById("mais_filtros").checked) {
                            document.getElementById("mais_filtros").checked=true;
                        } else {
                            document.getElementById("mais_filtros").checked=false;
                        }

                    } else {
                        
                        if (document.getElementById("mais_filtros2").checked) {
                            document.getElementById("mais_filtros2").checked=true;
                        } else {
                            document.getElementById("mais_filtros2").checked=false;
                        }
        
                    }

                }
            }
		}

        xmlhttp_filtrar.open("GET","aplicar_filtros.php?freguesia=" + freguesia +
        "&concelho=" + concelho + "&distrito="+ distrito + "&area_interesse=" + area_interesse + "&populacao_alvo=" + populacao_alvo +
        "&dia_select=" + dia_da_semana + "&periodo_select=" + periodo, true);

        xmlhttp_filtrar.setRequestHeader( "Content-Type", "application/json" );
        xmlhttp_filtrar.send();
    }
}

function occurrences(string, subString, allowOverlapping) {

    string += "";
    subString += "";
    if (subString.length <= 0) return (string.length + 1);

    var n = 0,
        pos = 0,
        step = allowOverlapping ? 1 : subString.length;

    while (true) {
        pos = string.indexOf(subString, pos);
        if (pos >= 0) {
            ++n;
            pos += step;
        } else break;
    }
    return n;
}


function desativar_setInterval() {
    clearInterval(intervalo);
}


function ativar_setInterval() {
    intervalo = setInterval(verificar_se_acoes_novas, 3000);
}

function mostrar_chat () {
    document.getElementById("zona_do_chat").style.display = "block";
    
}

function fechar_chat () {
    document.getElementById("zona_do_chat").style.display = "none";
}

function mostrar_sobre_empresa () {
    if (document.getElementById("sobre_a_empresa_box").style.display == "none") {
        document.getElementById("sobre_a_empresa_box").style.display = "block";
    } else {
        document.getElementById("sobre_a_empresa_box").style.display = "none";
    }
}

function fechar_sobre_empresa () {
	ativar_setInterval();
    document.getElementById("conjunto_ações").style.pointerEvents = "auto";
    document.getElementById("sobre_a_empresa_box").style.display = "none";
}

function fechar_zona_conversa () {
	clearInterval(msg_intervalo);
    document.getElementById("zona_da_conversa").innerHTML = "";
	document.getElementById("zona_da_conversa").style.display = "none";

}

function abrir_zona_conversa () {
    document.getElementById("zona_da_conversa").style.display = "block";

}


function construir_apresentacao_empresa (inst_id) {

    document.getElementById("conjunto_ações").style.pointerEvents = "none";

    var xmlhttp_filtrar = new XMLHttpRequest();
    
    xmlhttp_filtrar.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("sobre_a_empresa_box").innerHTML = '';
            
            document.getElementById("sobre_a_empresa_box").innerHTML += this.responseText;

            defineEventHandlersParaElementosHTML();

            if (document.getElementById("mais_filtros")) {
                
                if (document.getElementById("mais_filtros").checked) {
                    document.getElementById("mais_filtros").checked=true;
                } else {
                    document.getElementById("mais_filtros").checked=false;
                }

            } else if (document.getElementById("mais_filtros2")) {
                
                if (document.getElementById("mais_filtros2").checked) {
                    document.getElementById("mais_filtros2").checked=true;
                } else  {
                    document.getElementById("mais_filtros2").checked=false;
                }

            }
        }
    }
    
    xmlhttp_filtrar.open("GET","construir_apresentacao_empresa.php?inst_id=" + inst_id, true);

    xmlhttp_filtrar.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_filtrar.send();

}


function construir_apresentacao_acoes_empresa (inst_id, volun_id) {

    document.getElementById("conjunto_ações").style.pointerEvents = "none";
	desativar_setInterval();
	
	if (volun_id == undefined){
		volun_id = "None";
	}
	console.log(inst_id, volun_id);
    var xmlhttp_filtrar = new XMLHttpRequest();
    
    xmlhttp_filtrar.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("sobre_a_empresa_box").innerHTML = '';

            document.getElementById("sobre_a_empresa_box").innerHTML += this.responseText;

            defineEventHandlersParaElementosHTML();

            if (document.getElementById("mais_filtros")) {
                
                if (document.getElementById("mais_filtros").checked) {
                    document.getElementById("mais_filtros").checked=true;
                } else {
                    document.getElementById("mais_filtros").checked=false;
                }

            } else if (document.getElementById("mais_filtros2"))  {
                
                if (document.getElementById("mais_filtros2").checked) {
                    document.getElementById("mais_filtros2").checked=true;
                } else {
                    document.getElementById("mais_filtros2").checked=false;
                }
            }
        }
    }
    
    xmlhttp_filtrar.open("GET","ws_infoAcaoVol_cli.php?inst_id=" + inst_id + "&volun_id=" + volun_id, true);

    xmlhttp_filtrar.setRequestHeader( "Content-Type", "application/json" );
    xmlhttp_filtrar.send();

}



function onlyOneChecked5 () {

    if (document.getElementById("infos_da_empresa2").checked) {
        document.getElementById("infos_da_empresa2").checked=false;
    
    }
}


function onlyOneChecked6 () {

    if (document.getElementById("todas_acoes_da_empresa").checked) {
        document.getElementById("todas_acoes_da_empresa").checked=false;
    
    }
}


function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
  }


function criar_nova_conversa(inst_id, volun_id)  {

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {

        if (xhttp.readyState == 4 && xhttp.status == 200) {

            document.getElementById("conversas").innerHTML = this.responseText;

            mostrar_chat();

            contruir_a_conversa (inst_id, volun_id);
        } 
    }

    xhttp.open("GET", "construir_chats.php?inst_id=" + inst_id + "&volun_id=" + volun_id, true);
    xhttp.send();

}


function contruir_a_conversa (inst_id, volun_id) {

    fechar_zona_conversa ();

    abrir_zona_conversa ();
	
	var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {

        if (xhttp.readyState == 4 && xhttp.status == 200) {

            document.getElementById("zona_da_conversa").innerHTML += this.responseText;
			
			
			var element = document.getElementById("div_chat_msg");
			element.scrollTop = element.scrollHeight;
			
			document.getElementById("mensagem_a_enviar").addEventListener("keyup",function(event) {
				if (event.keyCode === 13) {
					enviar_mensagem(inst_id, volun_id);
				}
			});
			
			msg_intervalo = setInterval(mensagens_novas, 200, inst_id, volun_id);
        }
    }
    xhttp.open("GET", "construir_mensagens_do_chat.php?inst_id=" + inst_id + "&volun_id=" + volun_id + "&estado=inicial", true);
    xhttp.send();
}

function mensagens_novas(inst_id, volun_id){

	var novas_msg = new XMLHttpRequest();

    novas_msg.onreadystatechange = function() {

        if (novas_msg.readyState == 4 && novas_msg.status == 200) {
			if (document.getElementById("msg_chat")){
				document.getElementById("msg_chat").innerHTML = this.responseText;
			}
			if (document.getElementById("msg_chat").lastChild){
				document.getElementById("msg_chat").lastChild.focus();
			}
			
        }
    }
    novas_msg.open("GET", "construir_mensagens_do_chat.php?inst_id=" + inst_id + "&volun_id=" + volun_id, true);
    novas_msg.send();
	
}


function enviar_mensagem (inst_id, volun_id) {

    let mensagem = document.getElementById("mensagem_a_enviar").value;
	
	document.getElementById("mensagem_a_enviar").value = "";
	
    if (mensagem != '') {

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {

            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (document.getElementById("mensagem_default")) {
                    document.getElementById("mensagem_default").remove();
                }             
            }
        }

        xhttp.open("GET", "registar_mensagem.php?inst_id=" + inst_id + "&volun_id=" + volun_id + "&mensagem=" + mensagem, true);
        xhttp.send();
    }

}

function mostrar_estado_candidaturas(){

	var divs = document.getElementsByClassName("estado_candidatura");
	
	if (divs){
		for (var i = 0; i < divs.length; i++) { 
			load_xml_estado_cand(divs[i]);
		}
	}
}

function load_xml_estado_cand(div){
	
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			div.innerHTML = this.responseText;
		}
	};
			
	xmlhttp.open("GET","estado_candidatura.php?acao_id="+ div.id,true);
	xmlhttp.setRequestHeader( "Content-Type", "application/json" );
	xmlhttp.send();
	
}

function aceitar_cand_volun(acao_id){

	var xmlhttp = new XMLHttpRequest();
			
	xmlhttp.open("GET","ws_estado_candidatura_cli.php?acao_id="+ acao_id,true);
	xmlhttp.setRequestHeader( "Content-Type", "application/json" );
	xmlhttp.send();
	
}
function rejeitar_cand_volun(acao_id){

	var xmlhttp = new XMLHttpRequest();
			
	xmlhttp.open("GET","recusar_candidatura.php?acao_id="+ acao_id,true);
	xmlhttp.setRequestHeader( "Content-Type", "application/json" );
	xmlhttp.send();
	
}