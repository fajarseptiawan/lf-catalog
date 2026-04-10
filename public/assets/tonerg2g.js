const observer1 = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', '-translate-x-20', 'translate-x-20');
                    entry.target.classList.remove('opacity-0', '-translate-y-20', 'translate-y-20');
                    entry.target.classList.add('opacity-100', 'translate-x-0');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                }
            });
        }, { threshold: 0.1 });
        const elements = document.querySelectorAll('.reveal-left, .reveal-right');
        elements.forEach((el) => observer1.observe(el));
