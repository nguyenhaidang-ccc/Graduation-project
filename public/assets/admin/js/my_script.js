// Ajax setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('.thumbnail').click(function () {
        $(this).siblings('.image').click();
    });

    $("#addImageButton").click(function() {
        var imageInput = $("<input>", {
            type: "file",
            class: "image-input",
            name: "images[]",
            accept: "image/png, image/gif, image/jpeg, image/webp"
        });

        var previewImage = $("<img>", {
            class: "preview-image",
            width: 100,
            src: ''
        });

        var imageDiv = $("<div>", {
            class: "image-container mt-2",
            html: [imageInput, previewImage]
        });

        $("#imageContainer").append(imageDiv);
        
        imageInput.change(function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });



});

function previewThumbnail(input) {
    var file = input.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(".preview-thumbnail").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    }
    
}


function addSection(){
    var inputGroup = $("<div>", {
        html: `
            <div class="position-relative row form-group input-section">
                <label for="size"
                    class="col-md-3 text-md-right col-form-label">Size</label>
                <div class="col-md-2 col-xl-2">
                    <input name="sizes[]" id="size"
                        placeholder="Size" type="number" class="form-control" value="">
                </div>
                <label for="sku"
                    class="col-md-3 text-md-right col-form-label">Quantity</label>
                <div class="col-md-2 col-xl-2">
                    <input name="quantities[]" id="quantity"
                        placeholder="Quantity" type="number" class="form-control" value="">
                </div>
                <div class="pl-2 d-flex align-items-center deleteButton">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
            </div>
        `
    });

    $("#input-container").append(inputGroup);
};

$(document).on("click", ".deleteButton", function() {
    $(this).closest(".input-section").remove();
});
