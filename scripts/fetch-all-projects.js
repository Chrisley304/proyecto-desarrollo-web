// Fetch projects entries from the backend
fetch("/api/get_all_projects.php")
    .then((response) => response.json())
    .then((data) => {
        // Handle the data and update the UI
        const projectsContainer = document.getElementById("slider");
        const projectsArray = [];
        data.forEach((project) => {
            let projectObject = `
            <div class="slide">
                <div class="project_card">
                    <div class="project_card_shade"></div>
                    <img
                    src="data:image/png;base64,${project.cover_image}",
                        alt="Cover image"
                        class="project_card_cover_image"
                    />
                    <div class="project_card_info">
                        <h4>${project.title}</h4>
                        <p>
                            ${project.description}
                        </p>
                    </div>
                </div>
            </div>`;
            projectsArray.push(projectObject);
        });
        projectsContainer.innerHTML = projectsArray.join("");
    })
    .catch((error) => console.error("Error:", error));
