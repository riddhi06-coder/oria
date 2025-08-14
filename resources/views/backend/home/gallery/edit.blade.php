<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
</head>
	   
		@include('components.backend.header')

	    <!--start sidebar wrapper-->	
	    @include('components.backend.sidebar')
	   <!--end sidebar wrapper-->


        <div class="page-body">

          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Edit Gallery Images Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-gallery.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Gallery Images</li>
                </ol>

                </div>
              </div>
            </div>
          </div>

          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>Gallery Images Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">

                                    <form class="row g-3 needs-validation custom-input" novalidate 
                                        action="{{ route('manage-gallery.update', $banner_details->id) }}" 
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Title -->
                                        <div class="col-md-6 mt-5">
                                            <label class="form-label" for="title"> Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="title" type="text" name="title" 
                                                placeholder="Enter Title"
                                                value="{{ old('title', $banner_details->title) }}" required>
                                            <div class="invalid-feedback">Please enter a Title.</div>
                                        </div>

                                        <!-- Gallery Table -->
                                       <div class="col-md-12 mt-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <label class="form-label mb-0">Gallery Images</label>
                                                <button type="button" class="btn btn-success" id="addRowBtn">Add Row</button>
                                            </div>

                                            <table class="table table-bordered" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:40%">Upload Image <span class="txt-danger">*</span></th>
                                                        <th style="width:40%">Preview</th>
                                                        <th style="width:20%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($banner_details->images))
                                                        @foreach(json_decode($banner_details->images) as $image)
                                                            <tr>
                                                                <td>
                                                                    <input type="file" name="images[]" class="form-control image-input" accept="image/*">
                                                                    <div class="invalid-feedback">Please upload a Image.</div>
                                                                    <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                                    <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                                </td>
                                                                <td class="text-center">
                                                                    <img src="{{ asset($image) }}" alt="Preview" class="img-thumbnail" style="max-width: 250px;">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger removeRow" data-image="{{ $image }}">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <input type="file" name="images[]" class="form-control image-input" accept="image/*" required>
                                                                <div class="invalid-feedback">Please upload a Image.</div>
                                                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                            </td>
                                                            <td class="text-center">
                                                                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 250px; display: none;">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger removeRow">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>

                                            </table>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-gallery.index') }}" class="btn btn-danger px-4">Cancel</a>
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

          </div>
        </div>
        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>


       
       @include('components.backend.main-js')


<!-- Script -->
<script>
   document.addEventListener("DOMContentLoaded", function () {
    let galleryTable = document.getElementById("galleryTable").getElementsByTagName("tbody")[0];
    let addRowBtn = document.getElementById("addRowBtn");

    // Preview uploaded image
    function previewImage(input) {
        let file = input.files[0];
        let img = input.closest("tr").querySelector("img");
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                img.style.display = "block";
            }
            reader.readAsDataURL(file);
        } else {
            img.src = "";
            img.style.display = "none";
        }
    }

    galleryTable.addEventListener("change", function (e) {
        if (e.target.classList.contains("image-input")) {
            previewImage(e.target);
        }
    });

    // Add new row
    addRowBtn.addEventListener("click", function () {
        let newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>
                <input type="file" name="images[]" class="form-control image-input" accept="image/*" required>
                 <div class="invalid-feedback">Please upload a Image.</div>
                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
            </td>
            <td class="text-center">
                <img src="" alt="Preview" class="img-thumbnail" style="max-width: 250px; display: none;">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger removeRow">Remove</button>
            </td>
        `;
        galleryTable.appendChild(newRow);
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        let row = $(this).closest('tr');
        let imagePath = $(this).data('image');

        // Append a hidden input for deleted image
        $('<input>').attr({
            type: 'hidden',
            name: 'deleted_images[]',
            value: imagePath
        }).appendTo('form');

        // Hide the row from table
        row.hide();
    });



  

});

</script>

</body>

</html>