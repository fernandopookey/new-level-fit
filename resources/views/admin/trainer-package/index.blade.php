<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title flex-wrap">
                    <div class="input-group search-area mb-md-0 mb-3">
                        <input type="text" class="form-control" placeholder="Search here...">
                        <span class="input-group-text"><a href="javascript:void(0)">
                                <svg width="15" height="15" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.5605 15.4395L13.7527 11.6317C14.5395 10.446 15 9.02625 15 7.5C15 3.3645 11.6355 0 7.5 0C3.3645 0 0 3.3645 0 7.5C0 11.6355 3.3645 15 7.5 15C9.02625 15 10.446 14.5395 11.6317 13.7527L15.4395 17.5605C16.0245 18.1462 16.9755 18.1462 17.5605 17.5605C18.1462 16.9747 18.1462 16.0252 17.5605 15.4395V15.4395ZM2.25 7.5C2.25 4.605 4.605 2.25 7.5 2.25C10.395 2.25 12.75 4.605 12.75 7.5C12.75 10.395 10.395 12.75 7.5 12.75C4.605 12.75 2.25 10.395 2.25 7.5V7.5Z"
                                        fill="#01A3FF" />
                                </svg>
                            </a></span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalAdd">
                            + New Trainer Package
                        </button>
                    </div>
                </div>
            </div>
            <!--column-->
            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                <div class="table-responsive full-data">
                    <table class="table-responsive-lg table display dataTablesCard student-tab dataTable no-footer"
                        id="example-student">
                        <thead>
                            <tr>
                                <th class="text-center">Package Name</th>
                                <th class="text-center">Package Type</th>
                                <th class="text-center">Number Of Session</th>
                                <th class="text-center">Expired Session</th>
                                <th class="text-center">Package Price</th>
                                <th class="text-center">Admin Price</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainerPackage as $item)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="mb-0">{{ $item->package_name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        {{ !empty($item->trainerPackageType->package_type_name) ? $item->trainerPackageType->package_type_name : 'Package type name has  been deleted' }}
                                    </td>
                                    <td class="text-center">{{ $item->number_of_session }}</td>
                                    <td class="text-center">{{ $item->expired_session }}</td>
                                    <td class="text-center">
                                        {{ formatRupiah($item->package_price) }}
                                    </td>
                                    <td class="text-center">
                                        {{ formatRupiah($item->admin_price) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->description }}
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <button type="button" class="btn light btn-warning btn-xs mb-1"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('trainer-package.destroy', $item->id) }}"
                                                onclick="return confirm('Delete Member Package Data ? ')"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit"
                                                    class="btn light btn-danger btn-xs">Delete</button>
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
@include('admin.trainer-package.create')
@include('admin.trainer-package.edit')
