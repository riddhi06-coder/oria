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
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">                                       
                        <svg class="stroke-icon">
                          <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('manage-projects.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Project Details</li>
                            </ol>
                        </nav>
                        <a href="{{ route('manage-projects.create') }}" class="btn btn-primary px-5 radius-30">+ Add Project</a>
                    </div>

                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Project Image</th>
                                    <th>Featured in Home Page</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach($projects as $key => $project)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $project->project_name }}</td>
                                        <td>
                                            @if($project->banner_image)
                                                <img src="{{ asset($project->banner_image) }}" 
                                                    alt="Project Image" 
                                                    width="100px" height="100px">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input 
                                                    style="margin-left: 20px !important;"
                                                    class="form-check-input status-toggle" 
                                                    type="checkbox" 
                                                    data-id="{{ $project->id }}" 
                                                    {{ $project->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('manage-projects.edit', $project->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('manage-projects.destroy', $project->id) }}" 
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this project?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

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


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".status-toggle").forEach(toggle => {
                    toggle.addEventListener("change", function () {
                        let projectId = this.getAttribute("data-id");
                        let newStatus = this.checked ? 1 : 0;

                        fetch(`/projects/update-status`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({ id: projectId, status: newStatus }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                alert("Something went wrong!");
                                this.checked = !this.checked; // revert toggle if update failed
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Server error!");
                            this.checked = !this.checked; // revert toggle if request failed
                        });
                    });
                });
            });
        </script>




</body>

</html>