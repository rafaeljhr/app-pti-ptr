let app = Vue.createApp({
    data: function() {
        return {
            userPrimeiroNome: "",
            userUltimoNome: "",
            userEmail: "",
            userTel: "",
            userNumContribuinte: "",
            userPais: "",
            userMorada: "",
            userCodPostal_1: "",
            userCodPostal_2: "",
            userCidade: "",
            editable: false,
            telephone_valid: true,
            nif_valid: true,
        }
    },

    methods: {
        cancelChanges() {
            this.editable = false;
            this.$refs.userPrimeiroNome.value = this.userPrimeiroNome;
            this.$refs.userUltimoNome.value = this.userUltimoNome;
            this.$refs.userEmail.value = this.userEmail;
            this.$refs.userTel.value = this.userTel;
            this.$refs.userNumContribuinte.value = this.userNumContribuinte;
            this.$refs.userPais.value = this.userPais;
            this.$refs.userMorada.value = this.userMorada;
            this.$refs.userCodPostal_1.value = this.userCodPostal_1;
            this.$refs.userCodPostal_2.value = this.userCodPostal_2;
            this.$refs.userCidade.value = this.userCidade;
        },

        checkForm() {
            if (isNaN(this.$refs.userTel.value)) {
                this.telephone_valid = false;
            } else {
                this.telephone_valid = true;
            }

            if (isNaN(this.$refs.userNIF.value)) {
                this.nif_valid = false;
            } else {
                this.nif_valid = true;
            } 
        }
    }, 

    mounted() {
        this.userPrimeiroNome = this.$refs.userPrimeiroNome.value;
        this.userUltimoNome = this.$refs.userUltimoNome.value;
        this.userEmail = this.$refs.userEmail.value;
        this.userTel = this.$refs.userTel.value;
        this.userNumContribuinte = this.$refs.userNumContribuinte.value;
        this.userPais = this.$refs.userPais.value;
        this.userMorada = this.$refs.userMorada.value;
        this.userCodPostal_1 = this.$refs.userCodPostal_1.value;
        this.userCodPostal_2 = this.$refs.userCodPostal_2.value;
        this.userCidade = this.$refs.userCidade.value;
    }
})

app.mount('.app')

function alterarImagemUser(event) {
    document.getElementById("titulo_image_do_utilizador").innerHTML = "Novo Avatar";
    document.getElementById("image_do_utilizador").src=URL.createObjectURL(event.target.files[0]);
    document.getElementById("submitChangeAvatar").style.display="block";
}