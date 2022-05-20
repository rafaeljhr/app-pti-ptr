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
            
            document.getElementById("fraseWarning").innerHTML = JSON.parse(xhr.responseText)[0];
            document.getElementById("buttonApagar").innerHTML = JSON.parse(xhr.responseText)[1];
            
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
        criarUmArmazem(){

        if (document.getElementById("fundoDivOpac").style.display == "block") {
            document.getElementById("fundoDivOpac").style.display = "none";
        } else {
            document.getElementById("fundoDivOpac").style.display = "block";
        }

        if (document.getElementById("criarUmArmazem").style.display == "block") {
            document.getElementById("criarUmArmazem").style.display = "none";
        } else {
            document.getElementById("spinnerAdicionarArmazem").style.display = "none";
            document.getElementById("but-pad").style.display = "block";
            document.getElementById("criarUmArmazem").style.display = "block";
        }

      
        },


        closeInfo(){
            document.getElementById("fundoDivOpac").style.display = "none";
            document.getElementById("storage_info").style.display = "none";
        },

        closeSuccess(){

            document.getElementById("successCreate").style.display = "none";
        },

        
    }
})

app.mount('.app')