// assets/js/main.js
document.addEventListener('DOMContentLoaded', () => {

    // --- FITUR LIKE ---
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const photoId = this.getAttribute('data-id');
            const likeCountSpan = this.querySelector('.like-count');
            const currentLikes = parseInt(likeCountSpan.textContent);

            // Kirim permintaan ke server menggunakan Fetch API
            fetch('ajax/like_photo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `photo_id=${photoId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeCountSpan.textContent = data.new_like_count;
                    this.disabled = true; // Nonaktifkan tombol setelah di-like
                    this.style.opacity = '0.5';
                } else {
                    alert('Gagal menyukai foto.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });


    // --- FITUR FAVORIT ---
    const favoriteButtons = document.querySelectorAll('.favorite-btn');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const photoId = this.getAttribute('data-id');
            const icon = this.querySelector('i');
            const isFavorited = this.classList.contains('favorited');
            const action = isFavorited ? 'remove' : 'add';

            fetch('ajax/favorite_photo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `photo_id=${photoId}&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle class dan ikon
                    this.classList.toggle('favorited');
                    icon.classList.toggle('far');
                    icon.classList.toggle('fas');
                } else {
                    alert('Gagal memperbarui favorit.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});


// --- FITUR LIGHTBOX ---
const lightbox = document.getElementById('photo-lightbox');
const lightboxImg = document.querySelector('.lightbox-image');
const lightboxClose = document.querySelector('.lightbox-close');
const photoWrappers = document.querySelectorAll('.photo-wrapper'); // Ambil semua elemen pembungkus foto

// Fungsi untuk membuka lightbox
function openLightbox(src) {
    lightboxImg.src = src; // Set src gambar di lightbox
    lightbox.classList.add('active'); // Tampilkan lightbox dengan menambah class 'active'
    document.body.style.overflow = 'hidden'; // Mencegah scroll di halaman utama
}

// Fungsi untuk menutup lightbox
function closeLightbox() {
    lightbox.classList.remove('active'); // Sembunyikan lightbox
    document.body.style.overflow = 'auto'; // Kembalikan scroll
}

// Tambahkan event listener ke setiap foto yang bisa diklik
photoWrappers.forEach(wrapper => {
    wrapper.addEventListener('click', function() {
        const imageSrc = this.getAttribute('data-src');
        openLightbox(imageSrc);
    });
});

// Event listener untuk tombol close
lightboxClose.addEventListener('click', closeLightbox);

// Event listener untuk menutup lightbox saat mengklik area gelap
lightbox.addEventListener('click', function(event) {
    // Pastikan yang diklik adalah backgroundnya, bukan gambarnya
    if (event.target === lightbox) {
        closeLightbox();
    }
});

// Event listener untuk menutup lightbox dengan tombol Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && lightbox.classList.contains('active')) {
        closeLightbox();
    }
});