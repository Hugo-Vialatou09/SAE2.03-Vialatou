let HOST_URL = "../server";

let DataProfile = {};

DataProfile.addProfile = async function (fdata) {
  
    let config = {
      method: "POST",
      body: fdata,
    };
    let answer = await fetch(HOST_URL + "/script.php?todo=addProfile", config);
    let data = await answer.json();
    return data;
  };

DataProfile.getAllProfile = async function () {
    let config = {
      method: "GET",
    };
    let answer = await fetch(HOST_URL + "/script.php?todo=readProfile");
    let data = await answer.json();
    return data;
  }  
  

export { DataProfile };