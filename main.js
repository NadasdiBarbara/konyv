
function adatokKiemel(){
    let iro = document.forms["form"]["iro"].value;
    let cim = document.forms["form"]["cim"].value;
    let oldalszam = document.forms["form"]["oldalszam"].value;
    let mufaj = document.forms["form"]["mufaj"].value;

    if(iro==""){
        alert("Kötelező megadni a könyv íróját!");
        return false;
    }
    if(cim==""){
        alert("Kötelező megadni a könyv címét!");
        return false;
    }
    if(oldalszam==""){
        alert("Kötelező megadni könyv oldalszámát!");
        return false;
    }
    if(mufaj==""){
        alert("Kötelező megadni könyv műfaját!");
        return false;
    }

    if(oldalszam == 0){
        alert("Oldalszámnak nagyobbnak kell lennie mint 0!")
    }
}