<div class="col-auto" style="pointer-events: auto; cursor: auto;">
    <div class="card" style="width: 13rem;">
        <img class="card-img-top" alt="Test" data-dz-thumbnail>
        <div class="card-body px-2 py-1">
            <small class="card-title"><b data-dz-name>00001.jpg</b></small>
        </div>
        <div class="card-footer px-2 py-2 js-file-upload-progress">
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" data-dz-uploadprogress></div>
            </div>
        </div>
        <div class="card-footer row align-items-center m-0 px-2 py-2 d-none js-file-error">
            <div class="col d-inline-block px-0">
                <small data-dz-errormessage>Error message</small>
            </div>
            <div class="col-auto ps-1 pe-0">
                <button type="button" class="btn btn-sm btn-danger" data-dz-remove>
                    <i class="bi bi-x-square-fill"></i>
                </button>
            </div>
        </div>
        <div class="card-footer row align-items-center m-0 px-2 py-2 position-relative d-none js-file-controls">
            <div class="col d-inline-block px-0">
                <small class="text-muted" data-dz-size>0.00 MB</small>
            </div>
            <div class="col-auto px-1">
                <button type="button"
                        class="btn btn-sm btn-info js-seobox-btn"
                        aria-expanded="false">
                    <span class="spinner-border spinner-border-sm d-none js-spinner" role="status" aria-hidden="true"></span>
                    <i class="bi bi-pencil js-icon"></i>
                </button>
            </div>
            <div class="col-auto px-0">
                <button type="button" class="btn btn-sm btn-danger" data-dz-remove>
                    <i class="bi bi-x-square-fill"></i>
                </button>
            </div>
            <div class="collapse position-absolute p-1 bg-body-secondary js-seobox"
                 style="left: 0; right: 0; bottom: 100%;">
                <input class="form-control" type="text" name="title" placeholder="Title">
                <input class="form-control mt-1" type="text" name="alt" placeholder="Alt">
            </div>
        </div>
    </div>
</div>
