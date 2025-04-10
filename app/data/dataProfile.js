let HOST_URL = "https://mmi.unilim.fr/~vialatou2/SAE2.03-Vialatou";

let DataProfile = {};

DataProfile.read = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readProfile");
  if (!answer.ok) {
    console.error(`Erreur HTTP : ${answer.status}`);
    return []; // Retourne un tableau vide en cas d'erreur HTTP
  }
  let profile = await answer.json();
  return profile;
};

export { DataProfile };