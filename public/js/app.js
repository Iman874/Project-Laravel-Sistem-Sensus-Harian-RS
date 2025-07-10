// app.js
// @ts-ignore
// @ts-nocheck

/**
 * @function resetZoom
 * @summary Fungsi untuk mengatur ulang zoom pada halaman
 * @description Fungsi ini mengatur ulang zoom pada halaman dengan menggunakan transform CSS.
 * Fungsi ini mengatur ulang zoom pada halaman dengan menggunakan transform CSS.
 * @return {void}
 */
function resetZoom() {
    let aspectRatio = 20 / 9;
    let width = window.innerWidth;
    let height = window.innerHeight;
    
    if (width / height > aspectRatio) {
        width = height * aspectRatio;
    } else {
        height = width / aspectRatio;
    }
    
    let scaleX = window.innerWidth / width;
    let scaleY = window.innerHeight / height;
    let scale = Math.min(scaleX, scaleY);
    
    document.body.style.transform = `scale(${scale})`;
    document.body.style.transformOrigin = "top left";
    document.body.style.width = `${width}px`;
    document.body.style.height = `${height}px`;

    // Atur layar agar selalu di tengah secara horizontal dan vertikal
    document.body.style.marginLeft = `${(window.innerWidth - width) / 2}px`;
}

/**
 * @function setZoom
 * @summary Fungsi untuk mengatur zoom pada halaman
 * @description Fungsi ini menonaktifkan zoom dengan menonaktifkan tombo mouse scroll,
 * zoom keyboard, dan zoom gesture pada halaman.
 * @return {void}
 */
function disableZoom() {
    // Pastikan layar berada pada zoom 100%
    resetZoom();

    // Nonaktifkan zoom pada mouse scroll
    document.addEventListener('wheel', function(event) {
        if (event.ctrlKey) {
            event.preventDefault();
        }
    }, { passive: false });

    // Nonaktifkan zoom pada keyboard
    document.addEventListener('keydown', function(event) {
        if (
            event.ctrlKey && 
            (event.key === '+' || event.key === '-' || event.key === '=' || event.key === '0')
        ) {
            event.preventDefault();
        }
    });

    // Nonaktifkan zoom pada gesture
    document.addEventListener('gesturestart', function(event) {
        event.preventDefault();
    });
}

/** 
* @function setContentHeight
* @summary Fungsi untuk menambahkan tinggi pada navbar header
* @description Fungsi ini menambahkan tinggi pada navbar header, menu, dan footer.
* Fungsi ini digunakan untuk mengatur tinggi navbar header, menu, dan footer agar sesuai dengan tinggi konten.
* @return {void}
*/
function setContentHeight() {
    if (document.querySelector('.navbar-header') 
        && document.querySelector('.navbar-menu') 
        && document.querySelector('.navbar-footer')) {
        const headerHeight = document.querySelector('.navbar-header').offsetHeight;
        const menuHeight = document.querySelector('.navbar-menu').offsetHeight;
        const footerHeight = document.querySelector('.navbar-footer').offsetHeight;
        const totalHeight = headerHeight + menuHeight + footerHeight;
        document.documentElement.style.setProperty('--tinggi-navbar', `${totalHeight}px`);    
    } else {
        console.log('Element navbar-header, navbar-menu, atau navbar-footer tidak ditemukan.');
    }
}

/**
* @function setHeaderKontenHeight
* @summary Fungsi untuk menambahkan tinggi pada header konten
* @return {void}
*/
function setHeaderKontenHeight() {
    if (document.querySelector('.konten-header') 
        && document.querySelector('.profile-konten')) {
        const headerHeight = document.querySelector('.konten-header').offsetHeight;
        const profileHeight = document.querySelector('.profile-konten').offsetHeight;
        const totalHeight = headerHeight + profileHeight;
        document.documentElement.style.setProperty('--tinggi-konten-header', `${totalHeight}px`);
    } else {
        console.log('Element konten-header atau profile-konten tidak ditemukan.');
    }
} 

/**
 * @function formatDateUTCtoWIB
 * @param {string} datetime - Waktu dalam format UTC (YYYY-MM-DDTHH:MM).
 * @throws {Error} Jika waktu tidak valid console.log('Waktu tidak valid');
 * @description Fungsi untuk mengkonversi waktu dari UTC ke WIB, 
 * kemudian format ke datetime-local (YYYY-MM-DDTHH:MM).
 * @returns {string} Waktu dalam format UTC (YYYY-MM-DDTHH:MM).
 */
function formatDateUTCtoWIB(datetime) { 
    // Cek apakah datetime valid, jika tidak, kembalikan string kosong
    if (!datetime) return "";

    let date = new Date(datetime); // Buat objek Date dari waktu lokal

    // Cek apakah waktu valid
    if (isNaN(date.getTime())) {
        console.log("Waktu tidak valid");
    }

    // Konversi waktu dari WIB ke UTC (UTC = WIB - 7 jam)
    date.setHours(date.getHours() - 7);

    // Format ke datetime-local (YYYY-MM-DDTHH:MM)
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');
    let hours = String(date.getHours()).padStart(2, '0');
    let minutes = String(date.getMinutes()).padStart(2, '0');

    let formattedUTC = `${year}-${month}-${day}T${hours}:${minutes}`;

    return formattedUTC; // Format (YYYY-MM-DDTHH:MM)
}

/**
 * @function loadingStatus
 * @summary Fungsi untuk menampilkan loading status menggunakan SweetAlert2
 * @throws {Error} Jika SweetAlert2 tidak ditemukan 
 * console.log('SweetAlert2 tidak ditemukan. Pastikan Anda telah memuat library SweetAlert2.');
 * @description Menampilkan loading status dengan judul "Memproses..." dan teks "Mohon tunggu sebentar".
 * @return {void}
 */
function loadingStatus() {
    if (!Swal) {
        console.log('SweetAlert2 tidak ditemukan. Pastikan Anda telah memuat library SweetAlert2.');
        return;
    } else {
        Swal.fire({
            title: 'Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false, // Halaman tidak bisa disentuh
            allowEscapeKey: false, // Tidak bisa ditutup dengan tombol Esc
            didOpen: () => {
                Swal.showLoading(); // Tampilkan loading
            }
        });
    }
}

// Panggil fungsi disableZoom pada saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    disableZoom();
    resetZoom();
});