let app = Vue.createApp({
    data: function() {
        return {
            clientConsumer: true,
            password: null,
            password2: null,
            password_length: 0,
            contains_eight_characters: false,
            contains_number: false,
            contains_uppercase: false,
            contains_special_character: false,
            valid_password: false,
            strong_password: 'empty',
            telephone_valid: true,
            nif_valid: true,
            diff_password: 'empty',
        }
    },
    methods: {
        switchSelect(event) {
            if (event.target.value === "consumidor") {
                this.clientConsumer = true;
            } else {
                this.clientConsumer = false;
            }
        },

        strongPassword() {
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

            if (this.contains_eight_characters === true &&
                this.contains_special_character === true &&
                this.contains_uppercase === true &&
                this.contains_number === true) {
                this.strong_password = 'yes';
            } else if (this.password_length === 0) {
                this.strong_password = 'empty';
            } else {
                this.strong_password = 'no';
            }

            this.validPasswords();
        },

        equalPasswords() {
            if (this.password !== this.password2) {
                this.diff_password = 'yes';
            } else if (this.password2.length === 0) { 
                this.diff_password = 'empty';
            } else {
                this.diff_password = 'no';
            }

            this.validPasswords();
        },

        validPasswords() {
            if (this.strong_password === 'yes' &&
                this.diff_password === 'no') {
                    
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

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})