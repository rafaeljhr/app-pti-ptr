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

     


        cancelChanges() {
            this.editable = false;
            this.$refs.nome.value = this.nome;
            this.$refs.preco.value = this.preco;
            this.$refs.quantidade.value = this.quantidade;
            this.$refs.data_p.value = this.data_p;
            this.$refs.data_i.value = this.data_i;

            this.$refs.kwh.value = this.kwh;
            this.$refs.info.value = this.info;
        },

        checkForm() {

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
            console.log(this.$refs.quantidade.value);
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
                && this.$refs.kwh.value == this.kwh && this.$refs.data_p.value == this.data_p)) {
                    document.getElementById("guardar_alteracoes").disabled = false;
            } else {
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

        this.kwh = this.$refs.kwh.value;
        this.info = this.$refs.info.value;
        
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