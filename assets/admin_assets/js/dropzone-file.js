function initFileField(fieldName, formName, isMultiple, route, csrfToken) {
    Dropzone.autoDiscover = false;

    document.addEventListener("DOMContentLoaded", function () {

        let uniqueId = "container-" + fieldName;
        let fileInput = document.getElementById(uniqueId);
        let allFileIdsForHiddenInput = [];
        let allFilesForHiddenInput = [];


        if (fileInput) {
            let dropzoneOptions = {
                url: route,
                paramName: formName,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                maxFilesize: 15,
                acceptedFiles: fileInput.getAttribute('data-accepted-files'),
                addRemoveLinks: true,
                dictDefaultMessage: "Drag and drop files here or click to select",
                createImageThumbnails: true,
                init: function () {
                    let filesCounter = document.getElementById("files-counter-" + fieldName);
                    let filesCount = 0;
                    this.on("addedfile", function (file) {
                    });
                    console.log('success init');
                    console.log(allFilesForHiddenInput);

                    this.on("success", function(file, response) {
                        filesCount++;
                        filesCounter.textContent = "Файлов загружено: " + filesCount;

                        let hiddenInputsContainer = document.getElementById("hidden-inputs-container-" + fieldName);
                        let hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";

                        if (isMultiple) {
                            hiddenInput.name = fieldName + "_file_ids[]";
                            let { id,name } = response[0];
                            allFileIdsForHiddenInput.push(id);
                            allFilesForHiddenInput.push([id,name]);
                            hiddenInput.value = allFileIdsForHiddenInput;
                        } else {
                            hiddenInput.name = fieldName + "_file_id";
                            hiddenInput.value = response[0]["id"];
                            console.log(hiddenInput.value);
                        }

                        if (hiddenInputsContainer.innerHTML === "") {
                            hiddenInputsContainer.appendChild(hiddenInput);
                        } else {
                            document.getElementsByName(fieldName + "_file_ids[]")[0].value = allFileIdsForHiddenInput;
                        }

                        // console.log("success");
                    });

                    this.on("removedfile", function(file) {

                        if (isMultiple) {
                            console.log(file.name)
                            let indexOfFileRemoveFromAttach = allFilesForHiddenInput.findIndex(function (element) {
                                return element[1] === file.name;
                            });
                            let fileIdForRemoveAttach = allFilesForHiddenInput[indexOfFileRemoveFromAttach][0];
                            console.log(fileIdForRemoveAttach);
                            let index = allFileIdsForHiddenInput.indexOf(fileIdForRemoveAttach);
                            if (index !== -1) {
                                allFileIdsForHiddenInput.splice(index, 1);
                                document.getElementsByName(fieldName + "_file_ids[]")[0].value = allFileIdsForHiddenInput;
                            }
                        } else {
                            document.getElementsByName(fieldName + "_file_ids[]")[0].value = "";
                        }
                        filesCount--;
                        filesCounter.textContent = "Файлов загружено: " + filesCount;
                    });

                    this.on("reset", function() {
                        filesCount = 0;
                        filesCounter.textContent = "Файлов загружено: " + filesCount;
                    });
                },
                success: function (file, response) {
                    console.log('success');
                },
                error: function (file, response) {
                }
            };

            if (isMultiple) {
                dropzoneOptions["maxFiles"] = null;
            } else {
                dropzoneOptions["maxFiles"] = 1;
            }

            new Dropzone(fileInput, dropzoneOptions);
        }
    });
}


function initDeleteButtons(fieldName) {
    document.addEventListener("DOMContentLoaded", function () {
        let deleteButtons = document.querySelectorAll(".delete-file-" + fieldName);
        for (let i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].addEventListener("click", function (event) {
                event.preventDefault();
                let fileId = this.getAttribute("data-file-id");
                let fileIdsToDelete = document.getElementsByName(fieldName + "_file_ids_to_delete")[0];
                if (!fileIdsToDelete.value) {
                    fileIdsToDelete.value += fileId;
                } else {
                    fileIdsToDelete.value += "," + fileId;
                }
                let hideCard = document.getElementById(fieldName + '-' + fileId);
                hideCard.style.display = 'none';
            });
        }
    });
}
