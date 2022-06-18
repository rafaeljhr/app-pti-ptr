let app = Vue.createApp({
    data: function() {
        return {
            nome: "",
            co2: "",
            kwh: "",
            desc: "",
            editable: false,
            nome_valid: true,
            co2_valid: true,
            kwh_valid: true,
            desc_valid: true,
        }
    },

    methods: {
        cancelChanges() {
            this.editable = false;
            this.$refs.nome.value = this.nome;
            this.$refs.co2.value = this.co2;
            this.$refs.kwh.value = this.kwh;
            
            this.$refs.cidade.value = this.cidade;
        },

        checkForm() {

            if (this.$refs.nome.value.length > 0) {
                this.nome_valid = true; 
            } else {
                this.nome_valid = false; 
            }

            if (this.$refs.co2.value > 0) {
                this.co2_valid = true; 
            } else {
                this.co2_valid = false; 
            }
            
            if (this.$refs.kwh.value > 0) {
                this.kwh_valid = true; 
            } else {
                this.kwh_valid = false; 
            }

            

            if (this.$refs.desc.value.length > 0) {
                this.desc_valid = true; 
            } else {
                this.desc_valid = false; 
            }

            if (this.desc_valid && this.kwh_valid &&
                this.co2_valid && this.nome_valid &&
                !(this.$refs.nome.value == this.nome && this.$refs.co2.value == this.co2 
                && this.$refs.kwh.value == this.kwh && this.$refs.desc.value == this.desc)) {
                    document.getElementById("guardar_alteracoes").disabled = false;
            } else {
                document.getElementById("guardar_alteracoes").disabled = true;
            }
        }
    }, 

    mounted() {
        this.nome = this.$refs.nome.value;
        this.co2 = this.$refs.co2.value;
        this.kwh = this.$refs.kwh.value;
        this.desc = this.$refs.desc.value;
    }
})

app.mount('.app')

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

