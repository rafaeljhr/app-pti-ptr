let app = Vue.createApp({
    data: function() {
        return {}
    },

    methods: {
        add2Carrinho(productID, productName) {
            let route = document.getElementById("addCartButton").name;

            var data = new FormData()
            data.append('id_produto', productID);
            data.append('nome_produto', productName);

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            var xhr = new XMLHttpRequest();
                xhr.open('POST', route, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("divAvisoCarrinho").style.display = "block";
                    document.getElementById("avisoCarrinho").innerHTML = xhr.responseText;
                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };

            xhr.send(data);
        },

        fecharAlerta() {
            document.getElementById("divAvisoCarrinho").style.display = "none";
        }
        
    },
})

app.mount('.app')