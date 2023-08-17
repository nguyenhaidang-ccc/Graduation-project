// = = = = = = = = = = = = = = = = changeImg = = = = = = = = = = = = = = = =
// function changeImg(input) {
//     //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
//         //Sự kiện file đã được load vào website
//         reader.onload = function (e) {
//             //Thay đổi đường dẫn ảnh
//             $(input).siblings('.thumbnail').attr('src', e.target.result);
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }
//Khi click #thumbnail thì cũng gọi sự kiện click #image
$(document).ready(function () {
    $('.thumbnail').click(function () {
        $(this).siblings('.image').click();
    });

    $("#addImageButton").click(function() {
        var imageInput = $("<input>", {
            type: "file",
            class: "image-input",
            name: "images[]",
            accept: "image/png, image/gif, image/jpeg"
        });

        var previewImage = $("<img>", {
            class: "preview-image",
            width: 100
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

function readURL(input, previewImage) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewImage.attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
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
