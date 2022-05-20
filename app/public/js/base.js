function criarUmaBase() {

    if (document.getElementById("fundoDivOpac").style.display == "block") {
        document.getElementById("fundoDivOpac").style.display = "none";
    } else {
        document.getElementById("fundoDivOpac").style.display = "block";
    }

    if (document.getElementById("criarUmaBase").style.display == "block") {
        document.getElementById("criarUmaBase").style.display = "none";
    } else {
        document.getElementById("but-pad").style.display = "block";
        document.getElementById("criarUmaBase").style.display = "block";
    }

}