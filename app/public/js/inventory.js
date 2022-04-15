let app = Vue.createApp({
    data: function() {
        return {
            armazemAddDiv:false,
            fundoDiv: false,
            fundoDivOpac:false,
            cadeiaDiv:false,
            totalSteps:2,
            step:1
            
        }
    },
    methods: {

        openArmazem(){
            this.armazemAddDiv=!this.armazemAddDiv;

        },
        openAddArmazem(){
            this.fundoDivOpac=!this.fundoDivOpac;
            this.armazemDiv=!this.armazemDiv;
        },
        openCadeia() {
           this.cadeiaDiv=!this.cadeiaDiv;
        },

        openAdd() {
            this.fundoDivOpac=!this.fundoDivOpac;
            this.fundoDiv=!this.fundoDiv;
            /* this.cadeiaDiv=!this.cadeiaDiv; */
        },

        nextStep(){
            this.step++;
        }, 
        previousStep(){
            this.step--;
        },
    },
})

app.mount('.app')