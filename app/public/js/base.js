function criarUmaBase() {

    if (document.getElementById("fundoDivOpac").style.display == "block") {
        document.getElementById("fundoDivOpac").style.display = "none";
    } else {
        document.getElementById("fundoDivOpac").style.display = "block";
    }

    if (document.getElementById("criarUmaBase").style.display == "block") {
        document.getElementById("criarUmaBase").style.display = "none";
    } else {
        document.getElementById("spinnerAdicionarBase").style.display = "none";
        document.getElementById("but-pad").style.display = "block";
        document.getElementById("criarUmaBase").style.display = "block";
    }

}




function apagarArmazem(id){
    
    let route = document.getElementById("buttonApagarArmazem").name;

    

    var data = new FormData()
    data.append('id_armazem', id);

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', route, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            document.getElementById("deleteWarning").style.display = "none";
            document.getElementById("todosArmazensBefore").style.display = "none";
            
            document.getElementById("todosArmazensAfter").style.display = "block";
            document.getElementById("todosArmazensAfter").innerHTML = xhr.responseText;
            

        } else if (this.status >= 400) {
            console.log(xhr.responseText);
        }
};

    xhr.send(data);
    
}


function deleteWarning(id, nome){
    
    let route = document.getElementById("buttonApagarArmazemWarning").name;

    

    var data = new FormData()
    data.append('id_armazem', id);
    data.append('nome_armazem', nome);

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', route, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            document.getElementById("fundoDivOpac").style.display = "block";
            document.getElementById("deleteWarning").style.display = "block";
            document.getElementById("deleteWarning").innerHTML = xhr.responseText;
            
        } else if (this.status >= 400) {
            console.log(xhr.responseText);
        }
};

    xhr.send(data);
    
}


function infoAdicional(id, nome){
    
    let route = document.getElementById("storageInfo").name;

    

    var data = new FormData()
    data.append('id_armazem', id);
    data.append('nome_armazem', nome);

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', route, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            document.getElementById("storage_info").style.display = "block";
            document.getElementById("fundoDivOpac").style.display = "block";
            document.getElementById("prods").innerHTML = JSON.parse(xhr.responseText)[0];
            document.getElementById("info").innerHTML = JSON.parse(xhr.responseText)[1];
            

        } else if (this.status >= 400) {
            console.log(xhr.responseText);
        }
};

    xhr.send(data);
    
}





let app = Vue.createApp({
    data: function() {
        return {
            successCreate:false,
        }
    },
    methods: {
        closeInfo(){
            document.getElementById("fundoDivOpac").style.display = "none";
            document.getElementById("storage_info").style.display = "none";
        },

        closeSuccess(){

            document.getElementById("successCreate").style.display = "none";
        },

        criarBase(e){

            e.preventDefault();

            document.getElementById("but-pad").style.display = "none";
            document.getElementById("spinnerAdicionarBase").style.display = "block";

            var form = e.target
            var data = new FormData(form)
            console.log(form);
            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr1 = new XMLHttpRequest();
            xhr1.open(form.method, form.action, true)
            xhr1.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr1.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("todosArmazensBefore").style.display = "none";
                    document.getElementById("criarUmArmazem").style.display = "none";
                    document.getElementById("fundoDivOpac").style.display = "none";
                    document.getElementById("todosArmazensAfter").style.display = "block";
                    document.getElementById("todosArmazensAfter").innerHTML = xhr1.responseText;
                    
                    

                } else if (this.status >= 400) {
                    console.log(xhr1.responseText);
                }
            };

            xhr1.send(data);
            form.reset();
         
            
            },
    }
})

app.mount('.app')