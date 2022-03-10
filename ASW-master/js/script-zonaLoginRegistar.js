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

    // Não deixar selecionar mais que uma checkbox em vários forms
    document.getElementById("voluntario2").addEventListener("click", onlyOneChecked2);
    document.getElementById("empresa").addEventListener("click", onlyOneChecked1);
    document.getElementById("login_voluntario2").addEventListener("click", onlyOneChecked8);
    document.getElementById("login_empresa").addEventListener("click", onlyOneChecked9);
    document.getElementById("simOuNao1").addEventListener("click", onlyOneChecked3);
    document.getElementById("simOuNao2").addEventListener("click", onlyOneChecked4);
    document.getElementById("masculinoFeminino1").addEventListener("click", onlyOneChecked5);
    document.getElementById("masculinoFeminino2").addEventListener("click", onlyOneChecked6);
    document.getElementById("masculinoFeminino3").addEventListener("click", onlyOneChecked7);

    document.getElementById("criarConta").addEventListener("click", mostrarRegistoDeContaVoluntario);
    document.getElementById("criarConta_empresa").addEventListener("click", mostrarRegistoDeContaEmpresa);
    document.getElementById("xPng2").addEventListener("click", esconderRegistoVoluntario);
    document.getElementById("xPng3").addEventListener("click", esconderRegistoEmpresa);

    // Tornar passwords visiveis
    document.getElementById("blackEye1").addEventListener("click", aparecerPassword1);
    document.getElementById("redEye1").addEventListener("click", esconderPassword1);
    document.getElementById("blackEye2").addEventListener("click", aparecerPassword2);
    document.getElementById("redEye2").addEventListener("click", esconderPassword2);
    document.getElementById("blackEye3").addEventListener("click", aparecerPassword3);
    document.getElementById("redEye3").addEventListener("click", esconderPassword3);
    document.getElementById("blackEye4").addEventListener("click", aparecerPassword4);
    document.getElementById("redEye4").addEventListener("click", esconderPassword4);
}

/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ESCONDER OU MOSTRAR ELEMENTOS QUANDO CLICADOS
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/

function mostrarRegistoDeContaVoluntario () {

    document.getElementById("registar_entrar").style.display = "none";

    document.getElementById("div_Registar_Voluntario").style.display = "block";
    document.getElementById("xPng2").style.display = "block";

    if(document.getElementById("empresa").checked) 
        {document.getElementById("empresa").checked=false;}
}


function mostrarRegistoDeContaEmpresa () {

    document.getElementById("registar_entrar").style.display = "none";

    document.getElementById("div_Registar_Empresa").style.display = "block";
    document.getElementById("xPng3").style.display = "block";

    if(document.getElementById("voluntario2").checked) 
        {document.getElementById("voluntario2").checked=false;}
}


function esconderRegistoVoluntario () {
    document.getElementById("div_Registar_Voluntario").style.display = "none";
    document.getElementById("xPng2").style.display = "none";

    document.getElementById("registar_entrar").style.display = "block";
}

function esconderRegistoEmpresa () {
    document.getElementById("div_Registar_Empresa").style.display = "none";
    document.getElementById("xPng3").style.display = "none";

    document.getElementById("registar_entrar").style.display = "block";
}


/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
ATRIBUIÇÃO DE FUNÇÕES ÀS CHECKBOXES VOLUNTÁRIO E EMPRESA
------------------------------------------------------------------------------------
----------------------------------------------------------------------------------*/

function onlyOneChecked1 () {

    if (document.getElementById("empresa").checked) {
        if(document.getElementById("voluntario2").checked) 
        {document.getElementById("voluntario2").checked=false;}
        
        document.getElementById("xPng3").style.display = "block";
        document.getElementById("div_Registar_Empresa").style.display = "block";
        document.getElementById("imagem3").style.display = "block";

        document.getElementById("xPng2").style.display = "none";
        document.getElementById("div_Registar_Voluntario").style.display = "none";
        document.getElementById("imagem2").style.display = "none";

    } 
}

function onlyOneChecked2 () {

    if (document.getElementById("voluntario2").checked) {
        if(document.getElementById("empresa").checked) 
        {document.getElementById("empresa").checked=false;}
        
        document.getElementById("xPng3").style.display = "none";
        document.getElementById("div_Registar_Empresa").style.display = "none";
        document.getElementById("imagem3").style.display = "none";

        document.getElementById("xPng2").style.display = "block";
        document.getElementById("div_Registar_Voluntario").style.display = "block";
        document.getElementById("imagem2").style.display = "block";
    } 
}


function onlyOneChecked8 () {

    if (document.getElementById("login_voluntario2").checked) {
        if(document.getElementById("login_empresa").checked) {
            document.getElementById("login_empresa").checked=false;
        }

        document.getElementById("login_como_voluntario").style.display = "block";
        document.getElementById("imagem3").style.display = "none";

        document.getElementById("login_como_empresa").style.display = "none";
        document.getElementById("imagem2").style.display = "block";
    } 
}

function onlyOneChecked9 () {

    if (document.getElementById("login_empresa").checked) {
        if(document.getElementById("login_voluntario2").checked) {
            document.getElementById("login_voluntario2").checked=false;
        }

        document.getElementById("login_como_voluntario").style.display = "none";
        document.getElementById("imagem3").style.display = "block";

        document.getElementById("login_como_empresa").style.display = "block";
        document.getElementById("imagem2").style.display = "none";
        
    }  
}

/*----------------------------------------------------------------------------------
------------------------------------------------------------------------------------
FUNÇÕES USADAS NO REGISTO DE UM VOLUNTÁRIO
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

function validate_data(data){
	
	var volun = document.getElementById("voluntario2").checked;
	var volun1 = document.getElementById("voluntario").checked;

	var teste = [];
	var falhas = [];
	var escolha;
	var MoveFocus = [];
	
	if (volun || volun1){
		escolha = 0;

		var email = document.getElementById("email_vol").value;
		var cc = document.getElementById("cartao_cidadao_vol").value;
		var user = document.getElementById("username_vol").value;
		var telefone = document.getElementById("telefone_vol").value;
		
		teste = [email, cc, user, telefone];
		falhas = ["form_falha_email", "form_falha_cc", "form_falha_user", "form_falha_telemovel"];
		MoveFocus = ["email_vol", "cartao_cidadao_vol", "username_vol", "telefone_vol"];
	}
	else{
		escolha = 1;
		
		var nome = document.getElementById("nome_empresa").value;
		var telefone = document.getElementById("telefone_empresa").value;
		var email_empresa = document.getElementById("email_empresa").value;
		var email_repre = document.getElementById("email_representante_empresa").value;
		
		teste = [nome, telefone, email_empresa, email_repre];
		falhas = ["form_falha_nome_empresa", "form_falha_telemovel_empresa", "form_falha_email_empresa", "form_falha_email_repre_empresa"];
		MoveFocus = ["nome_empresa", "telefone_empresa", "email_empresa", "email_representante_empresa"];
	}

	for (var valor of falhas){
		try{
			document.getElementById(valor).style.display = "none";
		}finally{
			//pass
		}
	}

	for (var i = 0; i < data[escolha].length; i++){
		for (var j = 0; j < data[escolha][i].length; j++){
			
			var info_bd = data[escolha][i][j].toString().toLowerCase();
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

function aparecerPassword3 () {
    let x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }

    document.getElementById("blackEye3").style.display = "none";

    document.getElementById("redEye3").style.display = "inline-block";
}


function esconderPassword3 () {
    let x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }

    document.getElementById("blackEye3").style.display = "inline-block";

    document.getElementById("redEye3").style.display = "none";
}

function aparecerPassword4 () {
    let x = document.getElementById("password_empresa");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }

    document.getElementById("blackEye4").style.display = "none";

    document.getElementById("redEye4").style.display = "inline-block";
}


function esconderPassword4 () {
    let x = document.getElementById("password_empresa");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }

    document.getElementById("blackEye4").style.display = "inline-block";

    document.getElementById("redEye4").style.display = "none";
}

function verificar_se_password_foi_repetida () {
    if(document.getElementById('confirmar_password_voluntario').value == "") {
        document.getElementById('confirmar_password_em_falta').style.display = "block";
    } else {
        document.getElementById('confirmar_password_em_falta').style.display = "none";
        
        if (document.getElementById('password_voluntario').value ==
        document.getElementById('confirmar_password_voluntario').value) {

        document.getElementById('passwords_desiguais').style.display = "none";
        document.getElementById("registar").disabled = false;
        document.getElementById('confirmar_password_em_falta').style.display = "none";

        } else {
            document.getElementById('confirmar_password_em_falta').style.display = "none";
            document.getElementById('passwords_desiguais').style.display = "block";
            document.getElementById("registar").disabled = true;
            document.getElementById("label_password_voluntario").focus();
    
        }
    }
}

function verificar_se_password_foi_repetida_empresa () {
    if(document.getElementById('confirmar_password_empresa_registo').value == "") {
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "block";
    } else {
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";

        if (document.getElementById('password_empresa_registo').value ==
            document.getElementById('confirmar_password_empresa_registo').value) {

        document.getElementById('passwords_empresa_desiguais').style.display = "none";
        document.getElementById("registar_empresa_botao").disabled = false;
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
        
        } else {

            document.getElementById('passwords_empresa_desiguais').style.display = "block";
            document.getElementById("registar_empresa_botao").disabled = true;
            document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
            document.getElementById("label_password_empresa").focus();
    
        }
    }
}


function verificar_se_passwords_iguais() {
    if (document.getElementById('password_voluntario').value ==
        document.getElementById('confirmar_password_voluntario').value) {

        document.getElementById('passwords_desiguais').style.display = "none";
        document.getElementById("registar").disabled = false;
        document.getElementById('confirmar_password_em_falta').style.display = "none";
        


    } else {
        document.getElementById('confirmar_password_em_falta').style.display = "none";
        document.getElementById('passwords_desiguais').style.display = "block";
        document.getElementById("registar").disabled = true;
        document.getElementById("label_password_voluntario").focus();

    }
}

function verificar_se_passwords_iguais_empresa() {
    if (document.getElementById('password_empresa_registo').value ==
            document.getElementById('confirmar_password_empresa_registo').value) {

        document.getElementById('passwords_empresa_desiguais').style.display = "none";
        document.getElementById("registar_empresa_botao").disabled = false;
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
        


    } else {

        document.getElementById('passwords_empresa_desiguais').style.display = "block";
        document.getElementById("registar_empresa_botao").disabled = true;
        document.getElementById('confirmar_password_em_falta_empresa').style.display = "none";
        document.getElementById("label_password_empresa").focus();

    }
}