let app = Vue.createApp({
    data: function() {
        return {
            nome: "",
            tipo_combustivel: "",
            consumo_por_100km: "",
            base: "",
            quantidade: "",
            editable: false,
            nome_valid: true,
            consumo_por_100km_valid: true,
            quantidade_valid: true,
        }
    },

    methods: {
        cancelChanges() {
            this.editable = false;
            this.$refs.nome.value = this.nome;
            this.$refs.consumo_por_100km.value = this.consumo_por_100km;
            this.$refs.quantidade.value = this.quantidade;
            this.$refs.tipo_combustivel.value = this.tipo_combustivel;
            this.$refs.base.value = this.base;
        },

        checkForm() {

            if (this.$refs.nome.value.length > 0) {
                this.nome_valid = true; 
            } else {
                this.nome_valid = false; 
            }

            if (!(isNaN(this.$refs.quantidade.value)) && (this.$refs.quantidade.value > 0)) {
                this.quantidade_valid = true;
            } else {
                this.quantidade_valid = false;
            }

            if (!(isNaN(this.$refs.consumo_por_100km.value)) && (this.$refs.consumo_por_100km.value > 0)) {
                this.consumo_por_100km_valid = true;
            } else {
                this.consumo_por_100km_valid = false;
            }

            if (this.nome_valid && this.quantidade_valid && this.consumo_por_100km_valid &&
                !(this.$refs.nome.value == this.nome && this.$refs.consumo_por_100km.value == this.consumo_por_100km && 
                    this.$refs.quantidade.value == this.quantidade && this.$refs.tipo_combustivel.value == this.tipo_combustivel && 
                    this.$refs.base.value == this.base)) {
                        document.getElementById("guardar_alteracoes").disabled = false;
            } else {
                document.getElementById("guardar_alteracoes").disabled = true;
            }
        }
    }, 

    mounted() {
        this.nome = this.$refs.nome.value;
        this.consumo_por_100km = this.$refs.consumo_por_100km.value;
        this.quantidade = this.$refs.quantidade.value;
        this.tipo_combustivel = this.$refs.tipo_combustivel.value;
        this.base = this.$refs.base.value;
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
