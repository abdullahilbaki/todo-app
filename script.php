<script>
    function validateForm() {
        var title = document.getElementById("task").value;
        var maxLength = 255;
        if (title.length > maxLength) {
            var excessChars = title.length - maxLength;
            alert("Error: Title is too long. Maximum " + maxLength + " characters allowed. You exceeded the limit by " + excessChars + " characters.");
            return false;
        }
        return true;
    }

    const textarea = document.getElementById('description');

    textarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });

    textarea.dispatchEvent(new Event('input'));
</script>