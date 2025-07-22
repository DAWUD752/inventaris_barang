</div>
    </div>

    <script>
        var btnBars = document.getElementById('btnBars');
        var sidebar = document.querySelector('.sidebar');
        // var mainContent = document.getElementById('mainContent'); // Ini tidak lagi diperlukan

        btnBars.addEventListener('click', function(e) {
            e.preventDefault();
            // Toggle kelas sidebar-show untuk menggeser sidebar masuk/keluar
            sidebar.classList.toggle('sidebar-show');
            // mainContent.classList.toggle('content-shifted'); // Ini tidak lagi diperlukan
        });

        // Set initial state based on screen size (optional, for better responsiveness)
        // Kita bisa mengatur sidebar agar defaultnya tersembunyi jika layar kecil
        function checkSidebar() {
            if (window.innerWidth <= 768) { // Contoh breakpoint untuk layar kecil
                sidebar.classList.remove('sidebar-show'); // Pastikan tersembunyi di awal
            } else {
                sidebar.classList.add('sidebar-show'); // Tampilkan default di layar besar
            }
        }

        // Call on load and on resize
        checkSidebar();
        window.addEventListener('resize', checkSidebar);

    </script>
</body>
</html>