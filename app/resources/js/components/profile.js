let app = Vue.createApp({
    data: function() {
        return {
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