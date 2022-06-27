let app = Vue.createApp({
    data: function() {
        return {
            nome: "",
            preco: "",
            quantidade: "",
            data_p: "",
            data_i: "",
            kwh: "",
            info: "",
            cat:"",
            subcat:"",

            editable: false,
            nome_valid: true,
            preco_valid: true,
            quantidade_valid: true,
            data_p_valid: true,
            data_i_valid: true,
            kwh_valid:true,
            info_valid:true,
        }
    },

    methods: {
        
        changeSubcat(cat){

            let route = document.getElementById("routeSubCat").name;
            var data = new FormData()
            
            data.append('categoria', cat.target.value);
        
            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
            let xhr = new XMLHttpRequest();
            xhr.open('POST', route, true)
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf);
        
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("toChangeOnCmd").innerHTML = JSON.parse(xhr.responseText)[0];
                   
                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };
        
            xhr.send(data);
        },


        cancelChanges() {
            this.editable = false;
            this.$refs.nome.value = this.nome;
            this.$refs.preco.value = this.preco;
            this.$refs.quantidade.value = this.quantidade;
            this.$refs.data_p.value = this.data_p;
            this.$refs.data_i.value = this.data_i;
            this.$refs.cat.value = this.cat;
            selectBox = document.getElementById("novo_produto_subcategoria");
            newOption = new Option(this.subcat,this.subcat);
            selectBox.add(newOption,undefined);
            document.querySelector('#novo_produto_subcategoria').value = this.subcat;
            document.getElementById("novo_produto_subcategoria").disabled = true;
            this.$refs.kwh.value = this.kwh;
            this.$refs.info.value = this.info;
        },

    }, 

    mounted() {
        this.nome = this.$refs.nome.value;
        this.preco = this.$refs.preco.value;
        this.quantidade = this.$refs.quantidade.value;
        this.data_p = this.$refs.data_p.value;
        this.data_i = this.$refs.data_i.value;
        this.subcat = this.$refs.subcat.value;
        this.cat = this.$refs.cat.value;
        this.kwh = this.$refs.kwh.value;
        this.info = this.$refs.info.value;
    }
})

app.mount('.app')

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

function alterarImagem(event) {
    document.getElementById("titulo_imagem").innerHTML = "Novo Avatar";
    document.getElementById("imagem_a_alterar").src=URL.createObjectURL(event.target.files[0]);
    document.getElementById("submitChangeAvatar").style.display="block";
}

