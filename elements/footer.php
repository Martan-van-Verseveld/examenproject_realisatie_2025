</main>
<script>
    if (document.querySelector('main > .sidebar')) {
        document.querySelector('main').classList.add('has-sidebar');
    }

    document.querySelectorAll('.bi').forEach(icon => {
        const normalClass = icon.classList[1];
        const fillClass = `bi-${normalClass.replace('bi-', '')}-fill`;
        icon.addEventListener('mouseover', () => icon.classList.replace(normalClass, fillClass));
        icon.addEventListener('mouseout', () => icon.classList.replace(fillClass, normalClass));
    });

    // JavaScript to toggle dropdown visibility
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('.dropdown_click');
        const content = dropdown.querySelector('.dropdown-content');

        // Toggle dropdown visibility on button click
        button.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent event from bubbling to the window
            content.style.display = content.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                content.style.display = 'none';
            }
        });
    });
</script>
</html>