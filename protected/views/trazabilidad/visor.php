<div id="output" class='col-md-12'></div>
<script type="text/javascript">
	$(function () {
		//loadImage('<? echo $_GET['path']; ?>');
		loadImage('<? echo $path; ?>');
	});
	function loadImage(filename) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', filename);
		xhr.responseType = 'arraybuffer';
		xhr.onload = function (e) {
			var buffer = xhr.response;
			var tiff = new Tiff({buffer: buffer});
			var canvas = tiff.toCanvas();
			canvas.style.width  = '100%';
			canvas.style.height = '100%';
		  	$('#output').append(canvas);
		};
		xhr.send();
	};
</script>
