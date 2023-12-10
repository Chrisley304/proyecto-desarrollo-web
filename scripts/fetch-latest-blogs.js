// Fetch latest blog entries from the backend
fetch("/api/get_latest_blogs.php")
    .then((response) => response.json())
    .then((data) => {
        // Handle the data and update the UI
        const latestBlogsContainer =
            document.getElementById("latest_blog_list");
        const blogsArray = [];
        data.forEach((blog) => {
            let blogObject = `
            <div class="blog_card">
                <a href="/blog/detalle.php?id=${blog.id}">
                    <div class="blog_card_image_container">
                        <img
                            src="data:image/png;base64,${blog.cover_image}",
                            alt="Blog post cover"
                            class="blog_card_image"
                        />
                    </div>
                    <div class="blog_card_content">
                        <h5 class="blog_card_category">${blog.category}</h5>
                        <h3 class="blog_card_title">${blog.title}</h3>
                        <p class="blog_card_description">
                            ${blog.description}
                        </p>
                        <div class="blog_card_author">
                                <img
                                    src="data:image/jpeg;base64,${blog.author_photo}",
                                    alt="${blog.author_name} foto"
                                />
                            <p>${blog.author_name}</p>
                        </div>
                    </div>
                </a>
            </div>
            `;
            blogsArray.push(blogObject);
        });
        latestBlogsContainer.innerHTML = blogsArray.join("");
    })
    .catch((error) => console.error("Error fetching latest blogs:", error));
