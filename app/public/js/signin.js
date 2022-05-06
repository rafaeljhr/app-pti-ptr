let app = Vue.createApp({
    data: function() {
        return {
            email: null,
            password: null,
            validForm: false,
        }
    },
    methods: {
        validateForm() {
            if(this.email.length > 0 && this.password.length > 0) {
                this.validForm = true;
            }
        },

        validatePass() {
            if(this.password.length > 0) {
                this.validForm = true;
            }
        }
    }
})

app.mount('.app')