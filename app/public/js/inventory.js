let app = Vue.createApp({
    data: function() {
        return {
            fundoDiv: false,
            totalSteps:2,
            step:1
            
        }
    },
    methods: {
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