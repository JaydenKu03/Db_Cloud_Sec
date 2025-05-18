const announcementTab = document.getElementById('announcement-tab');
const eventTab = document.getElementById('event-tab');
const announcementForm = document.getElementById('announcement-form');
const eventForm = document.getElementById('event-form');
const eventDate = document.getElementById('event_date');

announcementTab.addEventListener('click', () => {
    console.log('swicth to announcement');
    announcementTab.classList.add('active-tab');
    eventTab.classList.remove('active-tab');
    announcementForm.classList.add('active-form');
    eventForm.classList.remove('active-form');
});

eventTab.addEventListener('click', () => {
    console.log('swicth to event');
    eventTab.classList.add('active-tab');
    announcementTab.classList.remove('active-tab');
    eventForm.classList.add('active-form');
    announcementForm.classList.remove('active-form');
});

eventDate.addEventListener('change', function () {
    const selectedDate = new Date(this.value); // Get the selected date
    const today = new Date(); // Get today's date
    today.setHours(0, 0, 0, 0); // Remove time from today's date for accurate comparison

    if (selectedDate < today) {
        alert("Cannot choose a past date.");
        this.value = ''; // Clear the input field
    }
});
