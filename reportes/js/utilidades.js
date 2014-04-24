//////////////////////////////////////////////////////////////////////////////
///////////////////////////// valida campos vacios ///////////////////////////
//////////////////////////////////////////////////////////////////////////////
function campos_blancos(forma){
for(i=0;i<forma.elements.length;i++){
    snombrecampo = forma.elements[i].name;
    if (snombrecampo.substring(2,1) == "_"){
            //alert(snombrecampo.substring(0,1));
        if (snombrecampo.substring(0,1) == "t"){
            if (forma.elements[i].value == ""){
                alert("Todos los campos que contienen (*) son obligatorios");
                forma.elements[i].focus();
                return true;
            }
        }
        if (snombrecampo.substring(0,1) == "n"){
           if (forma.elements[i].value != ""){
               if (parseFloat(forma.elements[i].value)<=0){
                   alert("Todos los campos numericos que contienen (*) son obligatorios");
                   forma.elements[i].value = "";
                   forma.elements[i].focus();
                   return true;
               }
           }
        }
        if (snombrecampo.substring(0,1) == "d"){
          if (forma.elements[i].value != ""){
              if (IsDate(forma.elements[i].value)==false){
                  alert("formato de la fecha invalido ej: dd/mm/yyyy");
                  forma.elements[i].value = "";
                  forma.elements[i].focus();
                  return true;
                  }
              }
        }
    }
}
return false;
}//fin campos_blancos

//////////////////////////////////////////////////////////////////////////////
///////////////////////////// valida si es una fecha /////////////////////////
//////////////////////////////////////////////////////////////////////////////
function IsDate(caja){

   if (caja)
   {
      borrar = caja;

      if ((caja.substr(2,1) == "/") && (caja.substr(5,1) == "/"))
      {

        for (i=0;i<10;i++)
        {

          if (((caja.substr(i,1)<"0")||(caja.substr(i.l)>"9")) && (i != 2) && (i != 5))
          {
            borrar = '';
            break;
          }
        } // fin for (i=0;i<10;i++)

        if (borrar)
        {
          a = caja.substr(6,4);
          m = caja.substr(3,2);
          d = caja.substr(0,2);

          if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
            borrar = '';
          else
          {

            if ((a%4 != 0) && (m == 2) && (d > 28))
              borrar = ''; // año no viciesto y es febrero y el dia es mayor a 28
            else{
              if ((((m == 4) || (m == 6) || (m == 9) || (m == 11)) && (d > 30) || (m == 2) && (d>29)))
               borrar = '';
            } //else
          } // fin else

        } //fin if (borrar)
      }//fin if ((caja.substr(2,1) == "/") && (caja.substr(5,1) == "/"))
      else
        borrar = '';
        retornaisDate = true;

      if (borrar == '')
        retornaisDate = false;
    }//fin if (caja)
     return retornaisDate
  }//fin IsDate
  
  //////////////////////////////////////////////////////////////////////////////
///////////////////////// solo numeros en una caja de texto //////////////////
//////////////////////////////////////////////////////////////////////////////
var nav4 = window.Event ? true : false;
function cnum(evt){
   //note: backspace = 8, enter = 13, '0' = 48, '9' = 57 && key => 44 && key <= 46;
   var key = nav4 ? evt.which : evt.keyCode;
   return ((key >= 48 && key <= 57) || key == 44 || key == 45 || key == 46 || key == 8);
}//fin cnum