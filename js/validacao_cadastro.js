function validarFormularioCadastro() {
    let cpf = document.getElementById("box_cpf").value;
    let nome = document.getElementById("box_nome_completo").value;
    let email = document.getElementById("box_email").value;
    let senha = document.getElementById("box_password").value;
    let perfil = document.getElementById("box_perfil").value;

    if (!cpf || !nome || !email || !senha || !perfil) {
        alert("Por favor, preencha todos os campos!");
        return false;
    }

    if (!/^\d{11}$/.test(cpf)) {
        alert("CPF inválido! O CPF deve conter 11 números!");
        return false;
    }

    if (!/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/.test(email)) {
        alert("E-mail inválido! Insira um e-mail válido!");
        return false;
    }

    if (senha.length < 6) {
        alert("A senha deve ter no mínimo 6 caracteres!");
        return false; // Adicionei o "return false" aqui para impedir o envio caso a senha seja inválida
    }

    alert("Formulário validado com sucesso!");
    return true;
}