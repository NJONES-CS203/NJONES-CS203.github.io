//Darkmode maker
function DarkMode(){
    var element = document.body;
    element.classList.toggle("dark-mode");
}

//Read more/less
function More_or_Less(){
    var dots = document.getElementsByClassName("dots");
    var moreText = document.getElementsByClassName("more");
    var btnText = document.getElementsByClassName("ML_Btn");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Read more <i class=fas fa-chevron-down></i>";
        moreText.style.display = "none";
    } 
    else {
        dots.style.display = "none";
        btnText.innerHTML = "Read less <i class=fas fa-chevron-up></i> ";
        moreText.style.display = "inline";
    
    }
}

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
  });
