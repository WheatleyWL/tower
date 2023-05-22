let StringListField = {
    init: function() {
        document.querySelectorAll('.js-string-list-field').forEach(function(block) {
            StringListField.setupField(block)
        });
    },

    setupField: function(block) {
        let template = document.querySelector('#string_list_entry_template');

        let inputName = block.getAttribute('data-name');
        let inputContainer = block.querySelector('.js-input-container');

        let self = this;
        block.querySelector('.js-add-button').addEventListener('click', function(event) {
            event.preventDefault();

            let temp = document.createElement('div');
            temp.innerHTML = template.innerHTML.trim();

            let newLine = temp.firstChild.cloneNode(true);
            inputContainer.appendChild(newLine);
            temp.remove();

            newLine.querySelector('input').setAttribute('name', inputName + '[]');

            self.bindLineEventHandlers(newLine);
        });

        block.querySelectorAll('.js-input-line').forEach(function(line) {
            self.bindLineEventHandlers(line);
        });
    },

    bindLineEventHandlers: function(line) {
        line.querySelector('button').addEventListener('click', function(event) {
            event.preventDefault();

            this.parentNode.remove();
        });
    },
};
