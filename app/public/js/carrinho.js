let app = Vue.createApp({
    data: function() {
        return {
            emptyCart: false,
        }
    },

    methods: {
        calculatePrices() {
            var subTotal = 0;

            var productRows = document.getElementById("todosProdutos").children;
            for (var i = 0; i < (productRows.length - 1); i++) {
                subTotal += parseFloat((document.getElementsByClassName("productPrice")[i].innerHTML.slice(0,-2) * document.getElementsByClassName("quantity")[i].value));
            }

            if (subTotal === 0) {
                document.getElementById("msgCarrinho").innerHTML= "O teu carrinho está vazio, adiciona algo para o fazer feliz!";
                this.emptyCart = true;
            }

            this.$refs.subTotal.innerHTML = subTotal + "€";

            //atualizar preço total adicionando o preço de entrega
            this.$refs.totalCost.innerHTML = subTotal + "€";
        },

        removeProduto(productKey, productID) {
            let route = document.getElementById("removeCartButton").name;
            let productName = document.getElementById("name" + productKey).innerHTML;
            document.getElementById(productKey).remove();

            var data = new FormData()
            data.append('id', productID);

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            var xhr = new XMLHttpRequest();
                xhr.open('POST', route, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("divAvisoCarrinho").style.display = "block";
                    document.getElementById("avisoCarrinho").innerHTML = productName + " removido com sucesso!";
                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };

            xhr.send(data);
            this.calculatePrices();
        },

        fecharAlerta() {
            document.getElementById("divAvisoCarrinho").style.display = "none";
        }
    },

})

app.mount('.app')