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
        this.userName = this.$refs.userName.value; 
        this.userEmail = this.$refs.userEmail.value
        this.userTel = this.$refs.userTel.value;
        this.userNIF = this.$refs.userNIF.value;
        this.userAdress = this.$refs.userAdress.value;
    }
})

app.mount('.app')