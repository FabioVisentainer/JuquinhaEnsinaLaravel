let buracoPersonagem;
let buracoMonstro;
let pontuacao = 0;
let fimDeJogo = false;
let tempo = 0;
let intervaloTempo;
let intervaloPersonagem;
let intervaloMonstro;
let ultimaPosicaoPersonagem = -1; 


window.onload = function() {
    iniciarJogo();
    configurarArrastar(); 
}

function configurarArrastar() {
    const tabuleiro = document.getElementById("tabuleiro");
    let isTouching = false;

    tabuleiro.addEventListener("touchstart", function(e) {
        e.preventDefault(); 
        isTouching = true;
        const touch = e.touches[0];
        const elemento = document.elementFromPoint(touch.clientX, touch.clientY);
    });
    
    tabuleiro.addEventListener("touchmove", function(e) {
        if (!isTouching) return;
        e.preventDefault(); 
        const touch = e.touches[0];
        const elemento = document.elementFromPoint(touch.clientX, touch.clientY);
    });
    

    tabuleiro.addEventListener("touchend", function(e) {
        isTouching = false;
        e.preventDefault(); 
    });
    
}

function iniciarJogo() {
    fimDeJogo = false;
    pontuacao = 0;
    tempo = 0;
    document.getElementById("pontuacao").innerText = "Pontuação: " + pontuacao.toString();
    document.getElementById("tabuleiro").innerHTML = ""; 

    for (let i = 0; i < 9; i++) {
        let tile = document.createElement("div");
        tile.id = i.toString();
        tile.addEventListener("click", selecionarTile); // Clique do mouse
        tile.addEventListener("touchstart", selecionarTile); // Toque em dispositivos móveis
        document.getElementById("tabuleiro").appendChild(tile);
    }

    intervaloPersonagem = setInterval(colocarPersonagem, 2000);
    intervaloMonstro = setInterval(colocarMonstro, 2000);
    intervaloTempo = setInterval(contarTempo, 1000);
}

function pegarTileAleatorio() {
    let num = Math.floor(Math.random() * 9);
    return num.toString();
}

function colocarPersonagem() {
    if (fimDeJogo) return;

    if (buracoPersonagem) buracoPersonagem.innerHTML = "";

    let personagem = document.createElement("img");
    personagem.src = "./personagem.png";

    let num = pegarTileAleatorio();
    if (buracoMonstro && buracoMonstro.id == num) return;

    buracoPersonagem = document.getElementById(num);
    buracoPersonagem.appendChild(personagem);
}

function colocarMonstro() {
    if (fimDeJogo) return;

    if (buracoMonstro) buracoMonstro.innerHTML = "";

    let monstro = document.createElement("img");
    monstro.src = "./monstro.png";

    let num = pegarTileAleatorio();
    if (buracoPersonagem && buracoPersonagem.id == num) return;

    buracoMonstro = document.getElementById(num);
    buracoMonstro.appendChild(monstro);
}

function selecionarTile() {
    if (fimDeJogo) return;

    if (this == buracoPersonagem) {
        if (ultimaPosicaoPersonagem !== buracoPersonagem.id) { 
            pontuacao += 10; 
            document.getElementById("pontuacao").innerText = "Pontuação: " + pontuacao.toString();
            ultimaPosicaoPersonagem = buracoPersonagem.id; 
            
           
            document.getElementById("musica").play();
            
            
            if (pontuacao >= 200) {
                clearInterval(intervaloPersonagem);
                clearInterval(intervaloMonstro);
                intervaloPersonagem = setInterval(colocarPersonagem, 1000); 
                intervaloMonstro = setInterval(colocarMonstro, 1000); 
            } else if (pontuacao >= 600) {
                clearInterval(intervaloPersonagem);
                clearInterval(intervaloMonstro);
                intervaloPersonagem = setInterval(colocarPersonagem, 500); 
                intervaloMonstro = setInterval(colocarMonstro, 500); 
            }
        }
    } else if (this == buracoMonstro) {
        fimDeJogo = true;
        document.getElementById("pontuacao").innerText = "FIM DE JOGO: " + pontuacao.toString();
        encerrarJogo();
    }
}

function contarTempo() {
    if (fimDeJogo) return;
    tempo++;
    document.querySelector(".cronometro").innerText = "Tempo: " + tempo + "s";
}

function encerrarJogo() {
    clearInterval(intervaloPersonagem);
    clearInterval(intervaloMonstro);
    clearInterval(intervaloTempo);
    document.getElementById("tempo-final").innerText = "Tempo final: " + tempo + "s";
    document.getElementById("pontuacao-final").innerText = "Pontuação final: " + pontuacao;
    document.querySelector(".tela-fim-jogo").classList.add("mostrar");
    document.getElementById("jogar-novamente").addEventListener("click", reiniciarJogo);
}

function reiniciarJogo() {
    document.querySelector(".tela-fim-jogo").classList.remove("mostrar");
    ultimaPosicaoPersonagem = -1;
    iniciarJogo();
}
