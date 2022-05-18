
window.onload = function () {
    if (document.getElementById("menu_perfil_utilizador")) {
        document.getElementById("menu_perfil_utilizador").style.display = "block";
    }
    
};



function apagarNotificacao(id, route){

    document.getElementById("numNotificacoes").innerHTML = parseInt(document.getElementById("numNotificacoes").innerHTML)-1;

    document.getElementById("li_"+id).remove();
    if (document.getElementById("hr_"+id)) {
        document.getElementById("hr_"+id).remove();
    }

    if (parseInt(document.getElementById("numNotificacoes").innerHTML) == 0) {

        var ul = document.getElementById("notificationsDiv");

        var li = document.createElement("li");
        li.classList.add('notificationElement', 'mt-3', 'text-center');

        var p = document.createElement("p");
        p.classList.add('textoNotificacao');

        p.appendChild(document.createTextNode("Não possui notificações!"));
        li.appendChild(p);
        ul.appendChild(li);

    }

    var data = new FormData();
    data.append("id", id);
    console.log(id);
    console.log(route);

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let xhr = new XMLHttpRequest();

    xhr.open("POST", route, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            console.log(xhr.responseText);
        } else if (this.status >= 400) {
            console.log(xhr.responseText);
        }
    };

    xhr.send(data);

}