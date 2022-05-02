

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
            telephone_valid: true,
            nif_valid: true,
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
                document.getElementById("nextBtn").disabled = true;
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

        if (n==2) {
            document.getElementById("nextBtn").disabled = true;
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
    } else if (currentTab == 1){
        document.getElementById("registar").innerHTML = "DADOS DA SUA CONTA";
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
