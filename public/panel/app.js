const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['2022', '2021', '2020', '2019', '2018'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1,
      backgroundColor: ['grey']
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      },
    },
    indexAxis: 'y'
  }
});


const ctx2 = document.getElementById('myChart2');

new Chart(ctx2, {
  type: 'bar',
  data: {
    labels: ['2022', '2021', '2020', '2019', '2018'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1,
      backgroundColor: ['grey']
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    },
    indexAxis: 'y',
  }
});

// map js code

  // Create two tile layers from different providers
  const tileLayer1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
  });

  const tileLayer2 = L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png', {
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
  });

  // Create a Leaflet map centered on a specific location
  const map = L.map('map').setView([40.7128, -74.006], 13);

  // Add the tile layers to a layer group
  const baseLayers = {
    'Tile Layer 1': tileLayer1,
    'Tile Layer 2': tileLayer2
  };
  const layerGroup = L.layerGroup([tileLayer1, tileLayer2]).addTo(map);

  // Add a control to switch between the tile layers
  L.control.layers(baseLayers).addTo(map);

  // Create a pane for the markers
  map.createPane('markers');
  map.getPane('markers').style.zIndex = 650;

  // Add markers to the map using the markers pane
  const marker1 = L.marker([40.7128, -74.006], {
    pane: 'markers'
  }).addTo(map);
  const marker2 = L.marker([40.7292, -73.996], {
    pane: 'markers'
  }).addTo(map);

