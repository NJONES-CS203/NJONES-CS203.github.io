function DarkMode(){
    var element = document.body;
    element.classList.toggle("dark-mode");
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
