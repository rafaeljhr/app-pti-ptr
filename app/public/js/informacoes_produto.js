let app = Vue.createApp({
    data: function() {
        return {
            nome: "",
            preco: "",
            quantidade: "",
            data_p: "",
            data_i: "",
            kwh: "",
            info: "",
            
            cat:"",
            subcat:"",
            editable: false,

            nome_valid: true,
            preco_valid: true,
            quantidade_valid: true,
            data_p_valid: true,
            data_i_valid: true,
            kwh_valid:true,
            info_valid:true,
        }
    },

    methods: {


        

        changeSubcat(cat){
               
                    
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
                   
                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };
        
            xhr.send(data);
            
                      
            
        },


        cancelChanges() {
            this.editable = false;
            this.$refs.nome.value = this.nome;
            this.$refs.preco.value = this.preco;
            this.$refs.quantidade.value = this.quantidade;
            this.$refs.data_p.value = this.data_p;
            this.$refs.data_i.value = this.data_i;
            this.$refs.cat.value = this.cat;
            console.log(this.subcat);
            /* this.$refs.subcat.value = this.subcat; */
            selectBox = document.getElementById("novo_produto_subcategoria");
            newOption = new Option(this.subcat,this.subcat);
            selectBox.add(newOption,undefined);
            document.querySelector('#novo_produto_subcategoria').value = this.subcat;
            document.getElementById("novo_produto_subcategoria").disabled = true;
            this.$refs.kwh.value = this.kwh;
            this.$refs.info.value = this.info;
        },

        checkForm() {
            if(this.$refs.cat.value != this.cat){
                document.getElementById("camposExtraNone").style.display = "none";
            }else{
                document.getElementById("camposExtraNone").style.display = "block";
            }
            
            
    
            if (this.$refs.nome.value.length > 0) {
                this.nome_valid = true; 
            } else {
                this.nome_valid = false; 
            }

            if (this.$refs.preco.value > 0) {
                this.preco_valid = true; 
            } else {
                this.preco_valid = false; 
            }
            
            if (this.$refs.quantidade.value > 0) {
                this.quantidade_valid = true; 
            } else {
                this.quantidade_valid = false; 
            }
            listaData  =  this.$refs.data_p.value.split('-');
            
            if (listaData[0] > 0 && listaData[1] > 0  &&  listaData[2] > 0) {
                this.data_p_valid = true; 
            } else {
                
                this.data_p_valid = false; 
            }

            listaData1  =  this.$refs.data_i.value.split('-');
            
            if (listaData1[0] > 0 && listaData1[1] > 0  &&  listaData1[2]>0) {
                this.data_i_valid = true; 
            } else {
                

                this.data_i_valid = false; 
            }

            if (this.$refs.kwh.value > 0) {
                this.kwh_valid = true; 
            } else {
                this.kwh_valid = false; 
            }

            if (this.$refs.info.value.length > 0) {
                this.info_valid = true; 
            } else {
                this.info_valid = false; 
            }


      

            if (this.data_p_valid && this.quantidade_valid && this.preco_valid &&
                this.info_valid && this.nome_valid &&  this.data_i_valid && this.kwh_valid &&
                !(this.$refs.nome.value == this.nome && this.$refs.preco.value == this.preco 
                && this.$refs.data_i.value==this.data_i && this.$refs.quantidade.value == this.quantidade && this.$refs.info.value == this.info
                && this.$refs.kwh.value == this.kwh && this.$refs.data_p.value == this.data_p &&  this.$refs.cat.value == this.cat)) {
                    console.log('ola3');
                    document.getElementById("guardar_alteracoes").disabled = false;
            } else {
                console.log('ola4');
                document.getElementById("guardar_alteracoes").disabled = true;
            }
        }
    }, 

    mounted() {
        this.nome = this.$refs.nome.value;
        this.preco = this.$refs.preco.value;
        this.quantidade = this.$refs.quantidade.value;
        this.data_p = this.$refs.data_p.value;
        this.data_i = this.$refs.data_i.value;
        this.subcat = this.$refs.subcat.value;
        this.cat = this.$refs.cat.value;
        this.kwh = this.$refs.kwh.value;
        this.info = this.$refs.info.value;
        console.log(this.cat);
        
    }
})

app.mount('.app')

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

function alterarImagem(event) {
    document.getElementById("titulo_imagem").innerHTML = "Novo Avatar";
    document.getElementById("imagem_a_alterar").src=URL.createObjectURL(event.target.files[0]);
    document.getElementById("submitChangeAvatar").style.display="block";
}