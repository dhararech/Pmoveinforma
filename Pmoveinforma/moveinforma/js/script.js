/* ==========================================================================
   Move Informa 
   Rapazes e Rapozas - pequenas instruções 
   - Inicializa o carrossel da página inicial 
   - Controla os filtros por categoria (Glossário, Offline, Favoritos)
   ========================================================================== */

document.addEventListener("DOMContentLoaded", function () {
  // Carrossel da página inicial
  const carouselElement = document.querySelector("#carouselNoticias");
  if (carouselElement) {
    new bootstrap.Carousel(carouselElement, {
      interval: 4000,
      ride: "carousel",
      pause: "hover",
      wrap: true,
      touch: true,
    });
  }

  // Filtro por categoria: qualquer página com botões [data-filter] e
  // itens com [data-category] entra nesse comportamento.
  const filterButtons = document.querySelectorAll("[data-filter]");
  const filterItems = document.querySelectorAll("[data-category]");
  const emptyState = document.querySelector("[data-empty-state]");

  if (filterButtons.length && filterItems.length) {
    filterButtons.forEach((button) => {
      button.addEventListener("click", () => {
        filterButtons.forEach((b) => b.classList.remove("active"));
        button.classList.add("active");

        const target = button.getAttribute("data-filter");
        let visibleCount = 0;

        filterItems.forEach((item) => {
          const matches = target === "todos" || item.getAttribute("data-category") === target;
          item.style.display = matches ? "" : "none";
          if (matches) visibleCount += 1;
        });

        if (emptyState) {
          emptyState.style.display = visibleCount === 0 ? "block" : "none";
        }
      });
    });
  }

  // Busca simples (Glossário): filtra os cards pelo texto digitado
  const searchInput = document.querySelector("[data-search-input]");
  if (searchInput) {
    searchInput.addEventListener("input", () => {
      const query = searchInput.value.trim().toLowerCase();
      document.querySelectorAll("[data-search-item]").forEach((item) => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(query) ? "" : "none";
      });
    });
  }

  // Botão de fechar/voltar flutuante: volta para a página inicial
  const closeButton = document.querySelector("[data-go-home]");
  if (closeButton) {
    closeButton.addEventListener("click", () => {
      window.location.href = "../pietro/pagInicial.html";
    });
  }
});
