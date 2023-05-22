var Tower = {
    bootstrap: function() {
        TowerThemeSwitcher.init();
        TowerDropZone.init();
        StringListField.init();
    },
}

document.addEventListener('DOMContentLoaded', Tower.bootstrap);
