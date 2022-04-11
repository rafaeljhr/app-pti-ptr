let app = Vue.createApp({
    data: function() {
        return {
            fundoDiv: false
            
        }
    },
    methods: {
        openAdd() {
            this.fundoDiv=!this.fundoDiv;
        }
    },
})

app.mount('.app')