<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap">
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                            + New Member Package
                        </button>
                    </div>
                </div>
            </div>
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>Package Name</th>
                                <th>Number Of Days</th>
                                {{-- <th>Package Type</th>
                                <th>Package Category</th> --}}
                                <th>Package Price</th>
                                <th>Admin Price</th>
                                <th>Description</th>
                                <th>Staff</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberPackage as $item)
                                <tr>
                                    <td>
                                        <h6>{{ $item->package_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->days }}</h6>
                                    </td>
                                    {{-- <td>
                                        <h6>{{ !empty($item->memberPackageType->package_type_name) ? $item->memberPackageType->package_type_name : 'Package type name has  been deleted' }}
                                        </h6>
                                    </td> --}}
                                    {{-- <td>
                                        <h6>{{ !empty($item->memberPackageCategories->package_category_name) ? $item->memberPackageCategories->package_category_name : 'Package categories has  been deleted' }}
                                        </h6>
                                    </td> --}}
                                    <td>
                                        <h6>{{ formatRupiah($item->package_price) }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ formatRupiah($item->admin_price) }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->description }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $item->users->full_name }}</h6>
                                    </td>
                                    <td>
                                        <div>
                                            <button type="button" class="btn light btn-warning btn-xs mb-1 btn-block"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('member-package.destroy', $item->id) }}"
                                                onclick="return confirm('Delete Member Package Data ? ')"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="btn light btn-danger btn-xs btn-block">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/column-->
        </div>
    </div>
</div>
@include('admin.member-package.create')
@include('admin.member-package.edit')
