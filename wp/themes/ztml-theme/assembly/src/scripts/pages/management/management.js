window.onload =()=>{
    const btnMore = document.querySelectorAll(".managment-list .mob-get-more")
    if(btnMore){
        btnMore.forEach((btn)=>{
            btn.addEventListener("click", function functionName(e) {
                const more_block = e.currentTarget.previousElementSibling;
                if (more_block.classList.contains("active")) {
                    more_block.classList.remove("active");
                    e.currentTarget.innerText = "Читать все";
                } else {
                    more_block.classList.add("active");
                    e.currentTarget.innerText = "Скрыть";
                }
            });
        })
    }
};