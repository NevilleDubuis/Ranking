//Vérification d'une adresse e-mail
function verif_form() {
	var formulaire = document.getElementsByTagName('form');
	for (var j = 0 ; j < formulaire.length ; j++) {
		if (formulaire[j].id != 'searchform') {
			formulaire[j].onsubmit = function() {
				for (var i = 0; i < this.elements.length; i++) {
					nameof = this.elements[i].id;
					if (nameof.search("shoot")!= -1) {
						document.getElementById(this.elements[i].id).style.backgroundColor = 'white';
						if (this.elements[i].value == '') {
							document.getElementById(this.elements[i].id).style.backgroundColor = 'red';
							this.elements[i].focus();
							return false;
						}
						if (this.elements[i].value > 100 ) {
							document.getElementById(this.elements[i].id).style.backgroundColor = 'red';
							this.elements[i].focus();
							return false;
						}
						if (this.elements[i].value < 0 ) {
							document.getElementById(this.elements[i].id).style.backgroundColor = 'red';
							this.elements[i].focus();
							return false;
						}
						
						if (is_numeric(this.elements[i].value)==false ) {
							document.getElementById(this.elements[i].id).style.backgroundColor = 'red';
							this.elements[i].focus();
							return false;
						}
				}
				}
			}
			return true;
		};
	}
		
}
	
function is_numeric(nombre) {
	retour = true;
	for (i = 0; i < nombre.length; i++) {
		car = nombre.charAt(i);
		retour = (retour && (car.search(/1|2|3|4|5|6|7|8|9|0/)!=-1));
	}
	return retour;
}

function verifPass(password) {
	var obj = document.getElementById("password");
	if (password == obj.value) {
		return true;
	}
	return false;
}

function verifEmail(mail) {
	var ret = true;
	var car = "";
	var carAfter = "";
	var carBefore = "";
	var nbrcar = mail.length;
	var nbrarobase = 0;
	var nbrpoint = 0;
	var goodcar = "@0123456789.-_abcdefghijklmnopqrstuvwxyz";
	for(cnt = 0;cnt < nbrcar;cnt++) {
		var car = mail.substr(cnt,1);
		if(goodcar.indexOf(car) >= 0) {
			carAfter = "";
			carBefore = "";
			if(car == "@") {
				if((cnt-1) >= 0) {
					carBefore = mail.substr((cnt-1),1);
				}
				if((cnt+1) < nbrcar) {
					carAfter = mail.substr((cnt+1),1);
				}
				if(cnt > 0 && nbrarobase == 0 && cnt < (nbrcar-4) && !(carBefore == ".") && !(carAfter == ".") && !(carBefore == "-") && !(carAfter == "-") && !(carBefore == "_") && !(carAfter == "_")) {
					nbrarobase++;
				} 
				else {
					ret = false;
					break;
				}
			}
			if(car == ".") {
				if((cnt-1) >= 0) {
					carBefore = mail.substr((cnt-1),1);
				}
				if((cnt+1) < nbrcar) {
					carAfter = mail.substr((cnt+1),1);
				}
				if(cnt > 0 && cnt < (nbrcar-2) && !(carBefore == ".") && !(carAfter == ".") && !(carBefore == "-") && !(carAfter == "-") && !(carBefore == "_") && !(carAfter == "_")) {
					nbrpoint++;
				} 
				else {
					ret = false;
					break;
				}
			}
		} 
		else {
			ret = false;
			break;
		}
	}
	if(nbrarobase == 0 || nbrpoint == 0 || mail.substr(0,1) == "." || mail.substr(0,1) == "-" || mail.substr(0,1) == "_" || mail.substr((nbrcar-1),1) == "." || mail.substr((nbrcar-1),1) == "-" || mail.substr((nbrcar-1),1) == "_") {
		ret = false;
	}
	return ret;
}

//Vérification d'une adresse url
function is_url(url)
{
	var resultat = true;
    var invalid_char = "²~#'{([|`^)]}°§*";
	var deb_url = "http://";
	var nbrpoint = 0;
	var nbrcar = url.length;
	if(nbrcar < 11)
		resultat = false;
    for(var i = 0;i < 7;i++){
		if(url.substr(i,1) != deb_url.substr(i,1))
			resultat = false;
    }	
    for(var i = 0;i < nbrcar;i++){
		var car = url.substr(i,1);
		if(invalid_char.indexOf(car) > 0){
			resultat = false;
		}
		if(car == ".") {
			var carAfter = "";
			var carBefore = "";
			if((i-1) >= 0) {
				carBefore = url.substr((i-1),1);
			}
			if((i+1) < nbrcar) {
				carAfter = url.substr((i+1),1);
			}
			if(i > 7 && i < (nbrcar-2) && !(carBefore == ".") && !(carAfter == ".") && !(carBefore == "-") && !(carAfter == "-") && !(carBefore == "_") && !(carAfter == "_")) {
				nbrpoint++;
			} 
			else {
				resultat = false;
			}
		}
    }
	if(nbrpoint < 2 || url.substr(7,1) == "." || url.substr(7,1) == "-" || url.substr(7,1) == "_" || url.substr((nbrcar-1),1) == "." || url.substr((nbrcar-1),1) == "-" || url.substr((nbrcar-1),1) == "_") {
		resultat = false;
	}	
	return(resultat);
}