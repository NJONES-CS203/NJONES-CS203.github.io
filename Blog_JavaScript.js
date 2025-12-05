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


});