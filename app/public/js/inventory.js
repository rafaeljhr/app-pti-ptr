function apagarProduto(id){
    let route = document.getElementById("buttonApagarProduto").name;

    var data = new FormData()
    data.append('id_produto', id);

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
            document.getElementById("todosArmazens").style.display = "block";
            
            document.getElementById("apresentarArmazens").innerHTML = xhr.responseText;
            

        } else if (this.status >= 400) {
            console.log(xhr.responseText);
        }
};

    xhr.send(data);
    console.log(id);
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

        criarProduto(e){

            document.getElementById("productForm").style.display = "none";
            document.getElementById("todaCadeiaLogistica").style.display = "block";

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
            document.getElementById("spinnerAdicionarEvento").style.display = "block";
            

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

        changeSubcat(cat){
            if(cat.target.value=="computadores"){
                this.computadores=!this.computadores;
                if(this.mobilidade==true){
                    this.mobilidade=!this.mobilidade;
                }
                if(this.componentes==true){
                    this.componentes=!this.componentes;
                }
                if(this.perifericos==true){
                    this.perifericos=!this.perifericos;
                }
                
                
                
            }
            if(cat.target.value=="mobilidade"){
                this.mobilidade=!this.mobilidade;
                if( this.computadores==true){
                    this.computadores=!this.computadores;
                }
                if(this.componentes==true){
                    this.componentes=!this.componentes;
                }
                if(this.perifericos==true){
                    this.perifericos=!this.perifericos;
                }
                
            }
            if(cat.target.value=="componentes"){
                this.componentes=!this.componentes;
                if( this.computadores==true){
                    this.computadores=!this.computadores;
                }
                if(this.mobilidade==true){
                    this.mobilidade=!this.mobilidade;
                }
                
                if(this.perifericos==true){
                    this.perifericos=!this.perifericos;
                }
                
            }
            if(cat.target.value=="periféricos"){
                this.perifericos=!this.perifericos;
                if( this.computadores==true){
                    this.computadores=!this.computadores;
                }
                if(this.mobilidade==true){
                    this.mobilidade=!this.mobilidade;
                }
                if(this.componentes==true){
                    this.componentes=!this.componentes;
                }                
                
            }
        },  
        
        
        criarArmazem(e){

            document.getElementById("but-pad").style.display = "none";
            document.getElementById("spinnerAdicionarArmazem").style.display = "block";
            

            e.preventDefault();

            var form = e.target
            var data = new FormData(form)

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr1 = new XMLHttpRequest();
            xhr1.open(form.method, form.action, true)
            xhr1.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr1.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("todosArmazens").style.display = "block";
                    
                    document.getElementById("apresentarArmazens").innerHTML = xhr1.responseText;
                    document.getElementById("criarUmArmazem").style.display = "none";
                    

                } else if (this.status >= 400) {
                    console.log(xhr1.responseText);
                }
            };

            xhr1.send(data);
            },

        

        criarUmArmazem(){

            if (document.getElementById("criarUmArmazem").style.display == "block") {
                document.getElementById("criarUmArmazem").style.display = "none";
            } else {
                document.getElementById("criarUmArmazem").style.display = "block";
            }

        },

        mostrarArmazens(){

            if (document.getElementById("fundoDivOpac").style.display == "block") {
                document.getElementById("fundoDivOpac").style.display = "none";
            } else {
                document.getElementById("fundoDivOpac").style.display = "block";
            }

            if (document.getElementById("todosArmazens").style.display == "block") {
                document.getElementById("todosArmazens").style.display = "none";
            } else {
                document.getElementById("todosArmazens").style.display = "block";
            }

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
                document.getElementById("productForm").style.display = "none";
            } else {
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

        mostrarCriarArmazem() {
            if (document.getElementById('criarUmArmazem').style.display == "block") {
                document.getElementById('criarUmArmazem').style.display = 'none';
            } else {
                document.getElementById('criarUmArmazem').style.display = 'block';
                document.getElementById("but-pad").style.display = "block";
                document.getElementById("spinnerAdicionarArmazem").style.display = "none";    
            }

        },

    },
})

app.mount('.app')


