//upload preview

var image = document.getElementById("image");
  var imagePreview = document.getElementById("image-preview");

  image.addEventListener("change", function() {
    var file = this.files[0];

    var reader = new FileReader();
    reader.onload = function(event) {
      imagePreview.src = event.target.result;
    };
    reader.readAsDataURL(file);
  });


