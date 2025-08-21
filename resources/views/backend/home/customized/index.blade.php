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
											<a href="{{ route('manage-customized.index') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">Customization Details</li>
									</ol>
								</nav>

								<a href="{{ route('manage-customized.create') }}" class="btn btn-primary px-5 radius-30">+ Add Customization</a>
							</div>


                    <div class="table-responsive custom-scrollbar">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customizedSections as $index => $item)
                                  <tr>
                                      <td>{{ $index + 1 }}</td>
                                      <td>{{ $item->section_title }}</td>
                                      <td>
                                          @if($item->banner_image)
                                              <img src="{{ asset($item->banner_image) }}" alt="Banner" width="300px">
                                          @endif
                                      </td>
                                      <td>
                                          <a href="{{ route('manage-customized.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                          <form action="{{ route('manage-customized.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
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

</body>

</html>