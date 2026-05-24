window.addEventListener("DOMContentLoaded", function(){

    const aramaInput = document.getElementById("aramaInput");
    const aramaSonuc = document.getElementById("aramaSonuc");

    if(!aramaInput || !aramaSonuc){
        return;
    }

    aramaInput.addEventListener("keyup", function(){

        let kelime = this.value.trim();

        if(kelime === ""){

            aramaSonuc.innerHTML = "";
            aramaSonuc.style.display = "none";

            return;
        }

        fetch(
            "/kozmetik_magazasi/ajax/urun_ara.php?arama=" +
            encodeURIComponent(kelime)
        )

        .then(response => response.text())

        .then(data => {

            aramaSonuc.innerHTML = data;
            aramaSonuc.style.display = "block";

        })

        .catch(error => {

            console.log(error);

        });

    });

    document.addEventListener("click", function(e){

        if(
            !aramaInput.contains(e.target)
            &&
            !aramaSonuc.contains(e.target)
        ){

            aramaSonuc.style.display = "none";

        }

    });

});