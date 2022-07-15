/*const $ = require('jquery');

//had code bgit nesift meno data d ordonnance_medic me3a data li f form
$(document).ready(function() {
    const medicOrdo = document.querySelector('#medicOrdo');
    let ordonnMedic = []
    $('#ordonnance_medicament')
        .on("select2:select", function (e) {
            let method = prompt();
            ordonnMedic.push({ id:e.params.data.id,method })
            alert(JSON.stringify(ordonnMedic))
            medicOrdo.value = JSON.stringify(ordonnMedic);
        })
});
*/