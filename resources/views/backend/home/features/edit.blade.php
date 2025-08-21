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
                  <h4>Add Features Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-our-features.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Features</li>
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
                        <h4>Features Form</h4>
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
                                        action="{{ route('manage-our-features.update', $feature->id) }}" 
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Section Title -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_title">Section Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_title" type="text" 
                                                name="section_title" value="{{ old('section_title', $feature->section_title) }}" 
                                                placeholder="Enter Section Title" required>
                                            <div class="invalid-feedback">Please enter a Section Title.</div>
                                        </div>

                                        <!-- Gallery Images -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0" style="margin-top:40px;"><strong>Partner Details</strong></h5>
                                                <button type="button" class="btn btn-primary" id="addGalleryRow">Add More</button>
                                            </div>
                                            <table class="table table-bordered p-3" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Uploaded Gallery Image: <span class="text-danger">*</span></th>
                                                        <th>Preview</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($galleryImages))
                                                        @foreach($galleryImages as $key => $img)
                                                            <tr>
                                                                <td>
                                                                    <input type="file" onchange="previewGalleryImage(this, {{ $key }})" 
                                                                        accept=".png,.jpg,.jpeg,.webp" name="gallery_image_new[]" 
                                                                        id="gallery_image_{{ $key }}" class="form-control">
                                                                        <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                                                        <br>
                                                                        <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                                                                        <input type="hidden" name="gallery_image_existing[]" value="{{ $img }}">
                                                                    </td>
                                                                <td>
                                                                    <div id="gallery-preview-container-{{ $key }}">
                                                                        <img src="{{ asset($img) }}" alt="Gallery" style="height: 80px;">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger removeGalleryRow">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <input type="file" onchange="previewGalleryImage(this, 0)" 
                                                                    accept=".png,.jpg,.jpeg,.webp" name="gallery_image[]" 
                                                                    id="gallery_image_0" class="form-control" required>
                                                            </td>
                                                            <td><div id="gallery-preview-container-0"></div></td>
                                                            <td><button type="button" class="btn btn-primary" id="addGalleryRow">Add More</button></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Company Features -->
                                        <div class="table-container" style="margin-bottom: 20px;">
                                            <h5 class="mb-4" style="margin-top: 40px;"><strong>Company Features</strong></h5>
                                            <table class="table table-bordered p-3" id="infoTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Title <span class="text-danger">*</span></th>
                                                        <th>Information <span class="text-danger">*</span></th>
                                                        <th>Description <span class="text-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($companyFeatures))
                                                        @foreach($companyFeatures as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="info_title[]" class="form-control" 
                                                                        value="{{ $item['title'] ?? '' }}" required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="info_information[]" class="form-control" 
                                                                        value="{{ $item['information'] ?? '' }}" required>
                                                                </td>
                                                                <td>
                                                                    <textarea name="info_description[]" class="form-control" rows="2" required>{{ $item['description'] ?? '' }}</textarea>
                                                                </td>
                                                                <td>
                                                                    @if($loop->first)
                                                                        <button type="button" class="btn btn-primary" id="addInfoRow">Add More</button>
                                                                    @else
                                                                        <button type="button" class="btn btn-danger removeInfoRow">Remove</button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="info_title[]" class="form-control" required></td>
                                                            <td><input type="text" name="info_information[]" class="form-control" required></td>
                                                            <td><textarea name="info_description[]" class="form-control" rows="2" required></textarea></td>
                                                            <td><button type="button" class="btn btn-primary" id="addInfoRow">Add More</button></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-our-features.index') }}" class="btn btn-danger px-4">Cancel</a>
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

    <!--Gallery Image Preview & Add More Option-->
    <script>

        $(document).ready(function () {
            // Initialize rowId based on existing rows in the table
            let rowId = $('#galleryTable tbody tr').length;

            // Add a new gallery image row
            $('#addGalleryRow').click(function () {
                rowId++;
                const newRow = `
                    <tr>
                        <td>
                            <input type="file" onchange="previewGalleryImage(this, ${rowId})" 
                                accept=".png,.jpg,.jpeg,.webp" name="gallery_image[]" 
                                id="gallery_image_${rowId}" class="form-control" placeholder="Upload Gallery Image">
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
        $(document).ready(function () {
            let infoRowId = 0;

            // Add a new info row
            $(document).on('click', '#addInfoRow', function () {
                infoRowId++;
                const newRow = `
                    <tr>
                        <td>
                            <input type="text" name="info_title[]" class="form-control" placeholder="Enter Title" required>
                        </td>
                        <td>
                            <input type="text" name="info_information[]" class="form-control" placeholder="Enter Information" required>
                        </td>
                        <td>
                            <textarea name="info_description[]" class="form-control" placeholder="Enter Description" rows="2" required></textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removeInfoRow">Remove</button>
                        </td>
                    </tr>`;
                $('#infoTable tbody').append(newRow);
            });

            // Remove an info row
            $(document).on('click', '.removeInfoRow', function () {
                $(this).closest('tr').remove();
            });
        });
    </script>

</body>

</html>