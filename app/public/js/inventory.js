countProds = [];


function deleteWarning(id, nome){
    
    route = document.getElementById("buttonApagarProdutoWarning").name;
    data = new FormData()
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

function countCompare(id){
    
    console.log(this.editable);
    if(document.getElementsByName(id)[0].checked == true){
        countProds.push(id);
    }else{
        index = countProds.indexOf(id);
        countProds.splice(index, 1);
    }
    console.log(countProds);
    if(countProds.length < 2 || countProds.length > 2){
        document.getElementById("guardar_alteracoes").disabled = true;
    }else{
        document.getElementById("guardar_alteracoes").disabled = false;
    }
}

 




let app = Vue.createApp({


    data() {
        return {
            
            armazemAddDiv:false,
            fundoDiv: false,
            fundoDivOpac:false,
            cadeiaDiv:false,
            editable: false,
            computadores:false,
            mobilidade:false,
            componentes:false,
            perifericos:false,
        }
    },
    methods: {


       

        cancelCompare(){
            this.editable = false;
            console.log(this.editable);
            document.getElementById("compareForm").reset();
            countProds.splice(0, countProds.length)
            
        },


        searchCat(e){
            
            
            e.preventDefault();

            
            var form = e.target
            var data = new FormData(form)

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr1 = new XMLHttpRequest();
            xhr1.open(form.method, form.action, true)
            xhr1.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr1.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("prodDisplay").innerHTML = xhr1.responseText;
                    console.log('mudou');


                } else if (this.status >= 400) {
                    console.log(xhr1.responseText);
                }
            };

            xhr1.send(data);

                      
            
        },


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
            console.log(filter.target.value);
            if(filter.target.value == 'reset'){
                data.append('id_armazem', -1);
            }else{
                data.append('id_armazem', filter.target.value);
            }
            

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr = new XMLHttpRequest();
            xhr.open('POST', route, true)
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("prodDisplay").innerHTML = xhr.responseText;
                    

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


