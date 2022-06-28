let app = Vue.createApp({


    data() {
        return {
            
            armazemAddDiv:false,
            fundoDiv: false,
            fundoDivOpac:false,
            cadeiaDiv:false,
            editable: false,
        }
    },
    methods: {

        searchCat(e){
            
            
            e.preventDefault();

            
            var form = e.target
            var data = new FormData(form)

            let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let xhr1 = new XMLHttpRequest();
            xhr1.open(form.method, form.action, true)
            xhr1.setRequestHeader('X-CSRF-TOKEN', csrf);

            xhr1.onreadystatechange = function() {
                if (this.readyState == 4 && (this.status == 200 || this.status == 201)) {
                    document.getElementById("prodDisplay").innerHTML = xhr1.responseText;
                    


                } else if (this.status >= 400) {
                    console.log(xhr1.responseText);
                }
            };

            xhr1.send(data);

                      
            
        },


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
                    document.getElementById("header_campos_extra").style.display = "block";
                    document.getElementById("toChangeOnCmd").innerHTML = JSON.parse(xhr.responseText)[0];
                    document.getElementById("camposExtra").innerHTML = JSON.parse(xhr.responseText)[1];
        
                } else if (this.status >= 400) {
                    console.log(xhr.responseText);
                }
            };
        
            xhr.send(data);

        },

        cancelCompare(){
            this.editable = false;
            console.log(this.editable);
            document.getElementById("compareForm").reset();
            countProds.splice(0, countProds.length)
            
        },

        selecionarProduto(id){
            if(document.getElementById("card_"+id).classList.contains('glowing-border')) {
                document.getElementById("card_"+id).classList.remove('glowing-border');
            } else {
                document.getElementById("card_"+id).classList.add('glowing-border');
            }

            if (document.getElementsByClassName("glowing-border").length == 2) {
                document.getElementById('comparar').style.display = 'block';

                var slides = document.getElementsByClassName("inputs_produto");
                var slides2 = document.getElementsByClassName("glowing-border");
                for (var i = 0; i < slides.length; i++) {

                    const myArray = slides2.item(i).id.split("_");
                    let id_produto = myArray[1];

                    console.log(id_produto);

                    document.getElementById('produto'+i).value = id_produto;

                }

            } else {
                document.getElementById('comparar').style.display = 'none';
            }
        },
    },
})

app.mount('.app')


