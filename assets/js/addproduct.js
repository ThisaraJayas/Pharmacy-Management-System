function productAdd(){
	var name = document.forms["form1"]["pName"].value;
	var desc = document.forms["form1"]["pDesc"].value;
	var price = document.forms["form1"]["pPrice"].value;
	var image1 = document.forms["form1"]["pFile"].value;
	if(name==""){
		alert("Please Enter Name");
		document.forms["form1"]["pName"].focus();
		return false;
	}
	else if(desc==""){
		alert("Please Enter Description");
		document.forms["form1"]["pDesc"].focus();
		return false;
	}
	else if(price==""){
		alert("Enter Enter Price");
		document.forms["form1"]["pPrice"].focus();
		return false;
	}
	else if(image1==""){
		alert("Enter Upload File");
		document.forms["form1"]["pFile"].focus();
		return false;
	}
	 return true;
}