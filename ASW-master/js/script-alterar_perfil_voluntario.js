"use strict";

window.addEventListener("load", principal);

function principal() {
	defineEventHandlersParaElementosHTML();
}


/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ATRIBUIÇÃO DE FUNÇÕES AOS DIVERSOS ELEMENTOS HTML DA APLICAÇÃO MEMENTO
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/

function defineEventHandlersParaElementosHTML() {

	document.getElementById("xPng4").addEventListener("click", voltar_perfil_voluntario);
    
    // Não deixar selecionar mais que uma checkbox no form
    document.getElementById("simOuNao1").addEventListener("click", onlyOneChecked3);
    document.getElementById("simOuNao2").addEventListener("click", onlyOneChecked4);
    document.getElementById("masculinoFeminino1").addEventListener("click", onlyOneChecked5);
    document.getElementById("masculinoFeminino2").addEventListener("click", onlyOneChecked6);
    document.getElementById("masculinoFeminino3").addEventListener("click", onlyOneChecked7);

    // Tornar passwords visiveis
    document.getElementById("blackEye1").addEventListener("click", aparecerPassword1);
    document.getElementById("redEye1").addEventListener("click", esconderPassword1);
}

/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
FUNÇÕES USADAS NA ALTERAÇÃO DE DADOS DE UM VOLUNTÁRIO
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/


function onlyOneChecked3 () {

    if (document.getElementById("simOuNao1").checked) {
        if(document.getElementById("simOuNao2").checked || document.getElementById("simOuNao2").required) {
            document.getElementById("simOuNao2").checked=false;
            document.getElementById("simOuNao2").required = false;
        }
    }  
}


function onlyOneChecked4 () {

    if (document.getElementById("simOuNao2").checked) {
        if(document.getElementById("simOuNao1").checked || document.getElementById("simOuNao1").required) {
            document.getElementById("simOuNao1").checked=false;
            document.getElementById("simOuNao1").required = false;
    }
    }  
}

function onlyOneChecked5 () {

    if (document.getElementById("masculinoFeminino1").checked) {
        if(document.getElementById("masculinoFeminino2").checked || document.getElementById("masculinoFeminino2").required) {
            document.getElementById("masculinoFeminino2").checked=false;
            document.getElementById("masculinoFeminino2").required=false;
        }
        if(document.getElementById("masculinoFeminino3").checked || document.getElementById("masculinoFeminino3").required) {
            document.getElementById("masculinoFeminino3").checked=false;
            document.getElementById("masculinoFeminino3").required=false;
        }
    }  
}

function onlyOneChecked6 () {

    if (document.getElementById("masculinoFeminino2").checked) {
        if(document.getElementById("masculinoFeminino1").checked || document.getElementById("masculinoFeminino1").required) {
            document.getElementById("masculinoFeminino1").checked=false;
            document.getElementById("masculinoFeminino1").required=false;
        }
        if(document.getElementById("masculinoFeminino3").checked || document.getElementById("masculinoFeminino3").required) {
            document.getElementById("masculinoFeminino3").checked=false;
            document.getElementById("masculinoFeminino3").required=false;
        }
    }  
}

function onlyOneChecked7 () {

    if (document.getElementById("masculinoFeminino3").checked) {
        if(document.getElementById("masculinoFeminino2").checked || document.getElementById("masculinoFeminino2").required) {
            document.getElementById("masculinoFeminino2").checked=false;
            document.getElementById("masculinoFeminino2").required=false;
        }
        if(document.getElementById("masculinoFeminino1").checked || document.getElementById("masculinoFeminino1").required) {
            document.getElementById("masculinoFeminino1").checked=false;
            document.getElementById("masculinoFeminino1").required=false;
        }
    }  
}

/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ESCONDER OU MOSTRAR PASSWORDS
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/

function aparecerPassword1 () {
    let x = document.getElementById("password_voluntario");
    let y = document.getElementById("confirmar_password_voluntario");
    
    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }

    document.getElementById("blackEye1").style.display = "none";

    document.getElementById("redEye1").style.display = "inline-block";
}


function esconderPassword1 () {
    let x = document.getElementById("password_voluntario");
    let y = document.getElementById("confirmar_password_voluntario");
    
    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }

    document.getElementById("blackEye1").style.display = "inline-block";

    document.getElementById("redEye1").style.display = "none";
    
}


function validate_change_vol(data){

	var teste = [];
	var falhas = [];
	var MoveFocus = [];
	
	var email = document.getElementById("alterar_email").value;
	var cc = document.getElementById("alterar_cartao_cidadao").value;
	var user = document.getElementById("alterar_username").value;
	var telefone = document.getElementById("alterar_telefone").value;

	document.getElementById("form_falha_email").style.display = "none";
	document.getElementById("form_falha_cc").style.display = "none";
	document.getElementById("form_falha_user").style.display = "none";
	document.getElementById("form_falha_telemovel").style.display = "none";

	MoveFocus = ["alterar_email", "alterar_cartao_cidadao", "alterar_username", "alterar_telefone"];
	falhas = ["form_falha_email", "form_falha_cc", "form_falha_user", "form_falha_telemovel"];
	teste = [email, cc, user, telefone];
	
	for (var i = 0; i < data.length; i++){
		for (var j = 0; j < data[i].length; j++){
			
			var info_bd = data[i][j].toString().toLowerCase();
			var info_user = teste[i].toString().toLowerCase();

			if (info_bd == info_user){
				
				document.getElementById(falhas[i]).style.display = "block";
				document.getElementById(MoveFocus[i]).focus();
				
				return false;
			}
		}
	}
    
	return true;
}

function verificar_se_password_foi_repetida () {
    if(document.getElementById('confirmar_password_voluntario').value == "") {
        document.getElementById('confirmar_password_em_falta').style.display = "block";
    } else {
        document.getElementById('confirmar_password_em_falta').style.display = "none";
        
        if (document.getElementById('password_voluntario').value ==
        document.getElementById('confirmar_password_voluntario').value) {

        document.getElementById('passwords_desiguais').style.display = "none";
        document.getElementById('btn_registarVol_inativo').style.display = "none";
        document.getElementById("registar").disabled = false;
        document.getElementById('confirmar_password_em_falta').style.display = "none";

        } else {
            document.getElementById('confirmar_password_em_falta').style.display = "none";
            document.getElementById('passwords_desiguais').style.display = "block";
            document.getElementById('btn_registarVol_inativo').style.display = "block";
            document.getElementById("registar").disabled = true;
    
        }
    }
}


function voltar_perfil_voluntario () {
	window.location.href = "perfil_voluntario.php";
}


function verificar_se_passwords_iguais() {
    if (document.getElementById('password_voluntario').value ==
        document.getElementById('confirmar_password_voluntario').value) {

        document.getElementById('passwords_desiguais').style.display = "none";
        document.getElementById('btn_registarVol_inativo').style.display = "none";
        document.getElementById("alterar_perfil_do_voluntario").disabled = false;
        document.getElementById('confirmar_password_em_falta').style.display = "none";
        


    } else {
        document.getElementById('confirmar_password_em_falta').style.display = "none";
        document.getElementById('passwords_desiguais').style.display = "block";
        document.getElementById('btn_registarVol_inativo').style.display = "block";
        document.getElementById("alterar_perfil_do_voluntario").disabled = true;
		document.getElementById("header_alterar_dados_principais").focus();

    }
}


function displayOFF_btn_registarVol_inativo () {
    document.getElementById('btn_registarVol_inativo').style.display = "none";
}

