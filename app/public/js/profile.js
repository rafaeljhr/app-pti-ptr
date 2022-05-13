let app = Vue.createApp({
    data: function() {
        return {
            userName: "",
            userEmail: "",
            userTel: "",
            userNIF: "",
            userAdress: "",
            editable: false,
            telephone_valid: true,
            nif_valid: true,
            pnome_valid: true,
            unome_valid: true,
            email_valid: true,
            pais_valid: true,
            morada_valid: true,
            codigo_postal_valid: true,
            cidade_valid: true,
        }
    },

    methods: {
        cancelChanges() {
            this.editable = false;
            this.$refs.userName.value = this.userName;
            this.$refs.userEmail.value = this.userEmail;
            this.$refs.userTel.value = this.userTel;
            this.$refs.userNIF.value = this.userNIF;
            this.$refs.userAdress.value = this.userAdress;
        },

        checkForm() {
            if (this.$refs.userPrimeiroNome.value.length > 0) {
                this.pnome_valid = true; 
            } else {
                this.pnome_valid = false; 
            }

            if (this.$refs.userUltimoNome.value.length > 0) {
                this.unome_valid = true; 
            } else {
                this.unome_valid = false; 
            }

            if (this.$refs.userUltimoNome.value.length > 0) {
                this.email_valid = true; 
            } else {
                this.email_valid = false; 
            }

            if (!(isNaN(this.$refs.userTel.value)) && (this.$refs.userTel.value.length > 0)) {
                this.telephone_valid = true;
            } else {
                this.telephone_valid = false;
            }

            if (!(isNaN(this.$refs.userNumContribuinte.value)) && (this.$refs.userNumContribuinte.value.length > 0)) {
                this.nif_valid = true;
            } else {
                this.nif_valid = false;
            } 

            if (this.$refs.userPais.value.length > 0) {
                this.pais_valid = true; 
            } else {
                this.pais_valid = false; 
            }
            
            if (this.$refs.userMorada.value.length > 0) {
                this.morada_valid = true; 
            } else {
                this.morada_valid = false; 
            }

            if (!(isNaN(this.$refs.userCodPostal_1.value)) && !(isNaN(this.$refs.userCodPostal_2.value)) && (this.$refs.userNumContribuinte.value.length > 0)) {
                this.codigo_postal_valid = true;
            } else {
                this.codigo_postal_valid = false;
            } 

            if (this.$refs.userCidade.value.length > 0) {
                this.cidade_valid = true; 
            } else {
                this.cidade_valid = false; 
            }
        }
    }, 

    mounted() {
        this.userName = this.$refs.userName.value; 
        this.userEmail = this.$refs.userEmail.value
        this.userTel = this.$refs.userTel.value;
        this.userNIF = this.$refs.userNIF.value;
        this.userAdress = this.$refs.userAdress.value;
    }
})

app.mount('.app')

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

function alterarImagemUser(event) {
    document.getElementById("titulo_image_do_utilizador").innerHTML = "Novo Avatar";
    document.getElementById("image_do_utilizador").src=URL.createObjectURL(event.target.files[0]);
    document.getElementById("submitChangeAvatar").style.display="block";
}
