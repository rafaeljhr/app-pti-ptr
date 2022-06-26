let app = Vue.createApp({

    methods: {
        criar() {

            if (document.getElementById("fundoDivOpac").style.display == "block") {
                document.getElementById("fundoDivOpac").style.display = "none";
            } else {
                document.getElementById("fundoDivOpac").style.display = "block";
            }

            if (document.getElementById("criar").style.display == "block") {
                document.getElementById("criar").style.display = "none";
            } else {
                document.getElementById("but-pad").style.display = "block";
                document.getElementById("criar").style.display = "block";
            }

        },

        finishForm(e) {
            e.preventDefault();

            document.getElementById("loader").style.display = "block";
            
            var url = new URL("https://atlas.microsoft.com/search/address/json");
            var parameters = { 
                "subscription-key" : "rxjgLgUQ02QSSkv0NKBzj7q3gXP9HPCNyHfoE_DBNRc", 
                "api-version" : 1.0, 
                "language" : "pt-PT", 
                "query" : document.getElementById("morada").value + "," + document.getElementById("cidade").value + "," + document.getElementById("codigo_postal_1").value + "-" + document.getElementById("codigo_postal_2").value};

            for (var p in parameters) {
                url.searchParams.append(p, parameters[p]);
            }

            fetch(url)
            .then(response => response.json())
            .then(
                data => {this.$refs.latitude.value = data["results"][0]["position"]["lat"];
                         this.$refs.longitude.value = data["results"][0]["position"]["lon"];})

            setTimeout(function() {

                document.getElementById("baseForm").submit();
            
            }, 3000) 
        },
    },

})

app.mount('app')