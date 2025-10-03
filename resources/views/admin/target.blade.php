@extends('layouts.main')

@section('content')
<x-breadcrumbs>target</x-breadcrumbs>
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">🎯 Target Semester</h2>
                <p class="text-muted">Pantau dan kelola target pembelajaran semester ini</p>
            </div>
            <div>
                <select class="form-select form-select-sm rounded-pill">
                    <option>2025 - 2026</option>
                    <option>2024 - 2025</option>
                </select>
            </div>
        </div>

        <div class="row g-4">

            <!-- Statistik Box -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-flask fa-2x text-primary mb-2"></i>
                        <h3 class="fw-bold">33</h3>
                        <p class="mb-0 text-muted">Penelitian</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-handshake fa-2x text-success mb-2"></i>
                        <h3 class="fw-bold">20</h3>
                        <p class="mb-0 text-muted">Pengabdian</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-file-alt fa-2x text-warning mb-2"></i>
                        <h3 class="fw-bold">42</h3>
                        <p class="mb-0 text-muted">Laporan Kegiatan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-book fa-2x text-danger mb-2"></i>
                        <h3 class="fw-bold">21</h3>
                        <p class="mb-0 text-muted">Jurnal Dosen</p>
                    </div>
                </div>
            </div>

            <!-- Grafik -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Perincian Karya Ilmiah</h6>
                        <canvas id="pieChart"></canvas>
                        <p class="mt-2 text-muted">Total: <strong>53</strong></p>
                    </div>
                </div>
            </div>

            <!-- Tabel Aktivitas -->
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">📋 Aktivitas Terakhir Dosen</h5>
                        <a href="#" class="btn btn-primary btn-sm rounded-pill">Lihat Lebih Banyak</a>
                    </div>
                    <div class="card-body">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Dosen</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="https://i.pravatar.cc/30" class="rounded-circle me-2"> Cahya Sitopu</td>
                                    <td>Penerapan Metode MOORA Untuk Menentukan Kelayakan...</td>
                                    <td><span class="badge bg-primary">Penelitian</span></td>
                                    <td>25 Februari 2021</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i></a>
                                        <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-info"><i class="fas fa-search"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="https://i.pravatar.cc/30" class="rounded-circle me-2"> Ali Ruksian</td>
                                    <td>Penerapan Metode MOORA Untuk Menentukan Kelayakan...</td>
                                    <td><span class="badge bg-success">Pengabdian</span></td>
                                    <td>25 Februari 2021</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i></a>
                                        <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-info"><i class="fas fa-search"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('lineChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: '2022',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#0d6efd',
                    fill: true,
                    tension: 0.4
                }, {
                    label: '2023',
                    data: [5, 10, 7, 8, 5, 6],
                    borderColor: '#198754',
                    fill: true,
                    tension: 0.4
                }]
            }
        });

        const ctxPie = document.getElementById('pieChart');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Laporan Akhir', 'Makalah', 'Jurnal Dosen'],
                datasets: [{
                    data: [20, 10, 23],
                    backgroundColor: ['#ffc107', '#0d6efd', '#198754']
                }]
            }
        });
    </script>
@endsection
