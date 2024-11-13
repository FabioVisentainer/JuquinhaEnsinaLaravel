// Ícones
const sunIcon = document.querySelector(".sun");
const moonIcon = document.querySelector(".moon");
const hamburgerIcon = document.querySelector(".hamburger");
const xIcon = document.querySelector(".x");
const list = document.querySelector('.navText');
const total = document.querySelector('.total');

// Variáveis dos temas
const userTheme = localStorage.getItem("theme");
const systemTheme = window.matchMedia("(prefers-color-scheme: dark)").matches;

// Alternar ícones
const iconToggle = () => {
    moonIcon.classList.toggle("hidden");
    sunIcon.classList.toggle("hidden");
};

// Verificação do tema inicial
const themeCheck = () => {
    if (userTheme === "dark" || (!userTheme && systemTheme)) {
        document.documentElement.classList.add("dark");
        moonIcon.classList.add("hidden");
        sunIcon.classList.remove("hidden");
        return;
    }
    sunIcon.classList.add("hidden");
    moonIcon.classList.remove("hidden");
};

// Troca de tema manualmente
const themeSwitch = () => {
    if (document.documentElement.classList.contains("dark")) {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
        iconToggle();
        return;
    }
    document.documentElement.classList.add("dark");
    localStorage.setItem("theme", "dark");
    iconToggle();
};

// Chamar a troca de tema ao clicar nos botões
sunIcon.addEventListener("click", themeSwitch);
moonIcon.addEventListener("click", themeSwitch);

// Toggle do ícone do hambúrguer
const hamburguerToggle = () => {
    hamburgerIcon.classList.toggle("hidden");
    xIcon.classList.toggle("hidden");
    list.classList.toggle("opacity-100");
};

// Evento de clique para abrir o menu e mudar o ícone
hamburgerIcon.addEventListener("click", () => {
    hamburguerToggle();
    onToggleMenu(hamburgerIcon);
});

// Evento de clique para fechar o menu e mudar o ícone
xIcon.addEventListener("click", () => {
    hamburguerToggle();
    onToggleMenu(hamburgerIcon);
});

// Função para alternar o menu usando data-name
function onToggleMenu(element) {
    // Inicializando `data-name` se não estiver presente
    if (!element.dataset.name) {
        element.dataset.name = "menu";
    }

    // Alterna entre "menu" e "close"
    element.dataset.name = element.dataset.name === "menu" ? "close" : "menu";

    if (element.dataset.name === "menu") {
        // Fechar o menu: removendo classes de visibilidade e interatividade
        list.classList.remove("top-[90px]", "opacity-100", "pointer-events-auto");
        list.classList.add("top-[-120px]", "opacity-0", "pointer-events-none");

        // Ajustando a posição do total
        total.classList.remove('top-96');
        total.classList.add('top-1');
    } else {
        // Abrir o menu: adicionando classes de visibilidade e interatividade
        list.classList.remove("top-[-120px]", "opacity-0", "pointer-events-none");
        list.classList.add("top-[90px]", "opacity-100", "pointer-events-auto");

        // Ajustando a posição do total
        total.classList.remove('top-1');
        total.classList.add('top-96');
    }
}
// Invocar o check de tema no carregamento inicial
themeCheck();
