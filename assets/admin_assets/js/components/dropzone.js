let TowerDropZone = {
    init: function() {
        document.querySelectorAll('.js-tower-dropzone').forEach(function(block) {
            TowerDropZone.setupField(block)
        });
    },

    setupField: function(block) {
        let dzContainer = block.querySelector('.js-dropzone-container');
        if(!dzContainer) {
            console.warn('[TowerAdmin] Dropzone area without `.js-dropzone-container`!', block);
            return;
        }

        let dzPreviews = dzContainer.querySelector('.dropzone-previews');
        let dzInfoLine = block.querySelector('.js-info-line');

        let fieldName = block.getAttribute('data-field-name')
        let storeUrl = block.getAttribute('data-store-url')
        let csrf = block.getAttribute('data-csrf')
        let maxFileSize = parseInt(block.getAttribute('data-max-file-size'))
        let maxFileCount = parseInt(block.getAttribute('data-max-file-count'))
        let allowedFiles = block.getAttribute('data-allowed-files')

        let template = document.querySelector('#' + block.getAttribute('data-template-id'));

        let config = {
            paramName: 'file',
            url: storeUrl,
            headers: { 'X-CSRF-TOKEN': csrf },
            addRemoveLinks: false,
            dictDefaultMessage: "Drag and drop files here or click to select",
            createImageThumbnails: true,
            previewsContainer: dzPreviews,
            previewTemplate: template.innerHTML,
            thumbnailWidth: 256,
            thumbnailHeight: 256,
        };

        if(maxFileSize > 0) {
            config.maxFilesize = maxFileSize / 1024;
        }

        if(maxFileCount > 0) {
            config.maxFiles = maxFileCount;
        }

        if(allowedFiles !== '') {
            config.acceptedFiles = allowedFiles;
        }

        let dz = new Dropzone('div#' + dzContainer.id, config);
        dz.updateInfoLine = function() {
            let fileCount = dz.files.filter(function(i) { return i.accepted; }).length;
            let text = `Files attached: ${fileCount}`

            if(config.maxFiles) {
                text += `/${config.maxFiles}`;
            }

            if(config.maxFilesize) {
                text += ` | Max file size: ${this.filesize(config.maxFilesize * 1024 * 1024)}`;
            }

            if(config.acceptedFiles) {
                let niceList = config.acceptedFiles.split(',').join(', ');
                text += ` | Allowed file types: ${niceList}`;
            }

            dzInfoLine.innerHTML = text;
        };

        dz.updateInfoLine();

        dz.on('addedfile', function(file) {
            dzPreviews.classList.remove('d-none');
        });

        dz.on('removedfile', function(file) {
            dz.updateInfoLine();
        });

        dz.on('reset', function(file) {
            dzPreviews.classList.add('d-none');
        });

        dz.on('success', function(file) {
            file.previewElement.querySelector('.js-file-controls').classList.remove('d-none');
        });

        dz.on('error', function(file, data) {
            let message = data;
            if(typeof message === 'object' && message.hasOwnProperty('message')) {
                message = message.message;
            }

            file.previewElement.querySelector('.card').classList.add('border-danger', 'text-danger');
            file.previewElement.querySelector('.js-file-error').classList.remove('d-none');
            for (let node of file.previewElement.querySelectorAll("[data-dz-errormessage]")) {
                node.textContent = message;
            }
        });

        dz.on('complete', function(file) {
            file.previewElement.querySelector('.js-file-upload-progress').classList.add('d-none');

            dz.updateInfoLine();
        });
    }
};
