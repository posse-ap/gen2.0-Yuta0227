var month;
var year;
var paramArray;
window.onload = function () {
    var today = new Date();
    month = today.getMonth() + 1;
    year = today.getFullYear();
    paramArray=[month,year]
    fetch('webapp.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(paramArray)
    }).then(response=>response.json())  
};