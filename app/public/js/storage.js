function  criarUmArmazem(){

    if (document.getElementById("fundoDivOpac").style.display == "block") {
        console.log('ola1');
        document.getElementById("fundoDivOpac").style.display = "none";
    } else {
        document.getElementById("fundoDivOpac").style.display = "block";
    }

    if (document.getElementById("criarUmArmazem").style.display == "block") {
        console.log('ola');
        document.getElementById("criarUmArmazem").style.display = "none";
    } else {
        
        document.getElementById("but-pad").style.display = "block";
        document.getElementById("criarUmArmazem").style.display = "block";
    }

  
};


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

        finishForm(e) {
            e.preventDefault();
            
            var url = new URL("https://atlas.microsoft.com/search/address/json");
            var parameters = { 
                "subscription-key" : "rxjgLgUQ02QSSkv0NKBzj7q3gXP9HPCNyHfoE_DBNRc", 
                "api-version" : 1.0, 
                "language" : "pt-PT", 
                "query" : document.getElementById("morada").value + "," + document.getElementById("cidade").value + "," + document.getElementById("codigo_postal_1").value + "-" + document.getElementById("codigo_postal_2").value};

            for (var p in parameters) {
                url.searchParams.append(p, parameters[p]);
            }

            fetch(url)
            .then(response => response.json())
            .then(
                data => {this.$refs.latitude.value = data["results"][0]["position"]["lat"];
                         this.$refs.longitude.value = data["results"][0]["position"]["lon"];})

            setTimeout(function() {

                document.getElementById("storageForm").submit();
            
            }, 3000) 
        },
    }
})

app.mount('#app')