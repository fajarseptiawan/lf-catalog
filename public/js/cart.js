/**
 * LF Catalog — Cart Module (localStorage)
 * Data structure: Array of { id, name, slug, price, image, qty, stock, category }
 */
const LFCart = {
    key: 'lf_cart',

    getAll() {
        try {
            return JSON.parse(localStorage.getItem(this.key)) || [];
        } catch { return []; }
    },

    save(items) {
        localStorage.setItem(this.key, JSON.stringify(items));
        this.updateBadge();
    },

    add(product) {
        const items = this.getAll();
        const idx = items.findIndex(i => i.id === product.id);
        if (idx > -1) {
            items[idx].qty = Math.min(items[idx].qty + product.qty, items[idx].stock);
        } else {
            items.push({ ...product });
        }
        this.save(items);
        this.showToast(product.name);
    },

    updateQty(id, qty) {
        const items = this.getAll();
        const idx = items.findIndex(i => i.id === id);
        if (idx > -1) {
            if (qty < 1) {
                items.splice(idx, 1);
            } else {
                items[idx].qty = Math.min(qty, items[idx].stock);
            }
            this.save(items);
        }
    },

    remove(id) {
        const items = this.getAll().filter(i => i.id !== id);
        this.save(items);
    },

    clear() {
        localStorage.removeItem(this.key);
        this.updateBadge();
    },

    totalItems() {
        return this.getAll().reduce((sum, i) => sum + i.qty, 0);
    },

    totalPrice() {
        return this.getAll().reduce((sum, i) => sum + (i.price * i.qty), 0);
    },

    formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    },

    updateBadge() {
        const badge = document.getElementById('cart-badge');
        if (!badge) return;
        const count = this.totalItems();
        if (count > 0) {
            badge.textContent = count > 99 ? '99+' : count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    },

    showToast(productName) {
        // Remove existing toast
        const existing = document.getElementById('cart-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.id = 'cart-toast';
        toast.className = 'fixed bottom-6 right-6 z-[100] bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 transform translate-y-4 opacity-0 transition-all duration-300';
        toast.innerHTML = `
            <svg class="w-5 h-5 text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <div>
                <p class="font-semibold text-sm">${productName}</p>
                <p class="text-xs text-gray-300">ditambahkan ke keranjang</p>
            </div>
            <a href="/cart" class="ml-2 text-xs bg-white text-gray-900 px-3 py-1.5 rounded-lg font-bold hover:bg-gray-100 transition shrink-0">Lihat</a>
        `;
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        });

        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
};

// Initialize badge on page load
document.addEventListener('DOMContentLoaded', () => LFCart.updateBadge());
