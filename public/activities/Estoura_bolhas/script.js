const gameArea = document.getElementById('gameArea');
const scoreDisplay = document.getElementById('score');
const parabensScreen = document.querySelector('.tela-fim-jogo');
const finalMessage = document.getElementById('mensagem-final');
const finalScoreDisplay = document.getElementById('pontuacao-final');
const finalTimeDisplay = document.getElementById('tempo-final');
const playAgainBtn = document.getElementById('jogar-novamente');
const timeDisplay = document.getElementById('time');

let score = 0;
let bubbleCount = 0;
const maxBubbles = 50;
const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
let foundLetters = new Set();
let totalTime = 0;
let timerInterval;
const clickedLetters = new Set();  // Armazena as letras que já foram clicadas


function startTimer() {
    timerInterval = setInterval(() => {
        totalTime++;
        timeDisplay.textContent = totalTime;
    }, 1000);
}

function createBubble() {
    if (foundLetters.size === 26) {
        showEndScreen(false);
        clearInterval(bubbleInterval);
        clearInterval(timerInterval);
        return;
    }

    const bubble = document.createElement('div');
    bubble.classList.add('bubble');
    bubbleCount++;

    bubble.style.left = `${Math.random() * 90}vw`;

    // Bolha preta que encerra o jogo
    if (Math.random() < 0.1) {
        bubble.style.backgroundColor = '#000';
        bubble.addEventListener('click', () => {
            showEndScreen(true); // Jogo acaba ao clicar na bola preta
        });
    } else {
        bubble.style.backgroundColor = getRandomColor();
        bubble.addEventListener('click', popBubble);

        if (Math.random() < 0.5) {  // Aumenta a frequência de letras para 50%
            let randomChar;
            do {
                randomChar = characters.charAt(Math.floor(Math.random() * characters.length));
            } while (clickedLetters.has(randomChar));  // Evita que letras já clicadas apareçam

            bubble.textContent = randomChar;
            bubble.dataset.letter = randomChar;
        }
    }

    gameArea.appendChild(bubble);

    setTimeout(() => {
        if (bubble.parentNode) {
            bubble.remove();
        }
    }, 5000);
}

function getRandomColor() {
    const colors = ['#FF6347', '#FFA500', '#FFD700', '#ADFF2F', 'red', '#9370DB', '#FFC0CB'];
    return colors[Math.floor(Math.random() * colors.length)];
}

function popBubble(event) {
    const bubble = event.target;

    if (bubble.dataset.letter && !clickedLetters.has(bubble.dataset.letter)) {
        clickedLetters.add(bubble.dataset.letter);
        foundLetters.add(bubble.dataset.letter);
        score++;
        scoreDisplay.textContent = `Pontuação: ${score}`;

        if (foundLetters.size === 26) {
            showEndScreen(false); // Venceu ao coletar todas as letras
        }
    }
    bubble.remove();
}

function showEndScreen(isGameOver) {
    if (isGameOver) {
        finalMessage.innerHTML = "Você perdeu! Clicou na bola preta!"
    } else if (foundLetters.size === 26) {
        finalMessage.innerHTML= "Parabéns, você venceu!!";
    } else {
        finalMessage.innerHTML =  "Parabéns, você venceu!!";
    }

    finalScoreDisplay.textContent = `Pontuação final: ${score}`;
    finalTimeDisplay.textContent = `Tempo: ${totalTime}s`;
    
    parabensScreen.style.display = 'flex';
    gameArea.style.display = 'none';

    clearInterval(bubbleInterval);
    clearInterval(timerInterval);
}

function resetGame() {
    score = 0;
    bubbleCount = 0;
    foundLetters.clear();
    clickedLetters.clear();
    totalTime = 0;

    scoreDisplay.textContent = `Pontuação: ${score}`;
    timeDisplay.textContent = totalTime;

    parabensScreen.style.display = 'none';
    gameArea.style.display = 'block';
    
    clearInterval(bubbleInterval);
    bubbleInterval = setInterval(createBubble, 1000);
    startTimer();
}

let bubbleInterval = setInterval(createBubble, 1000);
startTimer();

playAgainBtn.addEventListener('click', resetGame);
