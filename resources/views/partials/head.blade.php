<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- "Overpass" Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
	<!-- CSS Stylesheet -->
	<link rel="stylesheet" href="/style.css" />
	<title>Summer Sanity</title>
	
	<script src="https://cdn.jsdelivr.net/gh/tofsjonas/sortable@latest/dist/sortable.min.js"></script>
	<link href="https://cdn.jsdelivr.net/gh/tofsjonas/sortable@latest/sortable-base.min.css" rel="stylesheet" />

	<link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">
	<script src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<link rel="icon" type="image/x-icon" href="/favicon.ico">

	<script>
		function showLoginModal() {			
			document.getElementById("login-modal-overlay").classList.remove("hide");
		}

		function hideLoginModal() {
			document.getElementById("login-modal-overlay").classList.add("hide");
		}

		// Optional: close modal on escape
		document.addEventListener("keyup", function (e) {
			if (e.key === "Escape") hideLoginModal();
		});
	</script>
</head>