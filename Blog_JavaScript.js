//Darkmode maker
function DarkMode(){
    var element = document.body;
    element.classList.toggle("dark-mode");
}

//Read more/less

document.addEventListener("click", function(e) {
  const btn = e.target.closest(".Read-Toggle");
  if (!btn) return;

  const post = btn.closest(".Post");
  if (!post) return;

  const dots = post.querySelector(".Dots");
  const moreText = post.querySelector(".More");
  if (!dots || !moreText) return;

  const isHidden = window.getComputedStyle(dots).display === "none";

  if (isHidden) {
    dots.style.display = "inline";
    moreText.style.display = "none";
    btn.innerHTML = 'Read more <i class="fa-solid fa-chevron-down"></i>';
  } else {
    dots.style.display = "none";
    moreText.style.display = "inline";
    btn.innerHTML = 'Read less <i class="fa-solid fa-chevron-up"></i>';
  }
});


// Read and Display blog entries
fetch("Blogpost_Entries.json")
  .then(response => response.json())
  .then(posts => {
    const container = document.getElementById("blog-container");

    posts.forEach(post => {
      // Create a wrapper
      const postDiv = document.createElement("div");
      postDiv.classList.add("post");

      // Add title
      const title = document.createElement("h2");
      title.textContent = post.title;
      postDiv.appendChild(title);

      // Add date
      const date = document.createElement("p");
      date.textContent = post.date;
      date.classList.add("date");
      postDiv.appendChild(date);

      // Add paragraphs
      post.paragraphs.forEach(text => {
        const p = document.createElement("p");
        p.textContent = text;
        postDiv.appendChild(p);
      });

      // Add the post to the container
      container.appendChild(postDiv);
    });
  })
  .catch(err => {
    console.error("Error loading blogposts.json:", err);
  }
);

