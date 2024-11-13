let startTime, timerInterval;
let blocksCorrectlyPlaced = 0;
const colors = ["red", "blue", "green", "yellow", "purple", "black", "gray", "pink", "orange", "cyan"]; 
const rows = 9;
const blocksPerRow = 9;

function startTimer() {
    if (!startTime) {
        startTime = new Date();
        timerInterval = setInterval(updateTimerDisplay, 1000);
    }
}

function updateTimerDisplay() {
    const currentTime = new Date();
    const elapsedSeconds = Math.floor((currentTime - startTime) / 1000);
    document.getElementById("timer").textContent = `Tempo: ${elapsedSeconds}s`;
}

function stopTimer() {
    clearInterval(timerInterval);
    const endTime = new Date();
    const timeTaken = ((endTime - startTime) / 1000).toFixed(2);
    
    
    const telaFimJogo = document.querySelector('.tela-fim-jogo');
    telaFimJogo.classList.add('mostrar');
    document.getElementById('tempo-final').textContent = `Tempo final: ${timeTaken}s`;
    document.getElementById('pontuacao-final').textContent = "Você completou o desafio!";
    
    
    document.getElementById('jogar-novamente').addEventListener('click', () => {
        telaFimJogo.classList.remove('mostrar');
        resetGame();
    });
}


function resetGame() {
    blocksCorrectlyPlaced = 0;
    startTime = null;
    clearInterval(timerInterval);
    document.getElementById("timer").textContent = "Tempo: 0s";
    generateGrid(); 
    initializeDragAndDrop();
}

function generateGrid() {
    const grid = document.getElementById("grid");
    grid.innerHTML = "";
    const dragContainer = document.getElementById("dragContainer");
    dragContainer.innerHTML = "";

    
    const shuffledColors = shuffleColors(colors.slice(0, 9)); 

    
    shuffledColors.forEach((color, rowIndex) => {
        const row = document.createElement("div");
        row.className = "row";

        for (let i = 0; i < blocksPerRow; i++) {
            const block = document.createElement("div");
            block.className = "block";
            block.style.backgroundColor = color;

            
            if (Math.random() < 0.3 && i > 0 && i < blocksPerRow - 1) {
                block.style.backgroundColor = "white";
                block.dataset.color = color;
                block.id = `empty_${color}_${i}`;
            }
            row.appendChild(block);
        }
        grid.appendChild(row);

        
        const emptyBlocksInRow = Array.from(row.children).filter(block => block.style.backgroundColor === "white");
        emptyBlocksInRow.forEach(() => {
            const dragBlock = document.createElement("div");
            dragBlock.className = "block";
            dragBlock.style.backgroundColor = color;
            dragBlock.draggable = true;
            dragBlock.id = `drag${color}_${Math.random().toString(36).substring(2, 9)}`;
            dragContainer.appendChild(dragBlock);
        });
    });

    
    const dragBlocks = document.querySelectorAll('.drag-container .block');
    const dragArray = Array.from(dragBlocks);
    dragArray.sort(() => Math.random() - 0.5); 

    dragArray.forEach(block => {
        dragContainer.appendChild(block); 
    });
}

function shuffleColors(arr) {
    
    const shuffledArr = [...arr];
    for (let i = shuffledArr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [shuffledArr[i], shuffledArr[j]] = [shuffledArr[j], shuffledArr[i]]; 
    }
    return shuffledArr;
}

function initializeDragAndDrop() {
    const dragBlocks = document.querySelectorAll('.drag-container .block');
    const emptyBlocks = document.querySelectorAll('.container .block[style*="background-color: white"]');
    const totalEmptyBlocks = emptyBlocks.length;

    dragBlocks.forEach(block => {
        block.addEventListener('dragstart', (event) => {
            startTimer();
            event.dataTransfer.setData('blockId', event.target.id);
        });

        block.addEventListener('touchstart', (event) => {
            startTimer();
            
            block.dataset.touching = "true";
            block.dataset.startX = event.touches[0].clientX;
            block.dataset.startY = event.touches[0].clientY;
        });

        block.addEventListener('touchmove', (event) => {
            const block = event.target;
            const x = event.touches[0].clientX;
            const y = event.touches[0].clientY;
            block.style.position = 'absolute';
            block.style.left = `${x - (block.offsetWidth / 2)}px`;
            block.style.top = `${y - (block.offsetHeight / 2)}px`;
        });

        block.addEventListener('touchend', (event) => {
            const x = event.changedTouches[0].clientX;
            const y = event.changedTouches[0].clientY;
            block.style.position = 'relative';
            block.style.left = 'auto';
            block.style.top = 'auto';

            
            emptyBlocks.forEach(emptyBlock => {
                const rect = emptyBlock.getBoundingClientRect();
                if (x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom) {
                    if (block.style.backgroundColor === emptyBlock.dataset.color) {
                        emptyBlock.style.backgroundColor = block.style.backgroundColor;
                        block.remove();
                        blocksCorrectlyPlaced++;
                    
                        if (blocksCorrectlyPlaced === totalEmptyBlocks) {
                            stopTimer();
                        }
                    } else {
                       
                        emptyBlock.classList.add('incorrect');
                        setTimeout(() => {
                            emptyBlock.classList.remove('incorrect');
                        }, 500);
                    }
                    
                }
            });
            block.dataset.touching = "false"; 
        });
    });

    emptyBlocks.forEach(block => {
        block.addEventListener('dragover', (event) => {
            event.preventDefault();
        });

        block.addEventListener('drop', (event) => {
            event.preventDefault();
            const blockId = event.dataTransfer.getData('blockId');
            const draggedBlock = document.getElementById(blockId);

            if (draggedBlock && draggedBlock.style.backgroundColor === block.dataset.color) {
                block.style.backgroundColor = draggedBlock.style.backgroundColor;
                draggedBlock.remove();
                blocksCorrectlyPlaced++;
            
                if (blocksCorrectlyPlaced === totalEmptyBlocks) {
                    stopTimer();
                }
            } else {
                
                block.classList.add('incorrect');
                setTimeout(() => {
                    block.classList.remove('incorrect');
                }, 500);
            }            
        });
    });
}

resetGame();