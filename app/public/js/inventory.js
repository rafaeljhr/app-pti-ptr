
function deleteWarning(id, nome){
    
    let route = document.getElementById("buttonApagarProdutoWarning").name;
    var data = new FormData()
    console.log(id);
    console.log(nome);
    data.append('id_produto', id);
    data.append('nome_produto', nome);

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


    data() {
        return {
            armazemAddDiv:false,
            fundoDiv: false,
            fundoDivOpac:false,
            cadeiaDiv:false,
            totalSteps:2,
            step:1,
            computadores:false,
            mobilidade:false,
            componentes:false,
            perifericos:false
        }
    },
    methods: {

        changeSubcat(cat){
            console.log(cat.target.value);    
                    
            let route = document.getElementById("routeSubCat").name;
            var data = new FormData()
            
            data.append('categoria', cat.target.value);
        
            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
            let xhr = new XMLHttpRequest();
            xhr.open('POST', route, true)
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
        
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("toChangeOnCmd").innerHTML = JSON.parse(xhr.responseText)[0];
                    document.getElementById("camposExtra").innerHTML = JSON.parse(xhr.responseText)[1];
        
                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };
        
            xhr.send(data);
                      
            
        },
        

        hideShowInfoProduct(){
            document.getElementById("fundoDivOpac").style.display = "none";
            document.getElementById("infoAdicional").style.display = "none";

        },

        


        filterStorage(filter){
            
            let route = filter.target.name;
            
            var data = new FormData()
            data.append('id_armazem', filter.target.value);

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr = new XMLHttpRequest();
            xhr.open('POST', route, true)
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("todosProdutos").innerHTML = xhr.responseText;
                    

                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };

            xhr.send(data);

        },

        

        criarUmaCadeiaLogistica() {

            if (document.getElementById("criarUmaCadeiaLogistica").style.display == "block") {
                document.getElementById("criarUmaCadeiaLogistica").style.display = "none";
            } else {
                document.getElementById("criarUmaCadeiaLogistica").style.display = "block";
            }
            if (document.getElementById("fundoDivOpac").style.display == "block") {
                document.getElementById("fundoDivOpac").style.display = "none";
            } else {
                document.getElementById("fundoDivOpac").style.display = "block";
            }

            

        },

        mostrarCriarProduto() {
            
            if (document.getElementById("productForm").style.display == "block") {
                console.log('aqui');
                document.getElementById("productForm").style.display = "none";
            } else {
                console.log('aqui1');
                document.getElementById("productForm").style.display = "block";
            }


            if (document.getElementById("fundoDivOpac").style.display == "block") {
                document.getElementById("fundoDivOpac").style.display = "none";
            } else {
                document.getElementById("fundoDivOpac").style.display = "block";
            }

        },
      

    },
})

app.mount('.app')


