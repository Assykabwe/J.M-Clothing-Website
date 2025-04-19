document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.querySelector('#user-btn');
    const userBox = document.querySelector('.profile-detail');

    if (!userBtn) {
        console.error('Error: #user-btn not found.');
    }
    if (!userBox) {
        console.error('Error: .profile-detail not found.');
    }

    userBtn?.addEventListener('click', () => {
        userBox.classList.toggle('active');
        console.log("Profile detail toggled!");
    });

    // Select the menu button and sidebar
    const menuBtn = document.querySelector('.fa-bars'); // Select the menu icon
    const sidebar = document.querySelector('.sidebar'); // Make sure sidebar exists

    // Check if elements exist before adding event listener
    if (!menuBtn) {
        console.error('Error: .fa-bars not found.');
    }
    if (!sidebar) {
        console.error('Error: .sidebar not found.');
    }

    // Toggle sidebar on menu button click
    menuBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        console.log("Sidebar toggled!");
    });
});