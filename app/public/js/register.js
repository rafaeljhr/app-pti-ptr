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
            first_name_valid: false,
            last_name_valid: false,
            telephone_valid: false,
            morada_valid: false,
            cidade_valid: false,
            codigo_postal_valid: false,
            numero_contribuinte_valid: false,
            diff_password: 'yes',
            form_valid: false,
            user_google_id: null,
            current_tab: 0,
            back_track: false,
            tabs: document.getElementsByClassName("tab"),
            steps: document.getElementsByClassName("step"),
        }
    },

    mounted() {
        if (document.getElementById("user_google_id").name == 1) {
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
        
            if (n == 4) {
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

            if (this.back_track == true) {
                this.form_valid = true;
            } else {
                this.form_valid = false;
            }

            if (n == 1 && !(this.validateForm())) return false;
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
                    this.$refs.primeiro_nome.value = "";
                    this.$refs.userInputEmail.value = this.$refs.userEmail.value;
                    
                }
        
            } else if (this.current_tab == 2) {
                this.$refs.header.innerHTML = "PALAVRA-PASSE";
            } else if (this.current_tab == 3){
                this.$refs.header.innerHTML = "ADICIONE UMA FOTOGRAFIA";
            } else {
                this.$refs.header.innerHTML = "CONFIRMAR OS DADOS";
                this.$refs.userInputEmail2.value = this.$refs.userEmail.value;    
                this.$refs.user_conta2.value = this.$refs.user_conta.value;    
                this.$refs.primeiro_nome2.value = this.$refs.primeiro_nome.value;    
                this.$refs.ultimo_nome2.value = this.$refs.ultimo_nome.value;
                this.$refs.userTel2.value = this.$refs.userTel.value;
                this.$refs.user_numero_contribuinte2.value = this.$refs.user_numero_contribuinte.value;
                this.$refs.userMorada2.value = this.$refs.userMorada.value;
                this.$refs.userCidade2.value = this.$refs.userCidade.value;
                this.$refs.userCod_Postal_3.value = this.$refs.userCod_Postal_1.value;
                this.$refs.userCod_Postal_4.value = this.$refs.userCod_Postal_2.value;
                this.$refs.pais2.value = this.$refs.pais.value;
                document.getElementById("image_do_utilizador2").src = this.$refs.redUploadImagem.value;
                
            } 
        
            this.showTab(this.current_tab);
        },

        switchSelect(event) {
            if (event.target.value === "Consumidor") {
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
            if (this.$refs.primeiro_nome.value.length <= 0) {
                this.first_name_valid = false;
                
            } else {
                this.first_name_valid = true;
                
            }


            if (this.$refs.ultimo_nome.value.length <= 0) {
                this.last_name_valid = false;
                
            } else {
                this.last_name_valid = true;
                
            }


            if (isNaN(this.$refs.userTel.value)) {
                this.telephone_valid = false;
                
            } else {
                if (this.$refs.userTel.value.length == 9){
                    this.telephone_valid = true;
                    
                } else {
                    this.telephone_valid = false;
                    
                }
            }

            if (isNaN(this.$refs.user_numero_contribuinte.value)) {
                this.numero_contribuinte_valid = false;
                
            } else {
                if (this.$refs.user_numero_contribuinte.value.length == 9){
                    this.numero_contribuinte_valid = true;
                    
                } else {
                    this.numero_contribuinte_valid = false;
                    
                }
            } 

            if (this.$refs.userMorada.value.length <= 0) {
                this.morada_valid = false;
                
            } else {
                this.morada_valid = true;
                
            }


            if (this.$refs.userCidade.value.length <= 0) {
                this.cidade_valid = false;
                
            } else {
                this.cidade_valid = true;
                
            }


            if ((isNaN(this.$refs.userCod_Postal_1.value)) && (isNaN(this.$refs.userCod_Postal_2.value))) {
                this.codigo_postal_valid = false;
                
            } else {
                if ((this.$refs.userCod_Postal_1.value.length == 4) && (this.$refs.userCod_Postal_2.value.length == 3)){
                    this.codigo_postal_valid = true;
                    
                } else {
                    this.codigo_postal_valid = false;
                    
                }
            }
                
            if (this.first_name_valid === true &&
                this.last_name_valid === true &&
                this.telephone_valid === true &&  
                this.numero_contribuinte_valid === true && 
                this.morada_valid === true &&
                this.cidade_valid === true &&
                this.codigo_postal_valid === true) {
                this.form_valid = true;
            } else {
                this.form_valid = false;
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

            document.getElementById('user_input_email').disabled = false;

            setTimeout(function() {

                document.getElementById("regForm").submit();
                
            }, 3000)
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


function alterarImagemUser(event) {
    document.getElementById("image_do_utilizador").src=URL.createObjectURL(event.target.files[0]);
    document.getElementById('nextBtn').disabled = false;

}