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

	document.getElementById("xPng5").addEventListener("click", voltar_perfil_empresa);

    // Tornar passwords visiveis
    document.getElementById("blackEye2").addEventListener("click", aparecerPassword2);
    document.getElementById("redEye2").addEventListener("click", esconderPassword2);
}

/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ESCONDER OU MOSTRAR PASSWORDS
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/



function aparecerPassword2 () {
    let x = document.getElementById("password_empresa_registo");
    let y = document.getElementById("confirmar_password_empresa_registo");

    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }

    document.getElementById("blackEye2").style.display = "none";

    document.getElementById("redEye2").style.display = "inline-block";
}


function esconderPassword2 () {
    let x = document.getElementById("password_empresa_registo");
    let y = document.getElementById("confirmar_password_empresa_registo");

    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }

    document.getElementById("blackEye2").style.display = "inline-block";

    document.getElementById("redEye2").style.display = "none";
}


function validate_change_inst(data){

	var teste = [];
	var falhas = [];
	var MoveFocus = [];
	
	var nome = document.getElementById("alterar_nome_empresa").value;
	var telefone = document.getElementById("alterar_telefone_empresa").value;
	var email_empresa = document.getElementById("alterar_email_empresa").value;
	var email_repre = document.getElementById("alterar_email_representante_empresa").value;

	document.getElementById("form_falha_nome_empresa").style.display = "none";
	document.getElementById("form_falha_telefone_empresa").style.display = "none";
	document.getElementById("form_falha_email_empresa").style.display = "none";
	document.getElementById("form_falha_email_repre_empresa").style.display = "none";
	
	MoveFocus = ["alterar_nome_empresa", "alterar_telefone_empresa", "alterar_email_empresa", "alterar_email_representante_empresa"];
	falhas = ["form_falha_nome_empresa", "form_falha_telefone_empresa", "form_falha_email_empresa", "form_falha_email_repre_empresa"];
	teste = [nome, telefone, email_empresa, email_repre];
	
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

function voltar_perfil_empresa () {
	window.location.href = "perfil_empresa.php";
}

function verificar_se_password_foi_repetida_empresa () {
    if(document.getElementById('confirmar_password_empresa_registo').value == "") {
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "block";
    } else {
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";

        if (document.getElementById('password_empresa_registo').value ==
            document.getElementById('confirmar_password_empresa_registo').value) {

        document.getElementById('passwords_empresa_desiguais').style.display = "none";
        document.getElementById('btn_registarEmp_inativo').style.display = "none";
        document.getElementById("registar_empresa").disabled = false;
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
        
        } else {

            document.getElementById('passwords_empresa_desiguais').style.display = "block";
            document.getElementById('btn_registarEmp_inativo').style.display = "block";
            document.getElementById("registar_empresa").disabled = true;
            document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
    
        }
    }
}


function verificar_se_passwords_iguais_empresa() {
    if (document.getElementById('password_empresa_registo').value ==
            document.getElementById('confirmar_password_empresa_registo').value) {

        document.getElementById('passwords_empresa_desiguais').style.display = "none";
        document.getElementById('btn_registarEmp_inativo').style.display = "none";
        document.getElementById("registar_empresa").disabled = false;
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
        


    } else {

        document.getElementById('passwords_empresa_desiguais').style.display = "block";
        document.getElementById('btn_registarEmp_inativo').style.display = "block";
        document.getElementById("registar_empresa").disabled = true;
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
        document.getElementById("header_alterar_dados_principais").focus();

    }
}


function displayOFF_btn_registarEmp_inativo () {
    document.getElementById('btn_registarEmp_inativo').style.display = "none";
}