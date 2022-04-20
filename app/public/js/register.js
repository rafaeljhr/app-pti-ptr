let app = Vue.createApp({
    data: function() {
        return {
            clientConsumer: true,
            password: null,
            password_length: 0,
            contains_eight_characters: false,
            contains_number: false,
            contains_uppercase: false,
            contains_special_character: false,
            valid_password: false,
            telephone_valid: true,
            nif_valid: true,
            diff_password: false,
        }
    },
    methods: {
        switchSelect(event) {
            if (event.target.value == "consumidor") {
                this.clientConsumer = true;
            } else {
                this.clientConsumer = false;
            }
        },

        checkPassword() {
            this.password_length = this.password.length;
            const format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
                  
            if (this.password_length > 8) {
                this.contains_eight_characters = true;
            } else {
                this.contains_eight_characters = false;
            }
                  
            this.contains_number = /\d/.test(this.password);

            this.contains_uppercase = /[A-Z]/.test(this.password);

            this.contains_special_character = format.test(this.password);

            if (this.password == this.password2) {
                this.diff_password = false;
            } else {
                this.diff_password = true;
            }
            
            if (this.contains_eight_characters === true &&
                this.contains_special_character === true &&
                this.contains_uppercase === true &&
                this.contains_number === true &&
                this.diff_password === false) {
                    
                this.valid_password = true;			
            } else {
                this.valid_password = false;
            }
          
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
    }
})

app.mount('.app')
