// Inicializar primer mapa
const map1 = L.map('map1').setView([4.633105, -74.080603], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map1);

let marker1 = L.marker([4.633105, -74.080603], { draggable: true }).addTo(map1);
marker1.on('move', function (e) {
    const { lat, lng } = e.latlng;
    document.getElementById('latitude1').value = lat.toFixed(6);
    document.getElementById('longitude1').value = lng.toFixed(6);
});

// Inicializar segundo mapa
const map2 = L.map('map2').setView([4.633105, -74.080603], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map2);

let marker2 = L.marker([4.633105, -74.080603], { draggable: true }).addTo(map2);
marker2.on('move', function (e) {
    const { lat, lng } = e.latlng;
    document.getElementById('latitude2').value = lat.toFixed(6);
    document.getElementById('longitude2').value = lng.toFixed(6);
});


function handleSubmit(event) {
    event.preventDefault();
    
    // Obtener los valores de los campos del formulario
    const formData = new FormData();
    formData.append('cedula', document.getElementById('document').value);
    formData.append('nombres', document.getElementById('names').value);
    formData.append('apellidos', document.getElementById('surnames').value);
    formData.append('direccion_residencia', document.getElementById('address1').value);
    formData.append('latitude1', document.getElementById('latitude1').value);
    formData.append('longitude1', document.getElementById('longitude1').value);
    formData.append('direccion_trabajo', document.getElementById('address2').value); 
    formData.append('latitude2', document.getElementById('latitude2').value);
    formData.append('longitude2', document.getElementById('longitude2').value);

    // Enviar los datos usando fetch
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('Datos enviados correctamente:', data);
        alert('Datos guardados exitosamente');

        location.reload();
    })
    .catch(error => {
        console.error('Error al enviar los datos:', error);
        alert('Hubo un error al guardar los datos.');
    });

    console.log('Direccion de trabajo:', document.getElementById('address2').value);
}
