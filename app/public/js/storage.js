function apagarArmazem(id){
    let route = document.getElementById("buttonApagarArmazem").name;

    document.getElementById("buttonApagarArmazem").style.display = "none";
    document.getElementById(id).removeAttribute("hidden");

    var data = new FormData()
    data.append('id_armazem', id);

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', route, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            document.getElementById("todosArmazensBefore").style.display = "none";
            
            document.getElementById("todosArmazensAfter").style.display = "block";
            document.getElementById("todosArmazensAfter").innerHTML = xhr.responseText;
            

        } else if (this.status >= 400) {
            console.log(xhr.responseText);
        }
};

    xhr.send(data);
    
}



function fadeOutEffect() {
    var fadeTarget = document.getElementById("successCreate");
    var fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
        }
    }, 200);
}


let app = Vue.createApp({
    data: function() {
        return {
            successCreate:false,
        }
    },
    methods: {
        criarUmArmazem(){

        if (document.getElementById("fundoDivOpac").style.display == "block") {
            document.getElementById("fundoDivOpac").style.display = "none";
        } else {
            document.getElementById("fundoDivOpac").style.display = "block";
        }

        if (document.getElementById("criarUmArmazem").style.display == "block") {
            document.getElementById("criarUmArmazem").style.display = "none";
        } else {
            document.getElementById("criarUmArmazem").style.display = "block";
        }




        
        },

        criarArmazem(e){

            e.preventDefault();

            document.getElementById("but-pad").style.display = "none";
            document.getElementById("spinnerAdicionarArmazem").style.display = "block";

            var form = e.target
            var data = new FormData(form)

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr1 = new XMLHttpRequest();
            xhr1.open(form.method, form.action, true)
            xhr1.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr1.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("apresentarArmazensBefore").style.display = "none";
                    document.getElementById("todosArmazens").style.display = "block";
                    document.getElementById("apresentarArmazens").style.display = "block";
                    document.getElementById("apresentarArmazens").innerHTML = xhr1.responseText;
                    document.getElementById("criarUmArmazem").style.display = "none";
                    

                } else if (this.status >= 400) {
                    console.log(xhr1.responseText);
                }
            };

            xhr1.send(data);



            
            
            },
    }
})

app.mount('.app')