var Tower = {
    bootstrap: function() {
        TowerThemeSwitcher.init();
        TowerDropZone.init();
    },
}

document.addEventListener('DOMContentLoaded', Tower.bootstrap);
