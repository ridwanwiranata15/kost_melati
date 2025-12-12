
// Fungsi Utama untuk Toggle Modal
    function toggleModal(modalID, show) {
        const modal = document.getElementById(modalID);

        if (show) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Kunci scroll background
        } else {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Lepas kunci scroll
        }
    }

    // --- INTEGRASI LIVEWIRE ---

    // Dengarkan event dari Controller PHP saat data berhasil disimpan
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', (event) => {
            toggleModal('modalCreateKamar', false);

            // Opsional: Tampilkan notifikasi sukses sederhana
            alert('Data berhasil disimpan!');
        });
    });

    // Menutup modal jika user klik di area gelap (overlay)
    window.onclick = function(event) {
        const modal = document.getElementById('modalCreateKamar');
        if (event.target == modal) {
            toggleModal('modalCreateKamar', false);
        }
    }
