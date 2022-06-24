let app = Vue.createApp({
    data: function() {
        return {}
    },

    methods: {
        add2Carrinho(productID, productName, productKey) {
            let route = document.getElementById("addCartButton" + productKey.toString()).name;
            document.getElementById("removeCartButton" + productKey.toString()).style.display = "inline-block";

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
        },

        removeProduto(productKey, productName) {
            let route = document.getElementById("removeCartButton" + productKey.toString()).firstChild.name;
            document.getElementById("removeCartButton" + productKey.toString()).style.display = "none";

            var data = new FormData()
            data.append('key_produto', productKey);
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
        
    },
})

app.mount('.app')

function AdicionarApagarProdutoCarrinho(element, id, route){

    var BtnText = element.innerHTML;

    if(BtnText.includes("Adicionar ao Carrinho")){
        element.innerHTML = "Remover do Carrinho";
        element.style.background = 'red';
    }else{
        element.innerHTML = "Adicionar ao Carrinho";
        element.style.background = 'green';
    }

    var data = new FormData();
        
    data.append("id", id);
    
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let xhr = new XMLHttpRequest();
    
    xhr.open("POST", route, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
    
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            console.log(xhr.responseText);
        } else if (this.status >= 400) {
            console.log(this.status);
        }
    };
    
    xhr.send(data); 

}


function AdicionarApagarFavorito(element, id, route){

    var span = element.innerHTML;

    if(span.includes("checked")){
        element.innerHTML = "<span class='fa fa-star'></span>";
    }else{
        element.innerHTML = "<span class='fa fa-star checked'></span>";
    }

    var data = new FormData();

    data.append("id", id);

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let xhr = new XMLHttpRequest();

    xhr.open("POST", route, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', csrf);

    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
            console.log(xhr.responseText);
        } else if (this.status >= 400) {
            console.log(this.status);
        }
    };

    xhr.send(data); 

}  