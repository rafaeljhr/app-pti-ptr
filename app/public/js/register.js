let app = Vue.createApp({
    data: function() {
        return {
            clientConsumer: true
        }
    },
    methods: {
        switchSelect(event) {
            if (event.target.value == "consumidor") {
                this.clientConsumer = true;
            } else {
                this.clientConsumer = false;
            }
        }
    }
})

app.mount('.app')
