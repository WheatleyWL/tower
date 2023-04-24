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

        let inputContainer = block.querySelector('.js-input-container');
        let dzPreviews = dzContainer.querySelector('.dropzone-previews');

        let dzInfoCount = block.querySelector('.js-info-line .js-file-count .js-display');
        let dzInfoSize = block.querySelector('.js-info-line .js-file-size .js-display');
        let dzInfoTypes = block.querySelector('.js-info-line .js-file-types .js-display');

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

        dz.insertInputField = function(value, tag) {
            let input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', fieldName + '[]');
            input.setAttribute('data-tag', tag);
            input.setAttribute('value', value);
            inputContainer.append(input);
        };

        dz.updateInfoLine = function() {
            let fileCount = dz.files.filter(function(i) { return i.accepted; }).length;

            let countText = `${fileCount}`;
            if(config.maxFiles) {
                countText += `/${config.maxFiles}`;
            }

            dzInfoCount.innerHTML = countText;

            if(config.maxFilesize) {
                dzInfoSize.parentNode.classList.remove('d-none');
                dzInfoSize.innerHTML = this.filesize(config.maxFilesize * 1024 * 1024);
            }

            if(config.acceptedFiles) {
                let niceList = config.acceptedFiles.split(',').join(', ');

                dzInfoTypes.parentNode.classList.remove('d-none');
                dzInfoTypes.innerHTML = niceList;
            }
        };

        dz.initPreFilledFiles = function() {
            let preFills = inputContainer.querySelectorAll('.js-pre-fill');
            preFills.forEach(function(element) {
                let descr = {
                    id: element.getAttribute('data-id'),
                    name: element.getAttribute('data-name'),
                    size: element.getAttribute('data-size'),
                    url: element.getAttribute('data-url'),
                };

                let file = {
                    name: descr.name,
                    size: parseInt(descr.size),
                    accepted: true,
                    upload: {
                        uuid: descr.id,
                    },
                };
                dz.displayExistingFile(file, descr.url);
                dz.files.push(file);

                dz.insertInputField(descr.id, file.upload.uuid);

                element.remove();
            });

            if(preFills.length > 0) {
                dzPreviews.classList.remove('d-none');
            }
        }

        dz.on('addedfile', function(file) {
            dzPreviews.classList.remove('d-none');

            let input = inputContainer.querySelector(`input[data-tag="empty"]`);
            if(input) {
                input.remove();
            }
        });

        dz.on('removedfile', function(file) {
            dz.updateInfoLine();

            let input = inputContainer.querySelector(`input[data-tag="${file.upload.uuid}"]`);
            if(input) {
                input.remove();
            }
        });

        dz.on('reset', function(file) {
            dzPreviews.classList.add('d-none');

            dz.insertInputField('', 'empty');
        });

        dz.on('success', function(file) {
            let responseObj = JSON.parse(file.xhr.response);
            if(!responseObj) {
                console.warn('[TowerAdmin] Invalid file upload response: unable to parse JSON.');
                return;
            }

            dz.insertInputField(responseObj.id, file.upload.uuid);
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
            if(file.accepted && file.status !== 'error') {
                file.previewElement.querySelector('.js-file-controls').classList.remove('d-none');
            }

            dz.updateInfoLine();
        });

        dz.initPreFilledFiles();
        dz.updateInfoLine();
    }
};
