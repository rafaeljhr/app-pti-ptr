let app = Vue.createApp({
    data: function() {
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


