

let app = Vue.createApp({
    data() {
        return {

            

            armazemAddDiv:false,
            fundoDiv: false,
            fundoDivOpac:false,
            cadeiaDiv:false,
            totalSteps:2,
            step:1,
            computadores:false,
            mobilidade:false,
            componentes:false,
            perifericos:false
           
            
        }
    },
    methods: {


        /* onFileChange(event){
            this.form.path_imagem_produto = event.target.files[0];
        },


        createrProduct(e){
            console.warn(result);
            this.axios.post("http://localhost/app-pti-ptr/app/public/product-register-controller",this.form)
            .then((result)=>{
                console.warn(result);
            })
            

            e.preventDefault();
            
        },
 */

        createProduct(){
            let urlActual = window.location.href;
            var hrefNew = urlActual.split("?");
            let formInputs = hrefNew[1].split("&");
            
            let toAdd = hrefNew[0].slice(0, -9);
            let form={
                _token:formInputs[0].split("=")[1],
                nome:formInputs[1].split("=")[1],
                path_imagem_produto:formInputs[2].split("=")[1],
                id_armazem:formInputs[3].split("=")[1],
                nome_categoria:formInputs[4].split("=")[1],
                nome_subcategoria:formInputs[5].split("=")[1],
                preco:formInputs[6].split("=")[1],
                data_producao_do_produto:formInputs[7].split("=")[1],
                data_insercao_no_site:formInputs[8].split("=")[1],
                kwh_consumidos_por_dia:formInputs[9].split("=")[1],
                quantidade:formInputs[10].split("=")[1],
                informacoes_adicionais:formInputs[11].split("=")[1]
            }

            let post = JSON.stringify(form);
            

            const url = toAdd + "product-register-controller";
            let xhr = new XMLHttpRequest();
            
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
            console.log(form);
            /* xhr.send(post);
            
            xhr.onload = function () {
                if(xhr.status === 201) {
                    console.log("Post successfully created!");
                }else{
                    console.log(form);
                }
            } */
        },

        changeSubcat(cat){
            if(cat.target.value=="computadores"){
                this.computadores=!this.computadores;
                if(this.mobilidade==true){
                    this.mobilidade=!this.mobilidade;
                }
                if(this.componentes==true){
                    this.componentes=!this.componentes;
                }
                if(this.perifericos==true){
                    this.perifericos=!this.perifericos;
                }
                
                
                
            }
            if(cat.target.value=="mobilidade"){
                this.mobilidade=!this.mobilidade;
                if( this.computadores==true){
                    this.computadores=!this.computadores;
                }
                if(this.componentes==true){
                    this.componentes=!this.componentes;
                }
                if(this.perifericos==true){
                    this.perifericos=!this.perifericos;
                }
                
            }
            if(cat.target.value=="componentes"){
                this.componentes=!this.componentes;
                if( this.computadores==true){
                    this.computadores=!this.computadores;
                }
                if(this.mobilidade==true){
                    this.mobilidade=!this.mobilidade;
                }
                
                if(this.perifericos==true){
                    this.perifericos=!this.perifericos;
                }
                
            }
            if(cat.target.value=="periféricos"){
                this.perifericos=!this.perifericos;
                if( this.computadores==true){
                    this.computadores=!this.computadores;
                }
                if(this.mobilidade==true){
                    this.mobilidade=!this.mobilidade;
                }
                if(this.componentes==true){
                    this.componentes=!this.componentes;
                }                
                
            }
        },

       

        openArmazem(){
            this.armazemAddDiv=!this.armazemAddDiv;
            

        },
        openAddArmazem(){
            this.fundoDivOpac=!this.fundoDivOpac;
            this.armazemDiv=!this.armazemDiv;
        },
        openCadeia() {
           this.cadeiaDiv=!this.cadeiaDiv;
        },

        openAdd() {
            this.fundoDivOpac=!this.fundoDivOpac;
            this.fundoDiv=!this.fundoDiv;
         
        },

        nextStep(){
            this.step++;
        }, 
        previousStep(){
            this.step--;
        },
    },
})

app.mount('.app')


