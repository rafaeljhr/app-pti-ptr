let app = Vue.createApp({
    data: function() {
        return {
            userName: "",
            userEmail: "",
            userTel: "",
            userNIF: "",
            userAdress: "",
            editable: false
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