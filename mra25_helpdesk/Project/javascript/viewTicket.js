window.addEventListener("load", init);

function init(){
	

    update();

}

function update() {
    const textarea = document.querySelector(".ticket-textarea");
    textarea.addEventListener("input", event => {
      const target = event.currentTarget;
      const maxLength = target.getAttribute("maxlength");
      const currentLength = target.value.length;
      var tag = document.querySelector("#view-ticket-text");
     tag.textContent = maxLength - currentLength + " characters remaining";
    });

}