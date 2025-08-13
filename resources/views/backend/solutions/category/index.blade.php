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
                                    <a href="{{ route('manage-category.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Category</li>
                            </ol>
                        </nav>

                        <a href="{{ route('manage-category.create') }}" class="btn btn-primary px-5 radius-30">+ Add Category</a>
                    </div>

                    <div class="table-responsive custom-scrollbar">
                        <div class="d-flex justify-content-end mb-2">
                            <div style="width: 300px;">
                                <input type="text" id="categorySearch" placeholder="Search Solution Type or Category" class="form-control">
                            </div>
                        </div>
                       <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Thumbnail Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($applications as $appType => $groupedCategories)
                                    <tr>
                                        <td colspan="5" style="font-weight: bold; background: #f0f0f0;">Solution Type: {{ $appType }}</td>
                                    </tr>
                                    @foreach($groupedCategories as $key => $application)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $application->category }}</td>
                                            <td>
                                                @if($application->thumbnail_image)
                                                    <img src="{{ asset($application->thumbnail_image) }}" alt="Image" style="height: 130px;">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('manage-category.edit', $application->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('manage-category.destroy', $application->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
    document.getElementById('categorySearch').addEventListener('input', function () {
        const filter = this.value.trim().toLowerCase();
        const table = document.getElementById('basic-1');
        if (!table) return;

        const rows = Array.from(table.tBodies[0].rows);
        let i = 0;

        while (i < rows.length) {
            const row = rows[i];
            const firstCell = row.cells[0];
            const isAppTypeHeader = firstCell && firstCell.colSpan > 1 && row.textContent.toLowerCase().includes('solution type');

            if (isAppTypeHeader) {
                const appTypeRow = row;
                const appTypeText = appTypeRow.textContent.replace(/^solution type:\s*/i, '').toLowerCase();
                let appTypeHasMatch = false;

                i++;

                // Process category rows under this solution type
                while (i < rows.length && !(rows[i].cells[0] && rows[i].cells[0].colSpan > 1 && rows[i].textContent.toLowerCase().includes('solution type'))) {
                    const catRow = rows[i];
                    const categoryText = (catRow.cells[1]?.textContent || '').toLowerCase();

                    if (filter === '') {
                        catRow.style.display = '';
                        appTypeHasMatch = true;
                    } else if (appTypeText.includes(filter)) {
                        catRow.style.display = '';
                        appTypeHasMatch = true;
                    } else if (categoryText.includes(filter)) {
                        catRow.style.display = '';
                        appTypeHasMatch = true;
                    } else {
                        catRow.style.display = 'none';
                    }

                    i++;
                }

                // Show/hide the Application Type header
                appTypeRow.style.display = appTypeHasMatch ? '' : 'none';
            } else {
                i++;
            }
        }
    });
</script>

</body>

</html>