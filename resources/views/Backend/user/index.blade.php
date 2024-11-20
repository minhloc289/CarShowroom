@extends('Backend.dashboard.layout')

@section('content') 
    <x-breadcrumbs breadcrumb="user" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xl-12">
                    <!--begin::Tables Widget 9-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Thông tin thành viên</span>
                                <span class="text-muted mt-1 fw-bold fs-7">Số lượng nhân viên | {{$employees->count()}}</span>
                            </h3>
                            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-light btn-active-primary d-flex align-items-center gap-1">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <span class="text-muted">New Member</span>
                                </a>
                            </div>                            
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="w-25px">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1" />
                                                </div>
                                            </th>
                                            <th class="min-w-150px">Tên nhân viên</th>
                                            <th class="min-w-140px hidden sm:table-cell">Vị trí</th>
                                            <th class="min-w-120px hidden lg:table-cell">Trạng thái</th>
                                            <th class="min-w-100px text-end">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-30px symbol-md-40px me-3">
                                                        <img src="{{ $employee->image ? asset('storage/' . $employee->image) : '/assets/media/avatars/150-11.jpg' }}" 
                                                             alt="user" class="w-full h-full object-cover rounded-full" />
                                                    </div>
                                                    <div>
                                                        <a href="javascript:void(0);" 
                                                           class="text-dark fw-bolder text-hover-primary fs-6"
                                                           onclick="showEmployeeDetails({{ $employee->id }})">
                                                           {{ $employee->name }}
                                                        </a>
                                                        <span class="text-muted d-block fs-7">{{ $employee->description ?? 'Chưa cập nhật thông tin' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="hidden sm:table-cell">
                                                <span class="text-dark fw-bolder text-hover-primary d-block fs-6">
                                                    {{ $employee->is_quanly ? 'Quản lý' : 'Nhân viên' }}
                                                </span>
                                                <span class="text-muted d-block fs-7">{{ $employee->position }}</span>
                                            </td>
                                            <td class="hidden lg:table-cell text-end">
                                                <div class="progress h-6px w-100">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{route('user.edit', $employee->id)}}" class="btn btn-sm btn-light me-2">Edit</a>
                                                    <form action="{{ route('user.delete', $employee->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa nhân viên này?');" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Employee Detail Modal -->
                            <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered w-full max-w-lg md:max-w-2xl lg:max-w-4xl">
                                    <div class="modal-content rounded-lg shadow-lg bg-white">
                                        <div class="modal-header border-0 pb-3">
                                            <h5 class="modal-title font-semibold text-lg" id="employeeDetailModalLabel">Thông tin chi tiết nhân viên</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body px-4 md:px-6 py-4">
                                            <div id="employeeDetailContent" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="col-span-2 flex items-center space-x-4 mb-4">
                                                    <div class="w-16 h-16 rounded-full overflow-hidden">
                                                        <img id="employeeImage" src="/assets/media/avatars/150-11.jpg" alt="user" class="w-full h-full object-cover">
                                                    </div>
                                                    <div>
                                                        <h4 id="employeeName" class="font-bold text-lg md:text-xl text-gray-800">Loading...</h4>
                                                        <p id="employeePosition" class="text-gray-500 text-sm md:text-base">Loading...</p>
                                                    </div>
                                                </div>
                                                <!-- Responsive fields -->
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Email</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800 text-sm md:text-base" id="employeeEmail">Loading...</div>
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Phone</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800 text-sm md:text-base" id="employeePhone">Loading...</div>
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Address</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800 text-sm md:text-base" id="employeeAddress">Loading...</div>
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="text-gray-600 font-medium">Description</label>
                                                    <div class="p-2 border rounded-md bg-gray-100 text-gray-800 text-sm md:text-base" id="employeeDescription">Loading...</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-start bg-gray-100 border-0 py-3 px-6">
                                            <button type="button" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <!--end::Employee Detail Modal-->

                            <!--end::Table container-->
                            <div class="d-flex flex-wrap justify-content-end mt-5">
                                {{ $employees->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 9-->
                </div>
            </div>
        </div>
    </div>
@endsection