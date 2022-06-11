document.addEventListener('DOMContentLoaded', function(){
    let link = document.querySelectorAll(".delete");
    for (let i = 0; i < link.length; i++) {
        link[i].addEventListener('click',function(e){
            if(!confirm("Are you sure?")){
                e.preventDefault();
            }
        });
        
    }
})