
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


function showInfoProduct(id){
        
    let route = document.getElementById("showProductInfo").name;

    var data = new FormData()
    data.append('id_produto', id);
    
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', route, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            document.getElementById("fundoDivOpac").style.display = "block";
            document.getElementById("infoAdicional").style.display = "block";
            document.getElementById("produtoArmazens").style.display = "block";
            document.getElementById("produtoArmazens").innerHTML = JSON.parse(xhr.responseText)[0];
            document.getElementById("produtoCadeias").style.display = "block";
            document.getElementById("produtoCadeias").innerHTML = JSON.parse(xhr.responseText)[1];
            document.getElementById("descriptionGeral").style.display = "block";
            document.getElementById("descriptionGeral").innerHTML = JSON.parse(xhr.responseText)[2];
         
            

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
        

        criarProduto(e){

            document.getElementById("productForm").style.display = "none";
            document.getElementById("todaCadeiaLogistica").style.display = "block";

            e.preventDefault();

            var form = e.target
            var data = new FormData(form)
            
            for(var pair of data.entries()) {
                console.log(pair[0]+ ', '+ pair[1]);
             }
            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action, true)
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {

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

        apagarUltimoProduto(e){

            document.getElementById("mostrarCadeiaLogistica").innerHTML = "";
            document.getElementById("productForm").style.display = "block";
            document.getElementById("todaCadeiaLogistica").style.display = "none";

            e.preventDefault();

            var form = e.target
            var data = new FormData(form)

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action, true)
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    

                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };

            xhr.send(data);

        },

        criarEvento(e){

            document.getElementById("botaoAdicionarEvento").style.display = "none";
            document.getElementById("spinnerAdicionarEvento").style.display = "block"
            

            e.preventDefault();

            var form = e.target
            var data = new FormData(form)
            

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action, true)
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("todaCadeiaLogistica").style.display = "block";
                    document.getElementById("mostrarCadeiaLogistica").innerHTML = xhr.responseText;
                    document.getElementById("criarUmaCadeiaLogistica").style.display = "none";
                    

                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };

            xhr.send(data);


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

        
        
        
        finalizarAdicaoProduto() {

            if (document.getElementById("todaCadeiaLogistica").style.display == "block") {
                document.getElementById("todaCadeiaLogistica").style.display = "none";
            } else {
                document.getElementById("todaCadeiaLogistica").style.display = "block";
            }

            if (document.getElementById("fundoDivOpac").style.display == "block") {
                document.getElementById("fundoDivOpac").style.display = "none";
            } else {
                document.getElementById("fundoDivOpac").style.display = "block";
            }

            location.reload();
         
        },

        criarUmaCadeiaLogistica() {

            if (document.getElementById("criarUmaCadeiaLogistica").style.display == "block") {
                document.getElementById("criarUmaCadeiaLogistica").style.display = "none";
            } else {
                document.getElementById("criarUmaCadeiaLogistica").style.display = "block";
            }


            if (document.getElementById("spinnerAdicionarEvento").style.display == "block") {
                document.getElementById("spinnerAdicionarEvento").style.display = "none";
                document.getElementById("botaoAdicionarEvento").style.display = "block";
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

        mostrarRegistoCo2() {
            if (document.getElementById('co2quantidade').style.display == "block") {
                document.getElementById('co2quantidade').style.display = 'none';
            } else {
                document.getElementById('co2quantidade').style.display = 'block';
            }
        },

        mostrarRegistoKWh() {
            if (document.getElementById('kwhquantidade').style.display == "block") {
                document.getElementById('kwhquantidade').style.display = 'none';
            } else {
                document.getElementById('kwhquantidade').style.display = 'block';
            }
        },

       

    },
})

app.mount('.app')


