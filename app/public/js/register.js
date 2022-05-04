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
            strong_password: 'no',
            telephone_valid: false,
            morada_valid: false,
            nif_valid: false,
            diff_password: 'yes',
            form_valid: false,
            user_google_id: null,
            current_tab: null,
            tabs: document.getElementsByClassName("tab"),
            steps: document.getElementsByClassName("step"),
        }
    },

    mounted() {
        if ((this.user_google_id) != null) {
            this.current_tab = 1;
        } else {
            this.current_tab = 0;
        }

        this.showTab(this.current_tab);
    },

    methods: {
        showTab(n) {

            this.tabs[n].style.display = "block";
        
            if (n == 0) {
                this.$refs.prevBtn.style.display = "none";
                this.$refs.all_steps.style.display = "none";
        
            } else {
                this.$refs.prevBtn.style.display = "block";
                this.$refs.all_steps.style.display = "block";
        
            }
        
            if (n == 3) {
                this.$refs.nextBtn.style.display = "none";
                this.$refs.btn_finalizar.style.display = "block";
                
            } else {
                if (this.$refs.btn_finalizar.style.display == "block") {
                    this.$refs.nextBtn.style.display = "block";
                    this.$refs.btn_finalizar.style.display = "none";
                }
            
                this.$refs.nextBtn.innerHTML = "Seguinte";
            }

            this.fixStepIndicator(n)
        },

        fixStepIndicator(n) { 
            for (var i=0; i < this.steps.length; i++) { 
                this.steps[i].className = this.steps[i].className.replace(" active", "" ); 
            } 

            this.steps[n].className += " active"; 
        },

        nextPrev(n) {
            this.form_valid = false;

            if (n == 1 && !(this.validateForm())) return false; // PORQUE RETURN FALSE?
            this.tabs[this.current_tab].style.display = "none";
            this.current_tab = this.current_tab + n;
        
            if (this.current_tab == 0) {
                this.$refs.header.innerHTML = "REGISTAR"; 
        
                this.$refs.userEmail.value = "";
        
                let current_url = window.location.href;
                let url = current_url.substring(0, current_url.length - 8);
                url=url+"forget-google-user";
        
                let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
                var request = new XMLHttpRequest();
                request.open('get', url);
                request.setRequestHeader('X-CSRF-TOKEN', csrf);
        
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                        // console.log(request.responseText);
                    } else if (this.status >= 400) {
                        // console.log("not ok");
                    }
                };
        
                request.send();
        
            } else if (this.current_tab == 1){
                this.$refs.header.innerHTML = "DADOS DA SUA CONTA";
        
                if (this.$refs.userEmail.value) {
                    this.$refs.userName.value = "";
        
                    if (this.$refs.userInputEmail.value) {
                        this.$refs.userInputEmail.value = this.$refs.userEmail.value;
                    } else{
                        this.$refs.userInputEmail.value = this.$refs.userEmail.value;
                    }
                    
                }
        
            } else if (this.current_tab == 2) {
                this.$refs.header.innerHTML = "PALAVRA-PASSE";
            } else {
                this.$refs.header.innerHTML = "ADICIONE UMA FOTOGRAFIA";
            }
        
            this.showTab(this.current_tab);
        },

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
        },

        equalPasswords() {
            
            if (this.password !== this.password2) {
                this.diff_password = 'yes';
            } else if (this.password2.length === 0) { 
                this.diff_password = 'yes';
            } else {
                this.diff_password = 'no';
            }
        },

        validPasswords() {

            this.strongPassword();
            this.equalPasswords();

            if (this.strong_password === 'yes' &&
                this.diff_password === 'no') {
                    this.form_valid = true;
            }
        },

        checkForm() {
            if (isNaN(this.$refs.userTel.value)) {
                this.telephone_valid = false;
                
            } else {
                if (this.$refs.userTel.value.length == 9){
                    this.telephone_valid = true;
                    
                } else {
                    this.telephone_valid = false;
                    
                }
            }

            if (isNaN(this.$refs.userNIF.value)) {
                this.nif_valid = false;
                
            } else {
                if (this.$refs.userNIF.value.length == 9){
                    this.nif_valid = true;
                    
                } else {
                    this.nif_valid = false;
                    
                }
            } 

            if (this.$refs.userMorada.value.length <= 0) {
                this.morada_valid = false;
                
            } else {
                this.morada_valid = true;
                
            }
                
            if (this.telephone_valid === true &&  
                this.nif_valid === true && 
                this.morada_valid === true) {
                this.form_valid = true;
            }
        },
        
        checkEmail() {
            
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.$refs.userEmail.value)){
                this.form_valid = true;
            } else {
                this.form_valid = false;
            }
        },

        finalizarRegisto(e) {
            e.preventDefault();

            this.$refs.text_message.style.display = "block";
            this.$refs.next_previous.style.display = "none";
            this.$refs.all_steps.style.display = "none";
            this.$refs.tab_imagem.style.display = "none";
            this.$refs.header.innerHTML = "";


            setTimeout(function() {

                document.getElementById("regForm").submit();
                
            }, 1000)
        },

        validateForm() {

            var valid = true;

            var y = this.tabs[this.current_tab].getElementsByTagName("input");
            for (var i = 0; i < y.length; i++) { 
                if (y[i].value=="" ) { 
                    y[i].className +=" invalid" ; valid=false; 
                }} 
                if (valid) { 
                    this.steps[this.current_tab].className +=" finish" ; } 
                    return valid;
        } 
    },
})

app.mount('.app')

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
