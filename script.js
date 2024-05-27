document.addEventListener("DOMContentLoaded", function() {
    getCarros();
});

function getCarros() {
    fetch('read.php')
    .then(response => response.json())
    .then(data => {
        const carList = document.getElementById('carros-lista');
        carList.innerHTML = '';
        data.forEach(carro => {
            const carItem = document.createElement('div');
            carItem.innerHTML = `
                <p>ID: ${carro.id}</p>
                <p>Marca: ${carro.marca}</p>
                <p>Modelo: ${carro.modelo}</p>
                <p>Ano: ${carro.ano}</p>
                <p>Preço: R$${carro.preco}</p>
                <button onclick="deleteCar(${carro.id})">Excluir</button>
                <button onclick="editCar(${carro.id})">Editar</button>
            `;
            carList.appendChild(carItem);
        });
    });
}

function createOrUpdate() {
    const marcaInput = document.getElementById('marca');
    const modeloInput = document.getElementById('modelo');
    const anoInput = document.getElementById('ano');
    const precoInput = document.getElementById('preco');
    const carIdInput = document.getElementById('car-id'); // Campo oculto para ID do carro

    if (marcaInput && modeloInput && anoInput && precoInput) {
        const marca = marcaInput.value;
        const modelo = modeloInput.value;
        const ano = anoInput.value;
        const preco = precoInput.value;
        const carId = carIdInput.value; // Obter o valor do ID do carro

        const formData = new FormData();
        if (carId) {
            formData.append('id', carId);
        }
        formData.append('marca', marca);
        formData.append('modelo', modelo);
        formData.append('ano', ano);
        formData.append('preco', preco);

        fetch(carId ? 'update.php' : 'create.php', { // Alterar URL com base no ID do carro
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getCarros();
                document.getElementById('crud-form').reset();
                carIdInput.value = ''; // Limpar o campo de ID após atualização
            } else {
                alert('Ocorreu um erro ao salvar os dados.');
            }
        });
    } else {
        console.error("Um ou mais campos não foram encontrados.");
    }
}

function deleteCar(id) {
    fetch('delete.php', {
        method: 'POST',
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            getCarros();
        } else {
            alert('Ocorreu um erro ao excluir o carro.');
        }
    });
}

function editCar(id) {
    fetch('get_car.php?id=' + id)
    .then(response => response.json())
    .then(car => {
        const marcaInput = document.getElementById('marca');
        const modeloInput = document.getElementById('modelo');
        const anoInput = document.getElementById('ano');
        const precoInput = document.getElementById('preco');
        const carIdInput = document.getElementById('car-id'); // Campo oculto para ID do carro

        marcaInput.value = car.marca;
        modeloInput.value = car.modelo;
        anoInput.value = car.ano;
        precoInput.value = car.preco;
        carIdInput.value = car.id; // Definir o ID do carro no campo oculto
    });
}
