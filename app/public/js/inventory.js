countProds = [];

function countCompare(id){
    
    console.log(this.editable);
    if(document.getElementsByName(id)[0].checked == true){
        countProds.push(id);
    }else{
        index = countProds.indexOf(id);
        countProds.splice(index, 1);
    }
    console.log(countProds);
    if(countProds.length < 2 || countProds.length > 2){
        document.getElementById("guardar_alteracoes").disabled = true;
    }else{
        document.getElementById("guardar_alteracoes").disabled = false;
    }
}


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

        cancelCompare(){
            this.editable = false;
            console.log(this.editable);
            document.getElementById("compareForm").reset();
            countProds.splice(0, countProds.length)
            
        },
    },
})

app.mount('.app')


