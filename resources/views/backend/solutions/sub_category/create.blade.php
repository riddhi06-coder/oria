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
                  <h4>Add Sub Category Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-sub-category.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Sub Category Details</li>
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
                        <h4>Sub Category Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">

                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-sub-category.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Banner Title-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Banner Title </label>
                                            <input class="form-control" id="banner_title" type="text" name="banner_title" placeholder="Enter Banner Title">
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>

                                       <!-- Banner Image-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image </label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload a Banner Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- 🔍 Image Preview (moved below input) -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Solution Type -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="solution_type">Solution Type <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="solution_type" name="solution_type">
                                                <option value="">-- Select Solution Type --</option>
                                                @foreach($applications as $application)
                                                    <option value="{{ $application->id }}" {{ old('solution_type') == $application->id ? 'selected' : '' }}>
                                                        {{ $application->solution_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Solution Type.</div>
                                        </div>


                                        <!-- Category -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="parent_category">Category <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="parent_category">
                                                <option value="">Select Category</option>
                                            </select>
                                            <input type="hidden" name="parent_category" id="parent_category_hidden" value="{{ old('parent_category') }}">
                                            <div class="invalid-feedback">Please select a Category.</div>
                                        </div>

                                        <!-- Product -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="sub_category">Sub Category <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="sub_category" type="text" name="sub_category" placeholder="Enter Sub Category" required>
                                            <div class="invalid-feedback">Please enter a Category.</div>
                                        </div>


                                        <!-- Banner Image-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="thumbnail_image">Thumbnail Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="thumbnail_image" type="file" name="thumbnail_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewThumbnailImage()" required>
                                            <div class="invalid-feedback">Please upload a Thumbnail Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- 🔍 Image Preview (moved below input) -->
                                            <div id="thumbnailImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="thumbnail_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end mt-3">
                                            <a href="{{ route('manage-sub-category.index') }}" class="btn btn-danger px-4">Cancel</a>
                                            <button class="btn btn-primary" type="submit">Submit</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function previewBannerImage() {
        const file = document.getElementById('banner_image').files[0];
        const previewContainer = document.getElementById('bannerImagePreviewContainer');
        const previewImage = document.getElementById('banner_image_preview');

        // Clear the previous preview
        previewImage.src = '';
        
        if (file) {
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            if (validImageTypes.includes(file.type)) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Display the image preview
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';  // Show the preview section
                };

                reader.readAsDataURL(file);
            } else {
                alert('Please upload a valid image file (jpg, jpeg, png, webp).');
            }
        }
    }

    function previewThumbnailImage() {
        const file = document.getElementById('thumbnail_image').files[0];
        const previewContainer = document.getElementById('thumbnailImagePreviewContainer');
        const previewImage = document.getElementById('thumbnail_image_preview');

        // Clear the previous preview
        previewImage.src = '';
        
        if (file) {
            const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

            if (validImageTypes.includes(file.type)) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';  // Show the preview section
                };

                reader.readAsDataURL(file);
            } else {
                alert('Please upload a valid image file (jpg, jpeg, png, webp).');
            }
        }
    }
</script>



<script>
    const categories = @json($categories);

    document.getElementById('solution_type').addEventListener('change', function () {
        let appId = this.value;
        let categoryDropdown = document.getElementById('parent_category');
        let hiddenInput = document.getElementById('parent_category_hidden');

        categoryDropdown.innerHTML = '<option value="">Select Category</option>';

        if (appId) {
            let filtered = categories.filter(cat => cat.solution_id == appId);

            filtered.forEach(cat => {
                categoryDropdown.innerHTML += `<option value="${cat.id}">${cat.category}</option>`;
            });

            categoryDropdown.disabled = false;
        } else {
            categoryDropdown.disabled = true;
        }

        categoryDropdown.addEventListener('change', function () {
            hiddenInput.value = this.value;
        });
    });
</script>




</body>

</html>