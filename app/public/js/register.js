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
            strong_password: 'no',
            telephone_valid: false,
            morada_valid: false,
            nif_valid: false,
            email_valid: false,
            diff_password: 'yes',
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
                this.diff_password = 'yes';
            } else {
                this.diff_password = 'no';
            }

            this.validPasswords();
        },

        validPasswords() {
            if (this.strong_password === 'yes' &&
                this.diff_password === 'no') {
                    document.getElementById("nextBtn").disabled = false;
                this.valid_password = true;			
            } else {
                this.valid_password = false;
                
                if (currentTab ==2) {
                    document.getElementById("nextBtn").disabled = false;
                }
            }
        },

        checkForm() {
            if (isNaN(this.$refs.userTel.value)) {
                this.telephone_valid = false;
                
                document.getElementById("nextBtn").disabled = true;
            } else {
                if (this.$refs.userTel.value.length == 9){
                    this.telephone_valid = true;
                    document.getElementById("nextBtn").disabled = false;
                } else {
                    this.telephone_valid = false;
                    
                    document.getElementById("nextBtn").disabled = true;
                }
            }

            if (isNaN(this.$refs.userNIF.value)) {
                this.nif_valid = false;
                
                document.getElementById("nextBtn").disabled = true;
            } else {
                if (this.$refs.userNIF.value.length == 9){
                    this.nif_valid = true;
                    document.getElementById("nextBtn").disabled = false;
                } else {
                    this.nif_valid = false;
                    
                    document.getElementById("nextBtn").disabled = true;
                }
                
            } 

            if (this.$refs.userMorada.value.length <= 0) {
                this.morada_valid = false;
                
                document.getElementById("nextBtn").disabled = true;
            } else {
                if (this.$refs.userMorada.value.length > 0){
                    this.morada_valid = true;
                    document.getElementById("nextBtn").disabled = false;
                } else {
                    this.morada_valid = false;
                    
                    document.getElementById("nextBtn").disabled = true;
                }
                
            } 
        },


        checkEmail() {
            
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.$refs.userEmail.value)){
                
                this.email_valid = true;
                document.getElementById("nextBtn").disabled = false;
            } else {
                
                this.email_valid = false;
                document.getElementById("nextBtn").disabled = true;
            }
        },

        finalizarRegisto(e) {
            e.preventDefault();

            document.getElementById("text-message").style.display = "block";
            document.getElementById("nextprevious").style.display = "none";
            document.getElementById("all-steps").style.display = "none";
            document.getElementById("tab_da_imagem").style.display = "none";
            document.getElementById("registar").innerHTML = "";


            setTimeout(function() {

                document.getElementById("regForm").submit();
                
            }, 1000)
        }
    }
})

app.mount('.app')



/* FORM STEP BY STEP */



if (document.getElementById("user_google_id") != null) {
    var currentTab = 1;
} else {
    var currentTab = 0;
}

document.addEventListener("DOMContentLoaded", function(event) {

showTab(currentTab);

});

function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";

    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
        document.getElementById("all-steps").style.display = "none";

    } else {
        document.getElementById("prevBtn").style.display = "block";
        document.getElementById("all-steps").style.display = "block";

    }

    if (n == 3) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("btn-finalizar").style.display = "block";
        
    } else {
        if (document.getElementById("btn-finalizar").style.display == "block") {
            document.getElementById("nextBtn").style.display = "block";
            document.getElementById("btn-finalizar").style.display = "none";
        }
    
    document.getElementById("nextBtn").innerHTML = "Seguinte";
    }
    fixStepIndicator(n)
}


function nextPrev(n) {
    var x = document.getElementsByClassName("tab");
    if (n == 1 && !validateForm()) return false;
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;

    if (currentTab == 0) {
        document.getElementById("registar").innerHTML = "REGISTAR"; 

        document.getElementById("email").value = "";

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

    } else if (currentTab == 1){
        document.getElementById("registar").innerHTML = "DADOS DA SUA CONTA";

        if (document.getElementById("email").value) {
            document.getElementById("name").value = "";

            if (document.getElementById("user_input_email").value) {
                document.getElementById("user_input_email").value = document.getElementById("email").value;
            } else{
                document.getElementById("user_input_email").value = document.getElementById("email").value;
            }
            
        }

    } else if (currentTab == 2) {
        document.getElementById("registar").innerHTML = "PALAVRA-PASSE";
    } else if (currentTab == 3){
        document.getElementById("registar").innerHTML = "ADICIONE UMA FOTOGRAFIA";
    } else {
        document.getElementById("registar").innerHTML = "ADICIONE UMA FOTOGRAFIA";
    }

showTab(currentTab);
}


function validateForm() {

    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    for (i = 0; i < y.length; i++) { 
        if (y[i].value=="" ) { 
            y[i].className +=" invalid" ; valid=false; 
        }} 
        if (valid) { 
            document.getElementsByClassName("step")[currentTab].className +=" finish" ; } 
            return valid;
} 


function fixStepIndicator(n) { 
    var i, x=document.getElementsByClassName("step"); 
    for (i=0; i < x.length; i++) { 
        x[i].className=x[i].className.replace(" active", "" ); 
    } 
    x[n].className +=" active" ; 
}
