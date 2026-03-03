const observer1 = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                console.log(entry
                    .isIntersecting); // Cek di Console Browser (F12) apakah ini jadi 'true' saat scroll
                if (entry.isIntersecting) {
                    // Hapus class posisi awal
                    entry.target.classList.remove('opacity-0', '-translate-x-20', 'translate-x-20');
                    entry.target.classList.remove('opacity-0', '-translate-y-20', 'translate-y-20');
                    // Tambah class posisi akhir
                    entry.target.classList.add('opacity-100', 'translate-x-0');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                }
            });
        }, {
            threshold: 0.1 // Elemen harus muncul 10% di layar baru animasi jalan
        });

        // Pastikan selector ini mencakup semua elemen yang ingin Anda animasikan
        const elements = document.querySelectorAll('.reveal-left, .reveal-right');
        elements.forEach((el) => observer1.observe(el));s
