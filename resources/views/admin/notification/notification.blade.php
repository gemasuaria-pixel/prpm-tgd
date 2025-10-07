@extends('layouts.main')
@section('content')
    <!-- Main Content -->
    <main class="content-wrapper ">


        <!-- Main content -->
        <section class="content mt-5">
            <x-breadcrumbs>nontification</x-breadcrumbs>
            <div class="container-fluid py-4">
  <div class="row g-4">

    <!-- Konten Pesan -->
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
          <h5 class="fw-bold mb-3">This is the Title of the Message</h5>

          <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('logoPRPM.svg') }}" 
                 class="rounded-circle me-3 shadow-sm" alt="Prof"  width="45" height="45">
            <div>
              <span class="fw-semibold">Prof. Husein Achmad</span><br>
              <small class="text-muted">Dosen Senior</small>
            </div>
          </div>

          <h6 class="fw-bold mb-2 text-secondary">This is the type/head of the message</h6>
          <p class="text-muted mb-4">
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
            totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.
          </p>

          <!-- Form Reply -->
          <form>
            <div class="input-group">
              <input type="text" class="form-control rounded-start-pill" placeholder="Tulis balasan...">
              <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                <i class="bi bi-send"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Notifikasi -->
    <div class="col-lg-4">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
          <h6 class="fw-bold mb-3">Notifikasi</h6>
          <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action px-0 py-3">
              <div class="d-flex justify-content-between">
                <span class="fw-semibold text-primary">Permintaan Penyuntingan Profil</span>
                <small class="text-muted">26 Agustus 2025</small>
              </div>
              <div class="small text-muted">Muhammad Khairi</div>
            </a>
            <a href="#" class="list-group-item list-group-item-action px-0 py-3">
              <div class="d-flex justify-content-between">
                <span class="fw-semibold text-primary">Permintaan Penyuntingan Profil</span>
                <small class="text-muted">26 Agustus 2025</small>
              </div>
              <div class="small text-muted">Muhammad Khairi</div>
            </a>
            <a href="#" class="list-group-item list-group-item-action px-0 py-3">
              <div class="d-flex justify-content-between">
                <span class="fw-semibold text-primary">Permintaan Penyuntingan Profil</span>
                <small class="text-muted">26 Agustus 2025</small>
              </div>
              <div class="small text-muted">Muhammad Khairi</div>
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

        </section>
    </main>
@endsection
