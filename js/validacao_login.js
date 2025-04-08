function validarFormularioLogin() {
    // Obtém os valores dos campos do formulário de login
    let email = document.getElementById("box_email").value; // Captura o valor do campo E-mail
    let senha = document.getElementById("box_senha").value; // Captura o valor do campo Senha

    // Valida se ambos os campos estão preenchidos
    if (!email || !senha) {
        alert("Por favor, preencha todos os campos!"); // Alerta o usuário se algum campo estiver vazio
        return false; // Impede o envio do formulário
    }

    // Validação do e-mail: deve seguir o formato padrão de e-mail
    if (!/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(email)) {
        alert("E-mail inválido! Insira um e-mail válido!"); // Alerta se o e-mail for inválido
        return false; // Impede o envio do formulário
    }

    // Validação da senha: deve ter no mínimo 6 caracteres
    if (senha.length < 8) {
        alert("A senha deve ter no mínimo 8 caracteres!"); // Alerta se a senha for muito curta
        return false; // Impede o envio do formulário
    }

    // Caso todas as validações sejam bem-sucedidas
    alert("Login validado com sucesso!"); // Mensagem de validação bem-sucedida
    return true; // Permite o envio do formulário
}