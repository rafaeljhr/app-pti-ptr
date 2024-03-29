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
            userLatitude: 0,
            userLongitude: 0,
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
        this.userLatitude = this.$refs.latitude.value;
        this.userLongitude = this.$refs.longitude.value;

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
            this.$refs.userCidade.value = this.userLatitude;
            this.$refs.userCidade.value = this.userLongitude;
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
        },

        saveChanges(e) {
            e.preventDefault();

            if (this.$refs.userPais.value == this.userPais &&
                this.$refs.userMorada.value == this.userMorada &&
                this.$refs.userCodPostal_1.value == this.userCodPostal_1 &&
                this.$refs.userCodPostal_2.value == this.userCodPostal_2 &&
                this.$refs.userCidade.value == this.userCidade) {

                    document.getElementById("profileForm").submit();
            } else {
                
                var url = new URL("https://atlas.microsoft.com/search/address/json");
                var parameters = { 
                "subscription-key" : "rxjgLgUQ02QSSkv0NKBzj7q3gXP9HPCNyHfoE_DBNRc", 
                "api-version" : 1.0, 
                "language" : "pt-PT", 
                "query" : this.$refs.userMorada.value + "," + this.$refs.userCidade.value + "," + this.$refs.userCodPostal_1.value + "-" + this.$refs.userCodPostal_2.value};

                for (var p in parameters) {
                    url.searchParams.append(p, parameters[p]);
                }

                fetch(url)
                .then(response => response.json())
                .then(
                    data => {this.$refs.latitude.value = data["results"][0]["position"]["lat"];
                            this.$refs.longitude.value = data["results"][0]["position"]["lon"];})

                setTimeout(function() {

                    document.getElementById("profileForm").submit();
                    
                }, 3000)
            }
        },
    }, 
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
