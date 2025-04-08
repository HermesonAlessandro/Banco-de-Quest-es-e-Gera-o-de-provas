function validarFormularioCadastro() {
    // Obtém os valores dos campos do formulário
    let cpf = document.getElementById("box_cpf").value; // Captura o valor do campo CPF
    let nome = document.getElementById("box_nome_completo").value; // Captura o valor do campo Nome Completo
    let email = document.getElementById("box_email").value; // Captura o valor do campo E-mail
    let senha = document.getElementById("box_password").value; // Captura o valor do campo Senha
    let perfil = document.getElementById("box_perfil").value; // Captura o valor do campo Perfil

    // Valida se todos os campos estão preenchidos
    if (!cpf || !nome || !email || !senha || !perfil) { 
        alert("Por favor, preencha todos os campos!"); // Alerta o usuário se algum campo estiver vazio
        return false; // Impede o envio do formulário
    }

    // Validação do CPF: deve conter exatamente 11 números
    if (!/^\d{11}$/.test(cpf)) { 
        alert("CPF inválido! O CPF deve conter 11 números!"); // Alerta se o CPF não atender ao padrão esperado
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
    alert("Formulário validado com sucesso!"); // Mensagem de validação bem-sucedida
    return true; // Permite o envio do formulário
}