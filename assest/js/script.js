function searchFun(){
	let filter=document.getElementById('my_input').value.toUpperCase();

	let myTable=document.getElementById('content-table');
	let tr=myTable.getElementsByTagName('tr');

	for(var i=0;i<tr.length;i++){
		let td=tr[i].getElementsByTagName('td')[2];
		if(td){
			let textvalue=td.textContent|| td.innerHTML;
			if(textvalue.toUpperCase().indexOf(filter) >-1){
				tr[i].style.display="";
			}
			else{
				tr[i].style.display="none";
			}
		}
	}
}
// search by category
function searchFun2(){
	let filter=document.getElementById('my_category').value.toUpperCase();

	let myTable=document.getElementById('content-table');
	let tr=myTable.getElementsByTagName('tr');

	for(var i=0;i<tr.length;i++){
		let td=tr[i].getElementsByTagName('td')[3];
		if(td){
			let textvalue=td.textContent|| td.innerHTML;
			if(textvalue.toUpperCase().indexOf(filter) >-1){
				tr[i].style.display="";
			}
			else{
				tr[i].style.display="none";
			}
		}
	}
}