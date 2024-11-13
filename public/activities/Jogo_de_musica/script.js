const script = document.createElement('script');
script.src = "https://vlibras.gov.br/app/vlibras-plugin.js";
script.onload = () => new window.VLibras.Widget('https://vlibras.gov.br/app');
document.body.appendChild(script);

function positionAnimalsInLine() {
    const container = document.getElementById('gameContainer');
    const animals = document.querySelectorAll('.animal');
    const containerWidth = container.offsetWidth;
    const containerHeight = container.offsetHeight;
    const animalWidth = animals[0].offsetWidth;

    
    const totalAnimals = animals.length;
    const totalSpacing = (containerWidth - (totalAnimals * animalWidth)) / (totalAnimals + 1);

    
    const fixedTop = (containerHeight - animals[0].offsetHeight) / 1.6;

   
    animals.forEach((animal, index) => {
        const positionX = totalSpacing * (index + 1) + animalWidth * index;
        animal.style.left = `${positionX}px`;
        animal.style.top = `${fixedTop}px`;
    });
}


function playSound(soundId) {
    const audioElement = document.getElementById(soundId);
    if (audioElement) {
        audioElement.currentTime = 0; 
        audioElement.play();
    }
}


function stopSound(soundId) {
    const audioElement = document.getElementById(soundId);
    if (audioElement) {
        audioElement.pause();
    }
}

function isMobileDevice() {
    return /Mobi|Android/i.test(navigator.userAgent);
}

function setupAnimalInteraction() {
    const animals = document.querySelectorAll('.animal');
    const isMobile = isMobileDevice();

    animals.forEach(animal => {
        const soundId = animal.getAttribute('data-sound');

        if (isMobile) {
            
            animal.addEventListener('click', () => playSound(soundId));
        } else {
            
            animal.addEventListener('mouseenter', () => playSound(soundId));
            animal.addEventListener('mouseleave', () => stopSound(soundId));
        }
    });
}


window.onload = () => {
    positionAnimalsInLine();
    setupAnimalInteraction();
};

window.onresize = () => {
    positionAnimalsInLine(); 
};