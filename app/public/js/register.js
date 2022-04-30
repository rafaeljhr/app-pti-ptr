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

/* FORM STEP BY STEP */

var currentTab = 0;
document.addEventListener("DOMContentLoaded", function(event) {


showTab(currentTab);

});

function showTab(n) {
var x = document.getElementsByClassName("tab");
x[n].style.display = "block";
if (n == 0) {
document.getElementById("prevBtn").style.display = "none";
} else {
document.getElementById("prevBtn").style.display = "inline";
}
if (n == (x.length - 1)) {
document.getElementById("nextBtn").innerHTML = "Submit";
} else {
document.getElementById("nextBtn").innerHTML = "Next";
}
fixStepIndicator(n)
}

function nextPrev(n) {
var x = document.getElementsByClassName("tab");
if (n == 1 && !validateForm()) return false;
x[currentTab].style.display = "none";
currentTab = currentTab + n;
if (currentTab >= x.length) {
// document.getElementById("regForm").submit();
// return false;
//alert("sdf");
document.getElementById("nextprevious").style.display = "none";
document.getElementById("all-steps").style.display = "none";
document.getElementById("register").style.display = "none";
document.getElementById("text-message").style.display = "block";




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
    } function fixStepIndicator(n) { 
        var i, x=document.getElementsByClassName("step"); 
        for (i=0; i < x.length; i++) { 
            x[i].className=x[i].className.replace(" active", "" ); 
        } 
        x[n].className +=" active" ; 
    }
