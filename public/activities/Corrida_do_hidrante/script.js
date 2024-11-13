const mario = document.querySelector('.mario');
const pipe = document.querySelector('.pipe');
const coin = document.querySelector('.coin');
const clouds = document.querySelector('.clouds');
const tree = document.querySelector('.tree');
const bird = document.querySelector('.bird');
const timerDisplay = document.querySelector('.timer');
const scoreDisplay = document.querySelector('.score');
const gameOverScreen = document.querySelector('.game-over-screen');
const finalScoreDisplay = document.querySelector('#final-score');
const finalTimeDisplay = document.querySelector('#final-time');

let time = 0;
let score = 0;
let isGameOver = false;
let isGameStarted = false;
let coinCollected = false;
let loop, timer;

const marioJumpStatic = 'mario-jump.png'; 
const marioGif = 'mario.gif';

const jump = () => {
    if (!isGameOver && !mario.classList.contains('jump')) {
        mario.src = marioJumpStatic;
        mario.classList.add('jump');
        mario.addEventListener('animationend', () => {
            mario.src = marioGif;
            mario.classList.remove('jump');
        }, { once: true });
    }
};

const startTimer = () => {
    if (!timer) {  
        timer = setInterval(() => {
            if (!isGameOver) {
                time++;
                timerDisplay.innerText = `Tempo: ${time}s`;
            }
        }, 1000); 
    }
};


const increaseScore = () => {
    score++;
    scoreDisplay.innerText = `Pontuação: ${score}`;
};

const startGame = () => {
    if (!isGameStarted) {
        isGameStarted = true;
        startTimer(); 
    }
};

const checkCoinCollision = () => {
    const coinPosition = coin.offsetLeft / window.innerWidth * 100; 
    const marioPosition = parseFloat(window.getComputedStyle(mario).bottom) / window.innerHeight * 100;

    if (coinPosition <= 20 && coinPosition > 0 && marioPosition > 10 && !coinCollected) {
        increaseScore();
        coin.style.display = 'none';
        coinCollected = true;

        setTimeout(() => {
            coinCollected = false;
            coin.style.display = 'block';
            coin.style.right = `-${Math.random() * 10 + 5}vw`;
        }, 3000);
    }
};

const gameLoop = () => {
    loop = setInterval(() => {
        const pipePosition = pipe.offsetLeft;
        const marioPosition = +window.getComputedStyle(mario).bottom.replace('px', '');

       
        let collisionDistance = 120; 

        if (window.innerWidth < 1025 && window.innerWidth > 769) {
            collisionDistance = 90; 
        } else if (window.innerWidth < 769 && window.innerWidth > 427) {
            collisionDistance = 70; 
        } else if (window.innerWidth < 426 && window.innerWidth > 300) {
            collisionDistance = 30; 
        }

        
        if (!isGameOver && pipePosition <= collisionDistance && pipePosition > 0 && marioPosition < 30) {
            stopGame(pipePosition, marioPosition);
        }

        checkCoinCollision();
    }, 50);
};


const stopGame = (pipePosition, marioPosition) => {
    pipe.style.animation = 'none';
    pipe.style.left = `${pipePosition}px`;

    mario.style.animation = 'none';
    mario.style.bottom = `${marioPosition}px`;

    clouds.style.animation = 'none';
    tree.style.animation = 'none';
    bird.style.animation = 'none';
    coin.style.animation = 'none';

    clearInterval(loop);
    isGameOver = true;

    finalScoreDisplay.innerText = `Pontuação: ${score}`;
    finalTimeDisplay.innerText = `Tempo: ${time}s`;
    gameOverScreen.classList.add('show');
};

const restartGame = () => {
    if (isGameOver) {
        score = 0;
        time = 0;
        isGameOver = false;
        coinCollected = false;

        mario.src = 'mario.gif';   
        mario.style.animation = '';

        pipe.style.animation = '';
        pipe.style.left = '';

        clouds.style.animation = '';
        tree.style.animation = '';
        bird.style.animation = '';
        coin.style.animation = '';
        coin.style.left = '';

        scoreDisplay.innerText = `Pontuação: ${score}`;
        timerDisplay.innerText = `Tempo: ${time}s`;

        gameOverScreen.classList.remove('show');

        clearInterval(timer); 
        timer = null; 
        startTimer(); 
        gameLoop(); 
    }
};


const marioPosition = parseFloat(window.getComputedStyle(mario).bottom) / window.innerHeight * 100; 

window.addEventListener('resize', () => {
    
    const marioWidth = mario.offsetWidth / window.innerWidth * 100; 
    const marioHeight = mario.offsetHeight / window.innerHeight * 100; 
    const pipePosition = pipe.offsetLeft / window.innerWidth * 100; 
});


document.addEventListener('keydown', () => {
    jump();
    startGame();
});

document.addEventListener('click', () => {
    jump();
    startGame();
});


document.addEventListener('click', restartGame);

gameLoop(); 
