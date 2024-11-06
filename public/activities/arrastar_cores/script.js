const colunas = document.querySelectorAll(".coluna");
const exibicaoTempo = document.querySelector('.cronometro');
const cores = ['#ff6969', '#FFA500', '#32CD32', '#1E90FF', '#9370DB'];
const telaFimJogo = document.querySelector('.tela-fim-jogo');
const exibicaoTempoFinal = document.querySelector('#tempo-final');
const exibicaoPontuacaoFinal = document.querySelector('#pontuacao-final');
const botaoNovamente = document.querySelector('#jogar-novamente');

const nomesCores = {
    '#ff6969': 'Vermelho',
    '#FFA500': 'Laranja',
    '#32CD32': 'Verde',
    '#1E90FF': 'Azul',
    '#9370DB': 'Roxo'
};

const escurecerCor = (hex, porcentagem) => {
    let r = parseInt(hex.slice(1, 3), 16);
    let g = parseInt(hex.slice(3, 5), 16);
    let b = parseInt(hex.slice(5, 7), 16);

    r = Math.floor(r * (1 - porcentagem));
    g = Math.floor(g * (1 - porcentagem));
    b = Math.floor(b * (1 - porcentagem));

    return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1)}`;
};

let tempo = 0;
let cronometro;
let jogoTerminado = false;
let elementoArrastado = null;
let arrastandoCarta = false;

const embaralharArray = (array) => array.sort(() => Math.random() - 0.5);

const iniciarCronometro = () => {
    cronometro = setInterval(() => {
        if (!jogoTerminado) {
            tempo++;
            exibicaoTempo.innerText = `Tempo: ${tempo}s`; 
        } else {
            clearInterval(cronometro); 
        }
    }, 1000);
};

const distribuirCartas = () => {
    const coresEmbaralhadas = embaralharArray([...cores]);

    colunas.forEach((coluna, indice) => {
        const corColuna = coresEmbaralhadas[indice];
        coluna.setAttribute('data-cor', corColuna);
        coluna.style.backgroundColor = corColuna;
    });

    const arrayCartas = coresEmbaralhadas.flatMap(cor => Array(5).fill(cor));
    const cartasEmbaralhadas = embaralharArray(arrayCartas); 

    resetarColunas(); 

    cartasEmbaralhadas.forEach((cor, indice) => {
        const indiceColuna = Math.floor(indice / 5);
        const carta = document.createElement('div');
        carta.classList.add('item');
        carta.style.backgroundColor = cor;

        const descricaoCor = document.createElement('span');
        const nomeCor = nomesCores[cor]; 
        descricaoCor.textContent = nomeCor; 

        const corEscura = escurecerCor(cor, 0.70); 
        descricaoCor.style.color = corEscura; 
        descricaoCor.style.fontWeight = 'bold'; 
        descricaoCor.style.textAlign = 'center'; 
        descricaoCor.style.display = 'block'; 
        descricaoCor.style.textDecoration = 'none'; 

        carta.appendChild(descricaoCor); 
        colunas[indiceColuna].appendChild(carta);
    });

    atualizarCartasArrastaveis(); 
};

const resetarColunas = () => {
    colunas.forEach(coluna => {
        while (coluna.firstChild) {
            coluna.removeChild(coluna.firstChild); 
        }
    });
};

const verificarVitoria = () => {
    let venceu = true;
    colunas.forEach(coluna => {
        const corColuna = coluna.getAttribute('data-cor').toLowerCase();
        const cartas = coluna.querySelectorAll('.item');

        if (cartas.length !== 5) {
            venceu = false;
        } else {
            cartas.forEach(carta => {
                const corCarta = window.getComputedStyle(carta).backgroundColor; 
                const corHexColuna = corColuna; 

                const rgbParaHex = (rgb) => {
                    const [r, g, b] = rgb.match(/\d+/g).map(Number);
                    return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toLowerCase()}`;
                };

                if (rgbParaHex(corCarta) !== corHexColuna) {
                    venceu = false;
                }
            });
        }
    });
    return venceu;
};

const aoVencer = () => {
    if (!jogoTerminado) {
        jogoTerminado = true;
        clearInterval(cronometro);
        exibicaoTempoFinal.textContent = `Tempo final: ${tempo}s`;
        exibicaoPontuacaoFinal.textContent = "Você completou o desafio!";
        telaFimJogo.classList.add('mostrar'); 
    }
};

function atualizarCartasArrastaveis() {
    if (!jogoTerminado) { 
        colunas.forEach((coluna) => {
            const cartas = coluna.querySelectorAll(".item");

            cartas.forEach((carta) => {
                carta.setAttribute("draggable", "false"); 
            });

            if (cartas.length > 0) {
                const ultimaCarta = cartas[cartas.length - 1];
                ultimaCarta.setAttribute("draggable", "true"); 
            }
        });
    }
}


const prevenirRolagem = (e) => {
    if (arrastandoCarta) {
        e.preventDefault();
    }
};


document.addEventListener("touchstart", (e) => {
    const item = e.target.closest('.item');
    if (item && item.getAttribute("draggable") === "true") {
        elementoArrastado = item;
        item.classList.add("arrastando");
        arrastandoCarta = true; 

      
        item.style.width = `${item.offsetWidth}px`;
        item.style.height = `${item.offsetHeight}px`;
    }
}, { passive: false });


document.addEventListener("touchmove", (e) => {
    if (elementoArrastado) {
        const touch = e.touches[0];
        elementoArrastado.style.position = 'absolute';
        elementoArrastado.style.left = `${touch.clientX - elementoArrastado.offsetWidth / 2}px`;
        elementoArrastado.style.top = `${touch.clientY - elementoArrastado.offsetHeight / 2}px`;
        elementoArrastado.style.zIndex = '1000';
    }
    
});



document.addEventListener("touchend", (e) => {
    if (elementoArrastado) {
        const colunasArray = Array.from(colunas);
        const colunaAtingida = colunasArray.find(coluna => {
            const caixaColuna = coluna.getBoundingClientRect();
            const touch = e.changedTouches[0];
            return (
                touch.clientX >= caixaColuna.left &&
                touch.clientX <= caixaColuna.right &&
                touch.clientY >= caixaColuna.top &&
                touch.clientY <= caixaColuna.bottom
            );
        });

        if (colunaAtingida) {
            const elementoApos = pegarElementoAposArraste(colunaAtingida, e.changedTouches[0].clientY);
            if (elementoApos == null) {
                colunaAtingida.appendChild(elementoArrastado);
            } else {
                colunaAtingida.insertBefore(elementoArrastado, elementoApos);
            }
            atualizarCartasArrastaveis();
        }


        elementoArrastado.classList.remove("arrastando");
        elementoArrastado.style.position = '';
        elementoArrastado.style.width = '';
        elementoArrastado.style.height = '';
        elementoArrastado.style.zIndex = '';
        
        arrastandoCarta = false; 
        elementoArrastado = null;

        setTimeout(() => {
            if (verificarVitoria()) {
                aoVencer();
            }
        }, 100);
    }
}, { passive: false });

document.addEventListener("mousedown", (e) => {
    const item = e.target.closest('.item');
    if (item && item.getAttribute("draggable") === "true") {
        elementoArrastado = item;
        elementoArrastado.classList.add("arrastando");
        arrastandoCarta = true;

        elementoArrastado.style.width = `${elementoArrastado.offsetWidth}px`;
        elementoArrastado.style.height = `${elementoArrastado.offsetHeight}px`;
        elementoArrastado.style.position = 'absolute';
        elementoArrastado.style.zIndex = '1000';
    }
}, { passive: false });

document.addEventListener("mousemove", (e) => {
    if (arrastandoCarta && elementoArrastado) {
        elementoArrastado.style.left = `${e.clientX - elementoArrastado.offsetWidth / 2}px`;
        elementoArrastado.style.top = `${e.clientY - elementoArrastado.offsetHeight / 2}px`;
    }
});

document.addEventListener("mouseup", (e) => {
    if (arrastandoCarta && elementoArrastado) {

        const colunasArray = Array.from(colunas);
        const colunaAtingida = colunasArray.find(coluna => {
            const caixaColuna = coluna.getBoundingClientRect();
            return (
                e.clientX >= caixaColuna.left &&
                e.clientX <= caixaColuna.right &&
                e.clientY >= caixaColuna.top &&
                e.clientY <= caixaColuna.bottom
            );
        });


        if (colunaAtingida) {
            const elementoApos = pegarElementoAposArraste(colunaAtingida, e.clientY);
            if (elementoApos == null) {
                colunaAtingida.appendChild(elementoArrastado);
            } else {
                colunaAtingida.insertBefore(elementoArrastado, elementoApos);
            }
            atualizarCartasArrastaveis();
        }

        elementoArrastado.classList.remove("arrastando");
        elementoArrastado.style.position = '';
        elementoArrastado.style.width = '';
        elementoArrastado.style.height = '';
        elementoArrastado.style.zIndex = '';

        arrastandoCarta = false;
        elementoArrastado = null;

        setTimeout(() => {
            if (verificarVitoria()) {
                aoVencer();
            }
        }, 100);
    }
}, { passive: false });

const pegarElementoAposArraste = (coluna, y) => {
    const elementosArrastaveis = [...coluna.querySelectorAll(".item:not(.arrastando)")];

    return elementosArrastaveis.reduce((maisProximo, filho) => {
        const caixa = filho.getBoundingClientRect();
        const offset = y - caixa.top - caixa.height / 2;
        if (offset < 0 && offset > maisProximo.offset) {
            return { offset: offset, element: filho };
        } else {
            return maisProximo;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
};


distribuirCartas();
iniciarCronometro();

botaoNovamente.addEventListener('click', () => {
    telaFimJogo.classList.remove('mostrar');
    jogoTerminado = false;
    tempo = 0;
    exibicaoTempo.innerText = `Tempo: 0s`;
    distribuirCartas();
    iniciarCronometro();
});
