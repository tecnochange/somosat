<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <style>
      .container {
        width: 80%;
        margin: 0 auto;
        text-align: center;
      }
    </style>
    <div class="container">
      <h1>Bienvenido a mi sitio web</h1>
      <p>Este es el contenido dentro del contenedor</p>
      <canvas id="myPieChart"></canvas>
    </div>
    <script>
      var ctx = document.getElementById('myPieChart').getContext('2d');
      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['Rojo', 'Azul', 'Verde'],
          datasets: [{
            data: [30, 40, 30],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {}
      });
    </script>
 
