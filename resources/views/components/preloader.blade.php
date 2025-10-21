<div id="preloader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white dark:bg-gray-900">
    <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
</div>


<script>
    // Hide preloader after page loads
    window.addEventListener("load", () => {
        document.getElementById("preloader").style.display = "none";
    });
</script>
