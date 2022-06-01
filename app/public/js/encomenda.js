function atribuir_estado_ao_input() {

    document.getElementById('estado_a_colocar').value = document.getElementById("estado_selecionado").value;

    document.getElementById("backdrop").style.display = "block";
    document.getElementById("modalAlterarEstadoEncomenda").style.display = "block";
    document.getElementById("modalAlterarEstadoEncomenda").classList.add("show");

}


function hide_modal_alterar() {
    document.getElementById("backdrop").style.display = "none";
    document.getElementById("modalAlterarEstadoEncomenda").style.display = "none";
    document.getElementById("modalAlterarEstadoEncomenda").classList.remove("show");
}