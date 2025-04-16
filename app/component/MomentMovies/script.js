let templateFile = await fetch("./component/MomentMovies/template.html");
let template = await templateFile.text();
let templateLiFile = await fetch("./component/MomentMovies/template_li.html");
let templateLi = await templateLiFile.text();

let MomentMovies = {};

MomentMovies.format = function (movies) {
  if (!movies || movies.length === 0) {
    return "<p>Aucun film mis en avant pour le moment.</p>";
  }

  let formattedMovies = "";
  for (let movie of movies) {
    let movieHtml = template;
    movieHtml = movieHtml.replace("{{image}}", movie.image);
    movieHtml = movieHtml.replace("{{name}}", movie.name);
    movieHtml = movieHtml.replace("{{description}}", movie.description || "Pas de description disponible");
    movieHtml = movieHtml.replace(
      "{{handler}}",
      `C.handlerDetail(${movie.id})`
    );
    formattedMovies += movieHtml;
  }

  let finalHtml = templateLi;
  finalHtml = finalHtml.replace("{{moment}}", formattedMovies);
  
  // Initialiser le carrousel après le chargement
  setTimeout(() => {
    if (typeof window.MomentMoviesCarousel === 'undefined') {
      window.MomentMoviesCarousel = {
        currentSlide: 0,
        totalSlides: movies.length,
        
        next: function() {
          this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
          this.updateCarousel();
        },
        
        prev: function() {
          this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
          this.updateCarousel();
        },
        
        updateCarousel: function() {
          const carousel = document.getElementById('moment-carousel');
          if (carousel) {
            // Réinitialise complètement la transformation à chaque appel
            carousel.style.transform = `translateX(-${this.currentSlide * 100}%)`;
          }
        }
      };
    } else {
      window.MomentMoviesCarousel.totalSlides = movies.length;
      window.MomentMoviesCarousel.currentSlide = 0;
      window.MomentMoviesCarousel.updateCarousel();
    }
  }, 100);
  
  return finalHtml;
};

export { MomentMovies };