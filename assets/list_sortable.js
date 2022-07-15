const $ = require('jquery');
import Sortable from 'sortablejs'

$(document).ready(function() {
    let list = document.getElementById('sortablelist')
    new Sortable(list, {
        animation: 150,
        onUpdate: function (e) {
            let url = "/admin/attend/id/order"
            url = url.replace('id',e.clone.getAttribute('data-target'))

            $.ajax({
                url:url,
                type:"POST",
                data:{
                    newIndex:e.newIndex,
                    oldIndex:e.oldIndex,
                },
                success:function(response)
                {
                    console.log(response)
                }
            })
        },

    });

    let modal = document.getElementById('modal_consl_new')
    let inputs = document.querySelectorAll('input[type="checkbox"]')
    let url = "/admin/consultation/attend/id/new";
    console.log(modal)
    console.log(inputs)

    Array.from(inputs).forEach(input=>{
        input.addEventListener('click',()=>{
            input.checked = false;
            document.getElementById('name-'+input.id).style.textDecoration = 'none';
            modal.querySelector('form').action = url.replace('id',input.id);
        })
    })
});