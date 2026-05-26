<div class="row">
  <!-- Info Boxes -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Pendaftar</span>
        <span class="info-box-number"><?= number_format($stats['Total']) ?></span>
      </div>
    </div>
  </div>
  
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Menunggu Verifikasi</span>
        <span class="info-box-number"><?= number_format($stats['Menunggu'] + $stats['Diperiksa']) ?></span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Diterima / Lolos</span>
        <span class="info-box-number"><?= number_format($stats['Diterima']) ?></span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Tidak Diterima</span>
        <span class="info-box-number"><?= number_format($stats['Tidak-Diterima']) ?></span>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Line Chart: Tren Pendaftaran -->
  <div class="col-md-8">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Tren Pendaftaran (30 Hari Terakhir)</h3>
      </div>
      <div class="card-body">
        <div style="position: relative; height:300px; width:100%;">
          <canvas id="trendChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Doughnut Chart: Sebaran Gender -->
  <div class="col-md-4">
    <div class="card card-info card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-venus-mars mr-1"></i> Sebaran Gender</h3>
      </div>
      <div class="card-body">
        <div style="position: relative; height:300px; width:100%;">
          <canvas id="genderChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Bar Chart: Sebaran Program Pendidikan -->
  <div class="col-md-12">
    <div class="card card-success card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-university mr-1"></i> Sebaran Pendaftar per Program Pendidikan</h3>
      </div>
      <div class="card-body">
        <div style="position: relative; height:350px; width:100%;">
          <canvas id="programChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // 1. Line Chart - Tren Pendaftaran
  const trendCtx = document.getElementById('trendChart').getContext('2d');
  const trendData = {
    labels: [
      <?php foreach($trendStats as $t) {
        echo "'" . date('d M', strtotime($t->tanggal)) . "',";
      } ?>
    ],
    datasets: [{
      label: 'Jumlah Pendaftar Baru',
      data: [
        <?php foreach($trendStats as $t) {
          echo $t->total . ",";
        } ?>
      ],
      borderColor: '#3498db',
      backgroundColor: 'rgba(52, 152, 219, 0.1)',
      borderWidth: 2,
      fill: true,
      tension: 0.3
    }]
  };
  new Chart(trendCtx, {
    type: 'line',
    data: trendData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });

  // 2. Doughnut Chart - Sebaran Gender
  const genderCtx = document.getElementById('genderChart').getContext('2d');
  const genderData = {
    labels: [
      <?php foreach($genderStats as $g) {
        echo ($g->jenis_kelamin == 'L' ? "'Laki-laki'" : "'Perempuan'") . ",";
      } ?>
    ],
    datasets: [{
      data: [
        <?php foreach($genderStats as $g) {
          echo $g->total . ",";
        } ?>
      ],
      backgroundColor: ['#3498db', '#e74c3c'],
      hoverOffset: 4
    }]
  };
  new Chart(genderCtx, {
    type: 'doughnut',
    data: genderData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });

  // 3. Bar Chart - Sebaran Program Pendidikan
  const programCtx = document.getElementById('programChart').getContext('2d');
  const programData = {
    labels: [
      <?php foreach($programStats as $p) {
        echo "'" . addslashes($p->program) . "',";
      } ?>
    ],
    datasets: [{
      label: 'Jumlah Pendaftar',
      data: [
        <?php foreach($programStats as $p) {
          echo $p->total . ",";
        } ?>
      ],
      backgroundColor: '#2ecc71',
      borderColor: '#27ae60',
      borderWidth: 1
    }]
  };
  new Chart(programCtx, {
    type: 'bar',
    data: programData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      },
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });
</script>
