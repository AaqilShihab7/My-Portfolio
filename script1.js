document.addEventListener('DOMContentLoaded', () => {
    loadQualifications();

    document.getElementById('educationForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

        try {
            const response = await fetch('add_education.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.text();
            if (result === 'success') {
                alert('Qualification added successfully!');
                loadQualifications();
                e.target.reset(); // Clear the form
            } else {
                alert('Error adding qualification.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});

async function loadQualifications() {
    const response = await fetch('fetch_education.php');
    const data = await response.text();
    document.getElementById('educationList').innerHTML = data;
}
