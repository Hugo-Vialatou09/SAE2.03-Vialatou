let templateFile = await fetch('./component/NewMovie/template.html');
let template = await templateFile.text();


let NewMovie = {};

NewMovie.format = function(handler){
    let html= template;
    html = html.replace('{{handler}}', handler);
    return html;
}


export { NewMovie };