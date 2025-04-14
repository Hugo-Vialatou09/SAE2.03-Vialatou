let templateFile = await fetch('./component/ProfileForm/template.html');
let template = await templateFile.text();


let ProfileForm = {};

ProfileForm.format = function(profiles, handler){
    let html= template;
    let options = "";
    for (let i = 0; i < profiles.length; i++) {
        const p = profiles[i];
        options += `<option value="${p.id}" data-name="${p.name}" data-avatar="${p.avatar}" data-age="${p.min_age}">${p.name}</option>`;
    }
    html = html.replace('{{options}}', options);
    html = html.replace('{{handler}}', handler);
    return html;
}

ProfileForm.init = function () {
    const select = document.getElementById("profile-selecte");
    const idfield = document.getElementById("profile-id");
    const namefield = document.getElementById("profile-name");
    const avatarfield = document.getElementById("profile-avatar");
    const minagefield = document.getElementById("profile-min-age");

    select.addEventListener("change", (event) => {
        const selectedOption = event.target.selectedOptions[0];
        if (selectedOption){
            idfield.value = selectedOption.value || "";
            namefield.value = selectedOption.dataset.name || "";
            avatarfield.value = selectedOption.dataset.avatar || "";
            minagefield.value = selectedOption.dataset.age || "";  
        } 
        });
    };

export {ProfileForm};


