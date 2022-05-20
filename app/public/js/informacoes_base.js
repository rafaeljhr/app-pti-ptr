let app = Vue.createApp({
    data: function() {
        return {
            nome: "",
            pais: "",
            morada: "",
            codigo_postal_1: "",
            codigo_postal_2: "",
            cidade: "",
            editable: false,
            nome_valid: true,
            morada_valid: true,
            codigo_postal_valid: true,
            cidade_valid: true,
        }
    },

    methods: {
        cancelChanges() {
            this.editable = false;
            this.$refs.nome.value = this.nome;
            this.$refs.pais.value = this.pais;
            this.$refs.morada.value = this.morada;
            this.$refs.codigo_postal_1.value = this.codigo_postal_1;
            this.$refs.codigo_postal_2.value = this.codigo_postal_2;
            this.$refs.cidade.value = this.cidade;
        },

        checkForm() {

            if (this.$refs.nome.value.length > 0) {
                this.nome_valid = true; 
            } else {
                this.nome_valid = false; 
            }

            if (this.$refs.pais.value.length > 0) {
                this.pais_valid = true; 
            } else {
                this.pais_valid = false; 
            }
            
            if (this.$refs.morada.value.length > 0) {
                this.morada_valid = true; 
            } else {
                this.morada_valid = false; 
            }

            if (!(isNaN(this.$refs.codigo_postal_1.value)) && !(isNaN(this.$refs.codigo_postal_2.value)) && 
            (this.$refs.codigo_postal_1.value.length == 4) && (this.$refs.codigo_postal_2.value.length == 3)) {
                this.codigo_postal_valid = true;
            } else {
                this.codigo_postal_valid = false;
            }

            if (this.$refs.cidade.value.length > 0) {
                this.cidade_valid = true; 
            } else {
                this.cidade_valid = false; 
            }

            if (this.cidade_valid && this.codigo_postal_valid && this.morada_valid &&
                this.pais_valid && this.nome_valid &&
                !(this.$refs.nome.value == this.nome && this.$refs.pais.value == this.pais 
                && this.$refs.morada.value == this.morada && this.$refs.codigo_postal_1.value == this.codigo_postal_1
                && this.$refs.codigo_postal_2.value == this.codigo_postal_2 && this.$refs.cidade.value == this.cidade)) {
                    document.getElementById("guardar_alteracoes").disabled = false;
            } else {
                document.getElementById("guardar_alteracoes").disabled = true;
            }
        }
    }, 

    mounted() {
        this.nome = this.$refs.nome.value;
        this.pais = this.$refs.pais.value;
        this.morada = this.$refs.morada.value;
        this.codigo_postal_1 = this.$refs.codigo_postal_1.value;
        this.codigo_postal_2 = this.$refs.codigo_postal_2.value;
        this.cidade = this.$refs.cidade.value;
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
