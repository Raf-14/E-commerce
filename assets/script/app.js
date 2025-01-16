// JavaScript pour le menu burger
// JavaScript pour le menu burger
const mobileMenu = document.getElementById('mobile-menu'); // Le bouton burger
const navbar = document.querySelector('.navbar ul'); // Liste de navigation

// Ajoute ou enlève la classe 'active' lors du clic sur le bouton burger
mobileMenu.addEventListener('click', () => {
    navbar.classList.toggle('active'); // Toggle la classe 'active' pour afficher ou masquer le menu
    mobileMenu.classList.toggle('active'); // Change l'état visuel du burger (optionnel)
});
