document.addEventListener("DOMContentLoaded", function () {
    const projectList = document.getElementById("project-list");
    
    // Example of dynamically adding projects
    const projects = [
        { name: "Project 1", description: "Description for Project 1" },
        { name: "Project 2", description: "Description for Project 2" }
    ];
    
    projects.forEach(project => {
        const projectDiv = document.createElement("div");
        projectDiv.innerHTML = `<h3>${project.name}</h3><p>${project.description}</p>`;
        projectList.appendChild(projectDiv);
    });
});
