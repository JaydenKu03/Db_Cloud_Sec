// load_annoucement();

// function load_annoucement() {
//     //TODO: remove current existing annoucement then request php to
//     // echo latest data from the Annoucement_Table in db 
// }

// function post_annoucement(){
//     const text = document.getElementById("post-content").value;

//     if(text) {
//         let confirmation = window.confirm("Are You Sure You want to Post the Content?")

//         if(confirmation) {
//             const announcement_content = document.getElementById("announcement-content");

//             const newAnnoucement = document.createElement("div")
//             newAnnoucement.textContent = text
//             newAnnoucement.className = "annoucement-text"
//             announcement_content.appendChild(newAnnoucement);

//             //TODO: fetch data to php to update Annoucement_Table in db 
//             // and call for load_annoucement() 
//         }
//     }
//     else{
//         window.alert("Your Announcement Content Cannot Be Empty")
//     }
// }


const calendar_caption = document.getElementById("calendar-caption");
const calendar_data = document.getElementById("calendar-data");
const months_array = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

let dateObj = new Date();

let date = dateObj.getDate()
let month = dateObj.getMonth(); //(0 = January, 11 = December)
let year = dateObj.getFullYear();

let firstDay = new Date(year, month, 1); //first day obj of the month
let dayOfWeek = 2; //day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
let daysInMonth = new Date(year, month + 1, 0).getDate(); //number of days in the current month

//add calendar caption
calendar_caption.textContent = months_array[month] + " " + year

//add calendar data
let currentDay = 1;
for (let i = 0; i < 6; i++) {
    let row = document.createElement("tr");

    for (let j = 0; j < 7; j++) {
        let cell = document.createElement("td");

        if (i === 0 && j < dayOfWeek) {
            cell.textContent = "";
        } else if (currentDay > daysInMonth) {
            cell.textContent = ""; 
        } else {

            if(currentDay == date){
                cell.className = "today"
            }
            cell.textContent = currentDay;
            currentDay++;
        }
        row.appendChild(cell);
    }

    calendar_data.appendChild(row);

    if (currentDay > daysInMonth) {
        break;
    }
}

