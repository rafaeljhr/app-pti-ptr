let app = Vue.createApp({
    data: function() {
        return {
            emptyCart: false,
        }
    },

    methods: {
        calculatePrices() {
            var subTotal = 0;
            var totalEntregas = 0;
            var totalPollution = 0;
            var totalKwh = 0;

            var productRows = document.getElementById("todosProdutos").children;
            for (var i = 0; i < (productRows.length - 1); i++) {
                subTotal += parseFloat((document.getElementsByClassName("productPrice")[i].innerHTML.slice(0,-2) * document.getElementsByClassName("quantity")[i].value));

                deliveryPrice = document.getElementsByClassName("deliveryPrice")[i];
                totalEntregas += parseFloat(deliveryPrice.options[deliveryPrice.selectedIndex].dataset.price);

                pollution = document.getElementsByClassName("pollution")[i];
                totalPollution += parseFloat(pollution.dataset.pollution);

                kwh = document.getElementsByClassName("kwh")[i];
                totalKwh += parseFloat(kwh.dataset.kwh);
            }

            if (subTotal === 0) {
                document.getElementById("msgCarrinho").innerHTML= "O teu carrinho está vazio, adiciona algo para o fazer feliz!";
                this.emptyCart = true;
            }

            this.$refs.CO2.innerHTML = totalPollution + " kg";

            this.$refs.kwConsumed.innerHTML = totalKwh + " kWh";

            this.$refs.subTotal.innerHTML = subTotal + " €";

            this.$refs.custoEntrega.innerHTML = totalEntregas + " €";
        
            this.$refs.totalCost.innerHTML = subTotal + totalEntregas + " €";
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

function getTotalPrice() {
    console.log(document.getElementById("custoTotal").innerHTML.slice(0,-2));
    return document.getElementById("custoTotal").innerHTML.slice(0,-2);
}

paypal.Buttons({
    createOrder: (data, actions) => {
    return actions.order.create({
        purchase_units: [{
        amount: {
            value: getTotalPrice()
        }
        }]
    });
    },
    // Finalize the transaction after payer approval
    onApprove: (data, actions) => {
    return actions.order.capture().then(function(orderData) {
        document.getElementById('checkout').submit();
    });
    }
}).render('#paypal-button-container');
           