let itemAtual = 0; // Variável que mantém o índice do slide atual do carrossel.

function mostrarItem(indice) {
  const itens = document.querySelectorAll('.item_carrossel'); // Seleciona todos os elementos com a classe "item_carrossel" (cada slide do carrossel).

  // Garante que o índice sempre rotacione (volte ao início após o último slide ou vá para o final quando no começo).
  if (indice >= itens.length) {
    itemAtual = 0; // Se o índice for maior que o número de itens, volta para o primeiro slide.
  } else if (indice < 0) {
    itemAtual = itens.length - 1; // Se o índice for negativo, vai para o último slide.
  } else {
    itemAtual = indice; // Caso contrário, atualiza o índice com o valor fornecido.
  }

  // Calcula a posição de deslocamento para exibir o slide atual.
  const deslocamento = -itemAtual * 100; // Multiplica o índice por 100% para mover o slide correspondente.
  document.querySelector('.carrossel_interativo').style.transform = `translateX(${deslocamento}%)`; 
  // Aplica o deslocamento na propriedade CSS "transform" do container do carrossel, deslocando-o horizontalmente.
}

function proximoItem() {
  mostrarItem(itemAtual + 1); // Avança para o próximo slide chamando a função "mostrarItem" com o índice atualizado.
}

function itemAnterior() {
  mostrarItem(itemAtual - 1); // Retorna ao slide anterior chamando a função "mostrarItem" com o índice atualizado.
}

document.addEventListener('DOMContentLoaded', () => {
  mostrarItem(itemAtual); // Exibe o slide inicial quando a página é carregada.

  // Auto-play: chama a função "proximoItem" automaticamente a cada 5 segundos (5000 ms).
  setInterval(proximoItem, 5000); 
});