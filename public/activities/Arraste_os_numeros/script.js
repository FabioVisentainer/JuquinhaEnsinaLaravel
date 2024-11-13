const numbers = document.querySelectorAll('.number');
const hands = document.querySelectorAll('.hand-image');
const timerDisplay = document.getElementById('timer');
const endScreen = document.querySelector('.tela-fim-jogo');
const playAgainButton = document.getElementById('jogar-novamente');
let startTime = 0;
let timerInterval;
let correctMatches = 0;
let draggedNumber = null;
let originalPosition = {};
let isTimerStarted = false;

function shuffleHands() {
    const handPositions = Array.from({ length: hands.length }, (_, i) => i);
    handPositions.sort(() => Math.random() - 0.5); 

    handPositions.forEach((position, i) => {
        hands[i].style.order = position; 
    });
}

function handleMouseMove(event) {
    if (!draggedNumber) return;

    event.preventDefault(); 

    const deltaX = event.clientX - originalPosition.x;
    const deltaY = event.clientY - originalPosition.y;

    draggedNumber.style.left = `${event.clientX - draggedNumber.offsetWidth / 2}px`;
    draggedNumber.style.top = `${event.clientY - draggedNumber.offsetHeight / 2}px`;
}

function handleTouchMove(event) {
    if (!draggedNumber) return;

    event.preventDefault(); 

    let touch = event.touches[0];
    const deltaX = touch.clientX - originalPosition.x;
    const deltaY = touch.clientY - originalPosition.y;

    draggedNumber.style.left = `${touch.clientX - draggedNumber.offsetWidth / 2}px`;
    draggedNumber.style.top = `${touch.clientY - draggedNumber.offsetHeight / 2}px`;
}


function shuffleNumbers() {
    const numberContainer = document.querySelector('.numbers');
    const shuffledNumbers = Array.from(numbers).sort(() => Math.random() - 0.5);
    shuffledNumbers.forEach(number => {
        numberContainer.appendChild(number);
    });
}

function startTimer() {
    if (isTimerStarted) return;
    startTime = Date.now();
    timerInterval = setInterval(updateTimer, 1000);
    isTimerStarted = true;
}

function stopTimer() {
    clearInterval(timerInterval);
}

function updateTimer() {
    const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
    timerDisplay.textContent = `Tempo: ${elapsedTime} segundos`;
}

function resetGame() {
    numbers.forEach(number => {
        document.querySelector('.numbers').appendChild(number);
        number.style.display = 'block'; 
    });
    hands.forEach(hand => {
        hand.style.display = 'block'; 
    });
    correctMatches = 0;
    shuffleHands();
    shuffleNumbers();
    timerDisplay.textContent = "Tempo: 0 segundos";
    stopTimer();
    isTimerStarted = false;
    endScreen.classList.remove('mostrar'); 
}

function handleMouseDown(event) {
    event.preventDefault();
    draggedNumber = event.target;
    originalPosition = {
        x: event.clientX,
        y: event.clientY
    };
    event.target.style.position = 'absolute';
    event.target.style.zIndex = 1000;
    event.target.style.pointerEvents = 'none';
    startTimer();
}

function handleMouseMove(event) {
    if (!draggedNumber) return;
    draggedNumber.style.left = `${event.clientX - draggedNumber.offsetWidth / 2}px`;
    draggedNumber.style.top = `${event.clientY - draggedNumber.offsetHeight / 2}px`;
}

function handleMouseUp(event) {
    if (!draggedNumber) return;
    const hand = Array.from(hands).find(hand => {
        const handRect = hand.getBoundingClientRect();
        return (
            event.clientX >= handRect.left &&
            event.clientX <= handRect.right &&
            event.clientY >= handRect.top &&
            event.clientY <= handRect.bottom
        );
    });
    if (hand && draggedNumber.id === `number${hand.id.replace('hand', '')}`) {
        hand.style.display = 'none';
        draggedNumber.style.display = 'none';
        correctMatches++;

        if (correctMatches === numbers.length) {
            const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
            timerDisplay.textContent = `Tempo: ${elapsedTime} segundos`;
            stopTimer();

            
            document.getElementById('tempo-final').textContent = `Tempo final: ${elapsedTime} segundos`;
            
            setTimeout(() => {
                endScreen.classList.add('mostrar');
            }, 500);
        }
    }

    draggedNumber.style.position = 'static';
    draggedNumber.style.pointerEvents = 'auto';
    draggedNumber = null;
}

function handleTouchStart(event) {
    event.preventDefault();
    draggedNumber = event.target;
    originalPosition = {
        x: event.touches[0].clientX,
        y: event.touches[0].clientY
    };
    event.target.style.position = 'absolute';
    event.target.style.zIndex = 1000;
    event.target.style.pointerEvents = 'none';
    startTimer();
}

function handleTouchMove(event) {
    if (!draggedNumber) return;

    let touch = event.touches[0];
    draggedNumber.style.left = `${touch.clientX - draggedNumber.offsetWidth / 2}px`;
    draggedNumber.style.top = `${touch.clientY - draggedNumber.offsetHeight / 2}px`;
}

function handleTouchEnd(event) {
    if (!draggedNumber) return;

    const touch = event.changedTouches[0];
    const hand = Array.from(hands).find(hand => {
        const handRect = hand.getBoundingClientRect();
        return (
            touch.clientX >= handRect.left &&
            touch.clientX <= handRect.right &&
            touch.clientY >= handRect.top &&
            touch.clientY <= handRect.bottom
        );
    });

    if (hand && draggedNumber.id === `number${hand.id.replace('hand', '')}`) {
        hand.style.display = 'none';
        draggedNumber.style.display = 'none';
        correctMatches++;

        if (correctMatches === numbers.length) {
            const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
            timerDisplay.textContent = `Tempo: ${elapsedTime} segundos`;
            stopTimer();
            
            
            document.getElementById('tempo-final').textContent = `Tempo final: ${elapsedTime} segundos`;
        
            setTimeout(() => {
                endScreen.classList.add('mostrar');
            }, 500);
        }
    }        

    draggedNumber.style.position = 'static';
    draggedNumber.style.pointerEvents = 'auto';
    draggedNumber = null;
}

numbers.forEach(number => {
    number.addEventListener('mousedown', handleMouseDown);
    number.addEventListener('touchstart', handleTouchStart);
});

document.addEventListener('mousemove', handleMouseMove);
document.addEventListener('mouseup', handleMouseUp);
document.addEventListener('touchmove', handleTouchMove);
document.addEventListener('touchend', handleTouchEnd);

playAgainButton.addEventListener('click', resetGame);

shuffleHands();
shuffleNumbers();
