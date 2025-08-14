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
                  <h4>Add Gallery Images Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-gallery.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Gallery Images</li>
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

                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-gallery.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!--  Title-->
                                        <div class="col-md-6 mt-5">
                                            <label class="form-label" for="title"> Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="title" type="text" name="title" placeholder="Enter Title" value="{{ old('title') }}" required>
                                            <div class="invalid-feedback">Please enter a Title.</div>
                                        </div>


                                        <!-- Gallery Table -->
                                        <div class="col-md-12 mt-4">
                                            <label class="form-label">Gallery Images</label>
                                            <table class="table table-bordered" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:40%">Upload Image <span class="txt-danger">*</span></th>
                                                        <th style="width:40%">Preview</th>
                                                        <th style="width:20%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                            <button type="button" class="btn btn-success addRow"> Add Row</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-gallery.index') }}" class="btn btn-danger px-4">Cancel</a>
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


<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let galleryTable = document.getElementById("galleryTable").getElementsByTagName("tbody")[0];

        // Image preview
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

        // Delegate change event for preview
        galleryTable.addEventListener("change", function (e) {
            if (e.target.classList.contains("image-input")) {
                previewImage(e.target);
            }
        });

        // Add Row
        galleryTable.addEventListener("click", function (e) {
            if (e.target.classList.contains("addRow")) {
                let newRow = e.target.closest("tr").cloneNode(true);

                // Reset input values in new row
                newRow.querySelector(".image-input").value = "";
                let img = newRow.querySelector("img");
                img.src = "";
                img.style.display = "none";

                // Change button to remove
                let btn = newRow.querySelector(".addRow");
                btn.classList.remove("btn-success", "addRow");
                btn.classList.add("btn-danger", "removeRow");
                btn.textContent = "Remove";

                galleryTable.appendChild(newRow);
            }

            // Remove Row
            if (e.target.classList.contains("removeRow")) {
                e.target.closest("tr").remove();
            }
        });
    });
</script>

</body>

</html>