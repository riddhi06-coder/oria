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
                  <h4>Add Our Partners Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-our-partners.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Our Partners</li>
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
                        <h4>Our Partners Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-our-partners.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!--Section Title -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_title">Section Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_title" type="text" name="section_title" placeholder="Enter Section Title" required>
                                            <div class="invalid-feedback">Please enter a Section Title.</div>
                                        </div>

                                        <!-- Banner Image -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp" required>
                                             <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                            <br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>


                                            <div class="mt-2">
                                                <img id="banner_preview" src="#" alt="Banner Preview" style="display: none; max-height: 150px; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                                            </div>

                                        </div>


                                        <!-- Section Description -->
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label" for="section_description">Section Description <span class="txt-danger">*</span></label>
                                            <textarea class="form-control" id="editor" name="section_description" rows="4" placeholder="Enter Section Description" required></textarea>
                                            <div class="invalid-feedback">Please enter a Section Description.</div>
                                        </div>


                                        <!-- Gallery Image Upload -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <h5 class="mb-4" style="margin-top: 40px;"><strong>Partner Details</strong></h5>
                                            <table class="table table-bordered p-3" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Uploaded Gallery Image: <span class="text-danger">*</span></th>
                                                        <th>Preview</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="file" onchange="previewGalleryImage(this, 0)" accept=".png, .jpg, .jpeg, .webp" name="gallery_image[]" id="gallery_image_0" class="form-control" placeholder="Upload Gallery Image" multiple required>
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                                            <br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                        </td>
                                                        <td>
                                                            <div id="gallery-preview-container-0"></div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" id="addGalleryRow">Add More</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-our-partners.index') }}" class="btn btn-danger px-4">Cancel</a>
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

    <!--Gallery Image Preview & Add More Option-->
    <script>
        $(document).ready(function () {
            let rowId = 0;

            // Add a new gallery image row
            $('#addGalleryRow').click(function () {
                rowId++;
                const newRow = `
                    <tr>
                        <td>
                            <input type="file" onchange="previewGalleryImage(this, ${rowId})" accept=".png, .jpg, .jpeg, .webp" name="gallery_image[]" id="gallery_image_${rowId}" class="form-control" placeholder="Upload Gallery Image">
                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                            <br>
                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                        </td>
                        <td>
                            <div id="gallery-preview-container-${rowId}"></div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removeGalleryRow">Remove</button>
                        </td>
                    </tr>`;
                $('#galleryTable tbody').append(newRow);
            });

            // Remove a gallery image row
            $(document).on('click', '.removeGalleryRow', function () {
                $(this).closest('tr').remove();
            });
        });

        // Preview function for gallery images
        function previewGalleryImage(input, rowId) {
            const file = input.files[0];
            const previewContainer = document.getElementById(`gallery-preview-container-${rowId}`);

            // Clear previous preview
            previewContainer.innerHTML = '';

            if (file) {
                const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                if (validImageTypes.includes(file.type)) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Create an image element for preview
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '120px';
                        img.style.maxHeight = '100px';
                        img.style.objectFit = 'cover';

                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                } else {
                    previewContainer.innerHTML = '<p>Unsupported file type</p>';
                }
            }
        }
    </script>


    <script>
        document.getElementById('banner_image').addEventListener('change', function(event) {
            const preview = document.getElementById('banner_preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        });
    </script>



</body>

</html>