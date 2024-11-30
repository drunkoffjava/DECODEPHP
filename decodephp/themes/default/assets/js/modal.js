class Modal {
    constructor() {
        this.modals = {};
    }

    async load(name, url) {
        try {
            const response = await fetch(url);
            const html = await response.text();
            
            // Create modal container if it doesn't exist
            if (!this.modals[name]) {
                const modalDiv = document.createElement('div');
                modalDiv.id = `modal_${name}`;
                modalDiv.className = 'hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
                document.body.appendChild(modalDiv);
                this.modals[name] = modalDiv;
            }
            
            // Update modal content
            this.modals[name].innerHTML = html;
        } catch (error) {
            console.error('Error loading modal:', error);
        }
    }

    open(name, data = {}) {
        const modal = this.modals[name];
        if (!modal) return;

        // Set form data if provided
        if (data) {
            Object.keys(data).forEach(key => {
                const input = modal.querySelector(`[name="${key}"]`);
                if (input) input.value = data[key];
            });
        }

        modal.classList.remove('hidden');
    }

    close(name) {
        const modal = this.modals[name];
        if (modal) modal.classList.add('hidden');
    }
}

// Initialize global modal instance
window.modal = new Modal(); 