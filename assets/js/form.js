 function surligne(field, erreur)
 {
     if(erreur)
     {
         field.style.backgroundColor = "#ff00002e";
         //field.style.color = "#FFFFFF";
     }
     else
         field.style.backgroundColor = "#cfffbd94";
}

function checkMail(field)
{
    var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;

    if(!regex.test(field.value))
    {
        surligne(field, true);
        return false;
    }
    else
    {
        surligne(field, false);
        return true;
    }
}

 function checkUnit(field, size)
 {
     var regex = /[0-9]/;

     if(regex.test(field.value) || field.value.length > size || field.value.length === 0)
     {
         surligne(field, true);
         return false;
     }
     else
     {
         surligne(field, false);
         return true;
     }
 }

 function checkReverse(field, size)
 {
     var regex = /[0-9]/;

     if(!regex.test(field.value) || field.value.length > size)
     {
         surligne(field, true);
         return false;
     }
     else
     {
         surligne(field, false);
         return true;
     }
 }

 function checkPassword(field)
 {
     var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;

     if(!regex.test(field.value))
     {
         surligne(field, true);
         var strTxt = document.getElementById("strTxt");
         strTxt.textContent = '*Au moins 8 caractères, 1 minuscule, 1 majuscule et 1 chiffre';
         return false;
     }
     else
     {
         surligne(field, false);
         return true;
     }
 }

 function checkAddress(field, size)
 {
     if(field.value.length > size  || field.value.length === 0)
     {
         surligne(field, true);
         return false;
     }
     else
     {
         surligne(field, false);
         return true;
     }
 }

 function checkForm(f)
 {
     var mail = checkMail(f.email);
     var password = checkPassword(f.password);
     var firstname = checkUnit(f.firstname, 50);
     var lastname = checkUnit(f.lastname, 50);
     var phone = checkReverse(f.phone, 10);
     var address = checkAddress(f.address, 255);
     var postal_code = checkReverse(f.postal_code, 5);

     if(mail && password && firstname && lastname && phone && address && postal_code)
         return true;
     else
         return false;
 }

