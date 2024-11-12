<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container mx-auto mt-8 max-w-7xl px-6">
  <div class="grid grid-cols-12 gap-10">
    <div class="lg:col-span-8 col-span-12">
      <div class="bg-white rounded-[30px] relative w-full relative">
        <div class="flex items-center justify-between">
          <div class="py-6 px-8">
            <div class="text-xl mb-1 opacity-50">Selamat datang di</div>
            <div class="text-2xl  font-semibold mb-4">Sistem Prediksi Kinerja Akademik Mahasiswa BINUS</div>
            <div class="text-sm text-gray-400 w-3/5 leading-loose mb-6">Sistem ini digunakan untuk mengidentifikasi pola dan hubungan antara lokasi kampus dan kinerja akademik mahasiswa di Universitas Bina Nusantara (BINUS). Dengan hasil yang diperoleh, diharapkan pihak manajemen BINUS dapat merumuskan strategi yang lebih efektif dalam mendukung prestasi akademik mahasiswa di seluruh lokasi kampus, serta meningkatkan kualitas pendidikan secara keseluruhan.
            </div>
            <a href="<?= base_url('student'); ?>">
              <div class="bg-green-300 py-2 px-5 text-white rounded-[20px] text-sm font-bold mb-2 inline-block mr-2">Masukkan Data Mahasiswa</div>
            </a>
            <a href="<?= base_url('analysis'); ?>">
              <div class="bg-blue-300 py-2 px-5 text-white rounded-[20px] text-sm font-bold mb-2 inline-block">Mulai Analisa</div>
            </a>
          </div>
        </div>
        <div class="absolute bottom-6 right-6">
          <img
            src="<?php echo base_url('assets/images/computer.png'); ?>"
            class="flex-none"
            width="260"
          />
        </div>
      </div>
    </div>
    <div class="lg:col-span-4 col-span-12">
      <div class="grid grid-cols-12">
        <div class="col-span-12 mb-8">
          <div class="rounded-[30px] bg-red-100 relative w-full relative ">
            <div class="py-5 px-8">
              <div class="flex items-center gap-3">
                <span class="w-14 h-10 rounded-full flex items-center justify-center bg-red-400 text-white">
                  <i class="material-icons text-white">group</i>
                </span>
                <span class="text-base font-bold text-gray-600">Total Mahasiswa</span>
              </div>
              <div class="flex mt-16">
                <div class="text-3xl font-bold opacity-60"><?= $total_students ?></div>
              </div>
            </div>
            <div class="absolute bottom-0 right-6">
              <img
                src="<?php echo base_url('assets/images/mahasiswa.png'); ?>"
                class="flex-none"
                width="100"
              />
            </div>
          </div>
        </div>
        <div class="col-span-12">
          <div class="rounded-[30px] bg-blue-100 relative w-full relative ">
            <div class="py-5 px-8">
              <div class="flex items-center gap-3">
                <span class="w-14 h-10 rounded-full flex items-center justify-center bg-blue-400 text-white">
                  <i class="material-icons text-white">location_city</i>
                </span>
                <span class="text-base font-bold text-gray-600">Total Kampus</span>
              </div>
              <div class="flex mt-16">
                <div class="text-3xl font-bold opacity-60"><?= $total_campus ?></div>
              </div>
            </div>
            <div class="absolute bottom-0 right-6">
              <img
                src="<?php echo base_url('assets/images/kampus.png'); ?>"
                class="flex-none"
                width="140"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="flex mt-8 gap-8">
    <div class="flex-1 text-gray-600">
      <div class="bg-white rounded-[30px] relative w-full relative p-6 text-center">
        <div class="mb-4 font-bold">Skor Akses Transportasi Mahasiswa per Kampus</div>
        <canvas id="transportationChart" width="400" height="200"></canvas>
      </div>
    </div>
    <div class="flex-1">
      <div class="bg-white rounded-[30px] relative w-full relative p-6 text-center">
        <div class="mb-4 font-bold">Rata-rata IPK Mahasiswa per Kampus</div>
        <canvas id="gpaChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
</div>


<script>
    // Data dari PHP ke JavaScript
    const campusNames = <?= json_encode(array_column($average_gpa_per_campus, 'campus_name')) ?>;
    const averageGpa = <?= json_encode(array_column($average_gpa_per_campus, 'average_gpa')) ?>;

    // Generate warna acak untuk bar chart
    function getRandomColor() {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        return `rgba(${r}, ${g}, ${b}, 0.7)`;
    }

    const barColors = campusNames.map(() => getRandomColor());

    // Inisialisasi Chart.js dengan Horizontal Bar Chart
    const gpaCtx = document.getElementById('gpaChart').getContext('2d');
    const gpaChart = new Chart(gpaCtx, {
        type: 'bar',
        data: {
            labels: campusNames,
            datasets: [{
                label: 'Rata-rata IPK',
                data: averageGpa,
                backgroundColor: barColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y', // Membuat batang horizontal
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                          const score = Number(context.raw);
                          return `Rata-rata IPK: ${score.toFixed(2)}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Rata-rata IPK'
                    },
                    grid: {
                        display: false // Menghilangkan garis grid di sumbu x
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nama Kampus'
                    },
                    grid: {
                        display: false // Menghilangkan garis grid di sumbu y
                    }
                }
            }
        }
    });
</script>

<script>
    // Data dari PHP ke JavaScript
    const campusNames2 = <?= json_encode(array_column($average_transportation_score_per_campus, 'campus_name')) ?>;
    const avgTransportationScores = <?= json_encode(array_column($average_transportation_score_per_campus, 'average_transportation_score')) ?>;

    // Generate warna acak untuk bar chart
    function getRandomColor() {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        return `rgba(${r}, ${g}, ${b}, 0.7)`;
    }

    const barColors2 = campusNames2.map(() => getRandomColor());

    // Inisialisasi Chart.js untuk Horizontal Bar Chart
    const transportationCtx = document.getElementById('transportationChart').getContext('2d');
    const transportationChart = new Chart(transportationCtx, {
        type: 'bar',
        data: {
            labels: campusNames2,
            datasets: [{
                label: 'Rata-rata Skor Akses Transportasi',
                data: avgTransportationScores,
                backgroundColor: barColors2,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y', // Membuat batang horizontal
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                          const score = Number(context.raw);
                          return `Skor Akses Transportasi: ${score.toFixed(2)}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Skor Akses Transportasi'
                    },
                    grid: {
                        display: false // Menghilangkan garis grid di sumbu x
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nama Kampus'
                    },
                    grid: {
                        display: false // Menghilangkan garis grid di sumbu y
                    }
                }
            }
        }
    });
</script>