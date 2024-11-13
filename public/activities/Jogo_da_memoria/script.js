const grid = document.querySelector('.grid');
const timer = document.querySelector('.timer');
const levelDisplay = document.querySelector('.level'); 
const telaFimJogo = document.querySelector('.tela-fim-jogo');
const exibicaoTempoFinal = document.querySelector('#tempo-final');
const exibicaoPontuacaoFinal = document.querySelector('#pontuacao-final');
const botaoNovamente = document.querySelector('#jogar-novamente');

const script = document.createElement('script');
script.src = "https://vlibras.gov.br/app/vlibras-plugin.js";
script.onload = () => new window.VLibras.Widget('https://vlibras.gov.br/app');
document.body.appendChild(script);

const characters = [
    'passaro',
    'cavalo',
    'gato',
    'leão',
    'coelho',
    'cachorro',
    'peixe',
    'macaco', 
    'vaca',
    'elefante'
];

const createElement = (tag, className) => {
    const element = document.createElement(tag);
    element.className = className;
    return element;
};

let firstCard = '';
let secondCard = '';
let currentLevel = 1;
let maxLevel = 4; 
let loop; 
let currentTime = 0;


const getCharactersForLevel = (level) => {
    switch(level) {
        case 1:
            return characters.slice(0, 2)
        case 2:
            return characters.slice(0, 4)
        case 3:
            return characters.slice(0, 6)
        case 4:
            return characters.slice(0, 8)
        case 5: 
            return characters.slice(0, 10)
        default:
            return characters.slice(0, 10)
    }
};

const checkEndGame = () => {
    const disabledCards = document.querySelectorAll('.disable-card');
    const currentCharacters = getCharactersForLevel(currentLevel);
    
    if (disabledCards.length === currentCharacters.length * 2) {
        clearInterval(loop);

        if (currentLevel < maxLevel) {
            currentLevel++; 
            setTimeout(() => {
                loadNextLevel();
            }, 1000);
        } else {
            const tempo = currentTime; 
            exibicaoTempoFinal.textContent = `Tempo final: ${tempo}s`;
            exibicaoPontuacaoFinal.textContent = "Você completou o desafio!";
            telaFimJogo.classList.add('mostrar'); 
        }
    }
};

botaoNovamente.addEventListener('click', () => {
    telaFimJogo.classList.remove('mostrar'); 
    currentLevel = 1; 
    currentTime = 0; 
    loadGame(currentLevel); 
    startTimer(); 
});

const checkCards = () => {
    const firstCharacter = firstCard.getAttribute('data-character'); 
    const secondCharacter = secondCard.getAttribute('data-character');

    if (firstCharacter === secondCharacter) {
        firstCard.firstChild.classList.add('disable-card');
        secondCard.firstChild.classList.add('disable-card');

        firstCard = '';
        secondCard = '';

        checkEndGame();

    } else {
        setTimeout(() => {
            firstCard.classList.remove('reveal-card');
            secondCard.classList.remove('reveal-card');

            firstCard = '';
            secondCard = '';

        }, 500);
    }
};

const revealCard = ({ target }) => {
    if (target.parentNode.className.includes('reveal-card') || target.parentNode.className.includes('disable-card')) {
        return;
    }

    if (firstCard === '') {
        target.parentNode.classList.add('reveal-card');
        firstCard = target.parentNode;

    } else if (secondCard === '') {
        target.parentNode.classList.add('reveal-card');
        secondCard = target.parentNode;

        checkCards();
    }
};

const createCard = (character) => {
    const card = createElement('div', 'card');
    const front = createElement('div', 'face front');
    const back = createElement('div', 'face back');

    front.style.backgroundImage = `url('${character}.png')`; 

    card.appendChild(front);
    card.appendChild(back);

    card.addEventListener('click', revealCard);
    card.setAttribute('data-character', character);

    return card;
};

const loadGame = (level) => {
    grid.innerHTML = ''; 
    currentTime = 0;
    timer.innerHTML = currentTime;
    levelDisplay.innerHTML = `Nível ${level}`; 

    const currentCharacters = getCharactersForLevel(level);
    const duplicateCharacters = [ ...currentCharacters, ...currentCharacters ];

    const shuffledArray = duplicateCharacters.sort(() => Math.random() - 0.5);

    shuffledArray.forEach((character) => { 
        const card = createCard(character);
        grid.appendChild(card);
    });

    const allCards = document.querySelectorAll('.card');
    allCards.forEach(card => card.classList.add('reveal-card'));

    setTimeout(() => {
        allCards.forEach(card => card.classList.remove('reveal-card'));
    }, 2000); 

    if (level === 1) {
        grid.style.maxWidth = '250px'; 
        grid.style.marginTop = '50px';
    } else if (level === 2) {
        grid.style.maxWidth = '500px';
        grid.style.marginTop = '40px';
    } else if (level === 3) {
        grid.style.maxWidth = '500px';
        grid.style.marginTop = '30px';
    } else if (level === 4) {
        grid.style.maxWidth = '500px';
        grid.style.marginTop = '20px'; 
    } else {
        grid.style.maxWidth = '600px';
    }
};

const loadNextLevel = () => {
    loadGame(currentLevel);
    setTimeout(() => {
        clearInterval(loop);
        startTimer();
    }, 2000); 
};

const startTimer = () => {
    loop = setInterval(() => {
        currentTime += 1;
        timer.innerHTML = currentTime;
    }, 1000);
};

window.onload = () => {
    loadGame(currentLevel);
    setTimeout(() => {
        startTimer();
    }, 2000); 
};
