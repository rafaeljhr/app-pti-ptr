let app = Vue.createApp({
    data: function() {
        return {
            userName: "",
            editable: false,
            deleteConfirm: false
        }
    }
})

app.mount('.app')