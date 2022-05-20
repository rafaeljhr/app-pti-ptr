function criar() {

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

}