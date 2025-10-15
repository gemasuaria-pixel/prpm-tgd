<!-- Profile Photo Card -->
<h5 class="fw-bold mb-1">Profile Photo</h5>
<p class="text-muted mb-4 small">Tambahkan atau perbarui foto profil Anda</p>

                                <form method="POST" action="{{ route('profile.photo.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo"
                                            class="rounded-circle shadow-sm mb-3"
                                            style="width: 100px; height: 100px; object-fit: cover;">

                                        <input type="file" name="photo" accept="image/*" class="form-control mb-3 w-50"
                                            required>

                                        <button type="submit" class="btn btn-primary px-4">
                                            Update Photo
                                        </button>
                                    </div>
                                </form>
                                