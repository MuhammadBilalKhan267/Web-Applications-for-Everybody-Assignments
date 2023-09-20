<!DOCTYPE html>
<html>
<head>
    <title>Autocomplete Test</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            console.log("Document ready"); // Debugging statement
            $('.school').autocomplete({
                source: 'school.php',
                minLength: 1,
                select: function(event, ui) {
                    // Handle the selected item if needed
                    console.log("Item selected:", ui.item.value); // Debugging statement
                }
            });
            console.log("Autocomplete initialized"); // Debugging statement
        });
    </script>
</head>
<body>
    <label for="school">School:</label>
    <input type="text" id="school" name="school" class="school">
</body>
</html>
