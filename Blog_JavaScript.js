//MAke sure all the html loads in first
document.addEventListener("DOMContentLoaded", () => {

//Darkmode maker
function DarkMode(){
    var element = document.body;
    element.classList.toggle("dark-mode");
}

//Read more/less
// I want to set the show more/less button automatically instead of putting in the spans manually
const charLimit = 148;
 document.querySelectorAll(".Post").forEach(post => {
      const wrapper = post.querySelector(".postTextWrapper");
      const btn = post.querySelector(".read-toggle");
      if (!wrapper || !btn) return;

      const paragraphs = Array.from(wrapper.querySelectorAll(".postText"));

      let visibleText = "";
      let hiddenText = "";
      let charCount = 0;

      paragraphs.forEach(p => {
          const text = p.textContent;

          if (charCount + text.length <= charLimit) {
              visibleText += text + " "; // add space instead of new line
          } else if (charCount < charLimit) {
              const splitIndex = charLimit - charCount;
              visibleText += text.slice(0, splitIndex) + '<span class="dots">...</span> ';
              hiddenText += text.slice(splitIndex) + " ";
          } else {
              hiddenText += text + " ";
          }

          charCount += text.length;
      });

      if (hiddenText.length > 0) {
          wrapper.innerHTML = `
              <span class="visible-text">${visibleText}</span>
              <span class="more" style="display:none">${hiddenText}</span>
          `;

          btn.style.display = "inline-block";
          btn.addEventListener("click", () => {
              const dots = wrapper.querySelector("span.dots");
              const more = wrapper.querySelector(".more");
              if (!dots || !more) return;

              if (dots.style.display === "none") {
                  dots.style.display = "inline";
                  more.style.display = "none";
                  btn.innerHTML = 'Read more <i class="fa-solid fa-chevron-down"></i>';
              } else {
                  dots.style.display = "none";
                  more.style.display = "inline";
                  btn.innerHTML = 'Read less <i class="fa-solid fa-chevron-up"></i>';
              }
          });
      } else {
          btn.style.display = "none";
      }
  });

//Delete
document.querySelectorAll(".delete-post").forEach(btn => {
    btn.addEventListener("click", () => {
        const postId = btn.dataset.postId;

        if (!confirm("Are you sure you want to delete this post?")) return;

        // Remove the article in the main section
        const article = document.getElementById(postId);
        if (article) article.remove();

        // Remove the link in the sidebar
        const sidebarLink = document.querySelector(`.Older_post button[data-post-id='${postId}']`)?.parentElement;
        if (sidebarLink) sidebarLink.remove();

        // Send AJAX request to delete JSON entry
        fetch("Delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `postId=${encodeURIComponent(postId)}`
        })
        .then(res => res.text())
        .then(response => {
            console.log(response); // Optional: confirm deletion
        })
        .catch(err => console.error("Error deleting post:", err));
    });
});

//Edit button
window.editPost = function(postId) {
    const post = document.getElementById(postId);
    const title = post.querySelector(".post-title");
    const body = post.querySelector(".post-body");
    const button = post.querySelector(".edit-btn");

    if (!post || !title || !body || !button) {
        console.error("Cannot find elements for post:", postId);
        return;
    }

    if (button.innerText === "Edit") {
        title.contentEditable = "true";
        body.contentEditable = "true";
        title.style.border = "1px dashed #aaa";
        body.style.border = "1px dashed #aaa";
        button.innerText = "Save";
    } else {
        title.contentEditable = "false";
        body.contentEditable = "false";
        title.style.border = "none";
        body.style.border = "none";
        button.innerText = "Edit";
    }
};

// <!-- AUTOSAVE (opt3) -->
const form = document.querySelector("form");
const textArea = document.querySelector("textarea[name='content']");
const titleInput = document.querySelector("input[name='title']");
if(textArea && titleInput){
textArea.value = localStorage.getItem("draftContent") || "";
titleInput.value = localStorage.getItem("draftTitle") || "";

// Auto-save every 5 seconds
setInterval(() => {
    localStorage.setItem("draftContent", textArea.value);
    localStorage.setItem("draftTitle", titleInput.value);
    console.log("Draft saved!");
}, 5000);

};
// Remove draft on submit
if (form) {
    form.addEventListener("submit", () => {
        localStorage.removeItem("draftContent");
        localStorage.removeItem("draftTitle");
        console.log("Draft cleared!");
    });
}

});

