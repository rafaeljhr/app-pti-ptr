
window.onload = function () {
    if (document.getElementById("menu_perfil_utilizador")) {
        document.getElementById("menu_perfil_utilizador").style.display = "block";
    }
    
};



function apagarNotificacao(id){

    document.getElementById("li_"+id).remove();
    document.getElementById("hr_"+id).remove();

    var form = document.getElementById("form_"+id);
    var data = new FormData(form)

    let xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action, true)

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            

        } else if (this.status >= 400) {
            console.log(xhr.responseText);
        }
    };

    xhr.send(data);

    

}