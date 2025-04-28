<div class="modal fade" id="modal-level-detail" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @empty($level)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                        Data level yang Anda cari tidak ditemukan.
                    </div>
                @else
                    <form>
                        <div class="form-group">
                            <label>ID Level</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $level->level_id }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Level Name</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $level->level_name }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Level Code</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $level->level_code }}"
                                readonly>
                        </div>
                    </form>
                @endempty
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modal-level-detail').modal('show');

    $('#modal-level-detail').on('hidden.bs.modal', function() {
        $(this).remove();
    });
</script>
