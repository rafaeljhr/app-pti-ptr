let app = Vue.createApp({
    data: function() {
        return {
            clientConsumer: true,
            userName: "",
            editable: false
        }
    },
    methods: {
        cancelChanges() {
            this.editable = !this.editable;
        }
    },
})

app.mount('.app')