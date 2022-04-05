let app = Vue.createApp({
    data: function() {
        return {
            clientConsumer: @json($clientConsumer),
            userName: @json($userName),
            userEmail: @json($userEmail),
            userTel: @json($userTel),
            userNIF: @json($userNIF),
            userAdress: @json($userAdress),
            editable: false
        }
    },
    methods: {
        cancelChanges() {
            editable = !editable;
            console.log("CANCELOU");
        }
    },
})

app.mount('.app')