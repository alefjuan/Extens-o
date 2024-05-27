document.addEventListener("DOMContentLoaded", function() {
    getUsers();
});

function getUsers() {
    fetch('read.php')
    .then(response => response.json()) //aqui retorno as respostas para json
    .then(data => { //inicio a manipulação dos mesmos
        const userList = document.getElementById('usuarios-lista');
        userList.innerHTML = '';
        data.forEach(usuario => {
            const userItem = document.createElement('div');
            userItem.innerHTML = `
                <p>ID: ${usuario.id}</p>
                <p>Nome: ${usuario.nome}</p>
                <p>E-mail: ${usuario.email}</p>
                <p>Telefone: ${usuario.telefone}</p>
                <button onclick="deleteUser(${usuario.id})">Excluir</button>
            `;
            userList.appendChild(userItem);
        });
    });
}

function createOrUpdate() {
    const nomeInput = document.getElementById('nome');
    const emailInput = document.getElementById('email');
    const telefoneInput = document.getElementById('telefone');

    // Verificar se os campos existem antes de acessar seus valores
    if (nomeInput && emailInput && telefoneInput) {
        const nome = nomeInput.value;
        const email = emailInput.value;
        const telefone = telefoneInput.value;

        const formData = new FormData();
        formData.append('nome', nome);
        formData.append('email', email);
        formData.append('telefone', telefone);

        fetch('create_update.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getUsers();
                document.getElementById('crud-form').reset();
            } else {
                alert('Ocorreu um erro ao salvar os dados.');
            }
        });
    } else {
        console.error("Um ou mais campos não foram encontrados.");
    }
}



function deleteUser(id) {
    fetch('delete.php', {
        method: 'POST',
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            getUsers();
        } else {
            alert('Ocorreu um erro ao excluir o usuário.');
        }
    });
}
