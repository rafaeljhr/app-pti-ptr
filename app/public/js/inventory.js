let app = Vue.createApp({
    data: function() {
        return {
            fundoDiv: false,
            cadeiaDiv:false,
            totalSteps:2,
            step:1
            
        }
    },
    methods: {
        openCadeia() {
           this.cadeiaDiv=!this.cadeiaDiv;
        },

        openAdd() {
            this.fundoDiv=!this.fundoDiv;
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