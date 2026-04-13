// Script untuk carousel iPhone Aksesoris
const containerIphone = document.querySelector('#carousel-iphone [data-carousel-items-container]');
const prevBtnIphone = document.getElementById('prevBtn-iphone');
const nextBtnIphone = document.getElementById('nextBtn-iphone');

if (containerIphone && containerIphone.querySelector('a') && prevBtnIphone && nextBtnIphone) {
    const itemWidthIphone = containerIphone.querySelector('a').offsetWidth;

    prevBtnIphone.addEventListener('click', () => {
        containerIphone.scrollBy({
            left: -itemWidthIphone,
            behavior: 'smooth'
        });
    });

    nextBtnIphone.addEventListener('click', () => {
        containerIphone.scrollBy({
            left: itemWidthIphone,
            behavior: 'smooth'
        });
    });
}

// Script untuk carousel Sport Basket
const container1 = document.querySelector('#carousel-multi [data-carousel-items-container]');
const prevBtn1 = document.getElementById('prevBtn');
const nextBtn1 = document.getElementById('nextBtn');

if (container1 && container1.querySelector('a') && prevBtn1 && nextBtn1) {
    const itemWidth1 = container1.querySelector('a').offsetWidth;

    prevBtn1.addEventListener('click', () => {
        container1.scrollBy({
            left: -itemWidth1,
            behavior: 'smooth'
        });
    });

    nextBtn1.addEventListener('click', () => {
        container1.scrollBy({
            left: itemWidth1,
            behavior: 'smooth'
        });
    });
}

// Script untuk carousel Sport Futsal
const container2 = document.querySelector('#carousel-multi-2 [data-carousel-items-container]');
const prevBtn2 = document.getElementById('prevBtn-2');
const nextBtn2 = document.getElementById('nextBtn-2');

if (container2 && container2.querySelector('a') && prevBtn2 && nextBtn2) {
    const itemWidth2 = container2.querySelector('a').offsetWidth;

    prevBtn2.addEventListener('click', () => {
        container2.scrollBy({
            left: -itemWidth2,
            behavior: 'smooth'
        });
    });

    nextBtn2.addEventListener('click', () => {
        container2.scrollBy({
            left: itemWidth2,
            behavior: 'smooth'
        });
    });
}

// Script untuk carousel Fashion Pria
const containerFashion = document.querySelector('#carousel-fashion [data-carousel-items-container]');
const prevBtnFashion = document.getElementById('prevBtn-fashion');
const nextBtnFashion = document.getElementById('nextBtn-fashion');

if (containerFashion && containerFashion.querySelector('a') && prevBtnFashion && nextBtnFashion) {
    const itemWidthFashion = containerFashion.querySelector('a').offsetWidth;

    prevBtnFashion.addEventListener('click', () => {
        containerFashion.scrollBy({
            left: -itemWidthFashion,
            behavior: 'smooth'
        });
    });

    nextBtnFashion.addEventListener('click', () => {
        containerFashion.scrollBy({
            left: itemWidthFashion,
            behavior: 'smooth'
        });
    });
}

// Script untuk carousel Cosmetik G2G
const containerCosmetik = document.querySelector('#carousel-cosmetik [data-carousel-items-container]');
const prevBtnCosmetik = document.getElementById('prevBtn-cosmetik');
const nextBtnCosmetik = document.getElementById('nextBtn-cosmetik');

if (containerCosmetik && containerCosmetik.querySelector('a') && prevBtnCosmetik && nextBtnCosmetik) {
    const itemWidthCosmetik = containerCosmetik.querySelector('a').offsetWidth;

    prevBtnCosmetik.addEventListener('click', () => {
        containerCosmetik.scrollBy({
            left: -itemWidthCosmetik,
            behavior: 'smooth'
        });
    });

    nextBtnCosmetik.addEventListener('click', () => {
        containerCosmetik.scrollBy({
            left: itemWidthCosmetik,
            behavior: 'smooth'
        });
    });
}

// Animasi scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, {
    threshold: 0.1 // Trigger ketika 10% elemen terlihat
});

document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
});


const observer1 = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
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
elements.forEach((el) => observer1.observe(el));

document.addEventListener('DOMContentLoaded', function() {

    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('youtubeFrame');
    const closeBtn = document.getElementById('closeModal');

    document.querySelectorAll('.video-card').forEach(card => {
        card.addEventListener('click', function() {
            const videoId = this.dataset.videoId;
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    closeBtn.addEventListener('click', function() {
        iframe.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            iframe.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });

});
