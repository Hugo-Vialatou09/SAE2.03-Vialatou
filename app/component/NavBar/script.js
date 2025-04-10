let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = async function (hAbout, hHome, profile) {
  console.log("Profils reçus :", profile); // Vérifiez les données
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);

  let options = "";
  for (let i = 0; i < profile.length; i++) {
    let currentProfile = profile[i];
    console.log("Profil actuel :", currentProfile); // Vérifiez les données
    options += `<option value="${currentProfile.id}" data-img="${currentProfile.avatar}" data-age="${currentProfile.min_age}">${currentProfile.name}</option>`;
  }

  let image = profile[0]?.avatar || "";
  html = html.replace("{{profileOptions}}", options);
  html = html.replace("{{image}}", image);
  return html;
};

export { NavBar };
