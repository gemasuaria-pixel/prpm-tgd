<div>
    <table class="table">
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $r)
                            <span class="badge bg-primary">{{ $r->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-end">
                        <button wire:click="$emit('openEditModal', {{ $user->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="editRolesModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form wire:submit.prevent="save" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Role — {{ $userName }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            @foreach($availableRoles as $role)
              <div class="form-check">
                <input wire:model="selectedRoles" class="form-check-input" value="{{ $role }}" type="checkbox" id="r_{{ $role }}">
                <label class="form-check-label" for="r_{{ $role }}">{{ ucfirst($role) }}</label>
              </div>
            @endforeach
            @error('selectedRoles') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
</div>

@push('scripts')
<script>
  window.addEventListener('show-edit-modal', e => {
    var modal = new bootstrap.Modal(document.getElementById('editRolesModal'));
    modal.show();
  });
  window.addEventListener('hide-edit-modal', e => {
    var modalEl = document.getElementById('editRolesModal');
    var modal = bootstrap.Modal.getInstance(modalEl);
    if(modal) modal.hide();
  });
</script>
@endpush
