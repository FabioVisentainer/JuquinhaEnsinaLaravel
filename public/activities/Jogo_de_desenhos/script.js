const tela = document.querySelector("canvas");
const contexto = tela.getContext("2d");

const entradaCor = document.querySelector(".entrada__cor");
const ferramentas = document.querySelectorAll(".botao__ferramenta");
const botoesTamanho = document.querySelectorAll(".botao__tamanho");
const botaoLimpar = document.querySelector(".botao__limpar");

let tamanhoPincel = 20;
let pintando = false;
let ferramentaAtiva = "pincel";


entradaCor.addEventListener("change", ({ target }) => {
    contexto.fillStyle = target.value;
});


const getPosicao = (evento) => {
    const rect = tela.getBoundingClientRect();
    const escalaX = tela.width / rect.width;  
    const escalaY = tela.height / rect.height; 
    const x = ((evento.clientX || evento.touches[0].clientX) - rect.left) * escalaX;
    const y = ((evento.clientY || evento.touches[0].clientY) - rect.top) * escalaY;
    return { x, y };
};


const iniciarDesenho = (evento) => {
    pintando = true;
    const { x, y } = getPosicao(evento);
    if (ferramentaAtiva === "pincel") desenhar(x, y);
    if (ferramentaAtiva === "borracha") apagar(x, y);
};


const moverDesenho = (evento) => {
    if (!pintando) return;
    const { x, y } = getPosicao(evento);
    if (ferramentaAtiva === "pincel") desenhar(x, y);
    if (ferramentaAtiva === "borracha") apagar(x, y);
};


const terminarDesenho = () => {
    pintando = false;
};


const desenhar = (x, y) => {
    contexto.globalCompositeOperation = "source-over";
    contexto.beginPath();
    contexto.arc(x, y, tamanhoPincel / 2, 0, 2 * Math.PI);
    contexto.fill();
};


const apagar = (x, y) => {
    contexto.globalCompositeOperation = "destination-out";
    contexto.beginPath();
    contexto.arc(x, y, tamanhoPincel / 2, 0, 2 * Math.PI);
    contexto.fill();
};


const selecionarFerramenta = ({ target }) => {
    const ferramentaSelecionada = target.closest("button");
    const acao = ferramentaSelecionada.getAttribute("data-acao");
    if (acao) {
        ferramentas.forEach((ferramenta) => ferramenta.classList.remove("ativa"));
        ferramentaSelecionada.classList.add("ativa");
        ferramentaAtiva = acao;
    }
};


const selecionarTamanho = ({ target }) => {
    const ferramentaSelecionada = target.closest("button");
    const tamanho = ferramentaSelecionada.getAttribute("data-tamanho");
    botoesTamanho.forEach((ferramenta) => ferramenta.classList.remove("ativa"));
    ferramentaSelecionada.classList.add("ativa");
    tamanhoPincel = parseInt(tamanho, 10); 
};


tela.addEventListener("mousedown", iniciarDesenho);
tela.addEventListener("mousemove", moverDesenho);
tela.addEventListener("mouseup", terminarDesenho);


tela.addEventListener("touchstart", (evento) => {
    evento.preventDefault(); 
    iniciarDesenho(evento);
});
tela.addEventListener("touchmove", (evento) => {
    evento.preventDefault();
    moverDesenho(evento);
});
tela.addEventListener("touchend", terminarDesenho);


botaoLimpar.addEventListener("click", () => {
    contexto.clearRect(0, 0, tela.width, tela.height);
});

ferramentas.forEach((ferramenta) => ferramenta.addEventListener("click", selecionarFerramenta));
botoesTamanho.forEach((botao) => botao.addEventListener("click", selecionarTamanho));
